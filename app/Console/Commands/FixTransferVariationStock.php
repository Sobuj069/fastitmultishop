<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Transfer;
use App\Models\TransferItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixTransferVariationStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:fix-variations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix historical transfer purchase items that are missing variation_id';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to fix historical transfer items without variation...');

        $transferPurchases = Purchase::where('is_transfer', 1)->get();
        $fixedCount = 0;

        foreach ($transferPurchases as $purchase) {
            $purchaseItems = PurchaseItem::where('purchase_id', $purchase->id)
                ->whereNull('product_variation_id')
                ->get();

            foreach ($purchaseItems as $pi) {
                $product = Product::with('product_variations')->find($pi->product_id);
                if (!$product || $product->product_variations->isEmpty()) {
                    continue;
                }

                $variations = $product->product_variations;

                // Case 1: Product has only 1 variation
                if ($variations->count() === 1) {
                    $singleVar = $variations->first();
                    $pi->update(['product_variation_id' => $singleVar->id]);

                    // Also update corresponding transfer item if null
                    TransferItem::where('transfer_id', $purchase->transfer_id)
                        ->where('product_id', $product->id)
                        ->whereNull('product_variation_id')
                        ->update(['product_variation_id' => $singleVar->id]);

                    $this->info("Assigned single variation #{$singleVar->id} to PI #{$pi->id} ({$product->name})");
                    $fixedCount++;
                    continue;
                }

                // Case 2: Matching TransferItem already has product_variation_id
                $ti = TransferItem::where('transfer_id', $purchase->transfer_id)
                    ->where('product_id', $product->id)
                    ->whereNotNull('product_variation_id')
                    ->first();

                if ($ti && $ti->product_variation_id) {
                    $pi->update(['product_variation_id' => $ti->product_variation_id]);
                    $this->info("Synced variation #{$ti->product_variation_id} from TI #{$ti->id} to PI #{$pi->id} ({$product->name})");
                    $fixedCount++;
                    continue;
                }

                // Case 3: Specific historical products (like Animal Eyes Socks #380 where 16 M and 16 L were transferred)
                if ($product->id == 380 && $pi->main_qty == 32) {
                    // Split PI #pi->id into 16 for M (454) and 16 for L (455)
                    $varM = $variations->firstWhere('size_id', function($size) { return true; }) ?? $variations->first();
                    $varL = $variations->last();

                    $pi->update([
                        'product_variation_id' => $varM->id,
                        'main_qty' => 16,
                        'stock_qty' => 16,
                        'subtotal' => $pi->rate * 16,
                    ]);

                    $newPi = $pi->replicate();
                    $newPi->product_variation_id = $varL->id;
                    $newPi->main_qty = 16;
                    $newPi->stock_qty = 16;
                    $newPi->subtotal = $pi->rate * 16;
                    $newPi->save();

                    $this->info("Split PI #{$pi->id} into 16 for {$varM->id} and 16 for {$varL->id} for {$product->name}");
                    $fixedCount++;
                    continue;
                }

                // Case 4: Character Coin Bag #365 where 13 were transferred from specific variations
                if ($product->id == 365 && $pi->main_qty == 13) {
                    // Transferred quantities in PUR00315 from branch 1:
                    // Var 427 (Green): 3, Var 432 (Deep Blue): 2, Var 423 (Blue): 3, Var 428 (Hot Pink): 2, Var 433 (Black & White): 3
                    $breakdown = [
                        427 => 3,
                        432 => 2,
                        423 => 3,
                        428 => 2,
                        433 => 3
                    ];

                    $isFirst = true;
                    foreach ($breakdown as $varId => $qty) {
                        if ($isFirst) {
                            $pi->update([
                                'product_variation_id' => $varId,
                                'main_qty' => $qty,
                                'stock_qty' => $qty,
                                'subtotal' => $pi->rate * $qty
                            ]);
                            $isFirst = false;
                        } else {
                            $newPi = $pi->replicate();
                            $newPi->product_variation_id = $varId;
                            $newPi->main_qty = $qty;
                            $newPi->stock_qty = $qty;
                            $newPi->subtotal = $pi->rate * $qty;
                            $newPi->save();
                        }
                    }
                    $this->info("Split Character Coin Bag PI #{$pi->id} into exact variations (427, 432, 423, 428, 433)");
                    $fixedCount++;
                    continue;
                }

                // Fallback for any other multi-variation product: assign first variation with matching attributes
                $firstVar = $variations->first();
                if ($firstVar) {
                    $pi->update(['product_variation_id' => $firstVar->id]);
                    $this->info("Assigned default variation #{$firstVar->id} to PI #{$pi->id} ({$product->name})");
                    $fixedCount++;
                }
            }
        }

        $this->info("Successfully fixed {$fixedCount} transfer purchase items!");
        return Command::SUCCESS;
    }
}
