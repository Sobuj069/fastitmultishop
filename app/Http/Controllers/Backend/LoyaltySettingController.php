<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Cache;

class LoyaltySettingController extends Controller
{
    public function index()
    {
        if (!is_loyalty_enabled()) {
            session()->flash('error', __('Customer Loyalty & Rewards module is disabled in Super Admin Settings.'));
            return redirect()->route('dashboard');
        }

        $spendPerPoint = loyalty_spend_per_point();
        $pointPerSpend = loyalty_point_per_spend();
        $pointRate = loyalty_point_rate();
        $minRedeemPoints = loyalty_min_redeem_points();

        return view('backend.pages.loyalty.index', compact(
            'spendPerPoint',
            'pointPerSpend',
            'pointRate',
            'minRedeemPoints'
        ));
    }

    public function update(Request $request)
    {
        if (!is_loyalty_enabled()) {
            session()->flash('error', __('Customer Loyalty & Rewards module is disabled in Super Admin Settings.'));
            return redirect()->route('dashboard');
        }

        $request->validate([
            'loyalty_spend_per_point' => 'required|numeric|min:1',
            'loyalty_point_per_spend' => 'required|numeric|min:0.01',
            'loyalty_point_rate'      => 'required|numeric|min:0.01',
            'loyalty_min_redeem_points' => 'nullable|numeric|min:0',
        ]);

        $settings = [
            'loyalty_spend_per_point'   => (float)$request->loyalty_spend_per_point,
            'loyalty_point_per_spend'   => (float)$request->loyalty_point_per_spend,
            'loyalty_point_rate'        => (float)$request->loyalty_point_rate,
            'loyalty_min_redeem_points' => (float)($request->loyalty_min_redeem_points ?? 0),
        ];

        foreach ($settings as $type => $value) {
            $setting = BusinessSetting::where('type', $type)->first();
            if ($setting) {
                $setting->value = $value;
                $setting->save();
            } else {
                BusinessSetting::create([
                    'type'  => $type,
                    'value' => $value,
                ]);
            }
        }

        Cache::forget('business_settings');

        logActivity('Update Loyalty Settings', "Customer Reward settings updated: Spend {$request->loyalty_spend_per_point} Tk = {$request->loyalty_point_per_spend} pt, 1 pt = {$request->loyalty_point_rate} Tk");

        session()->flash('success', __('Customer Loyalty & Reward rules updated successfully!'));
        return redirect()->back();
    }
}
