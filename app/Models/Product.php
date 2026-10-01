<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product_variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function size()
    {
        return $this->belongsTo('App\Models\ProductSize','size_id','id');
    }

    public function color()
    {
        return $this->belongsTo('App\Models\ProductColor','color_id','id');
    }

    public function product_variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warranty()
    {
        return $this->belongsTo(Warranty::class, 'warranty_id');
    }

    public function racks()
    {
        return $this->belongsToMany(Rack::class, 'product_rack', 'product_id', 'rack_id');
    }

    public function hasTransactions()
    {
        return \App\Models\PurchaseItem::where('product_id', $this->id)->exists() ||
               \App\Models\InvoiceItem::where('product_id', $this->id)->exists() ||
               \App\Models\TransferItem::where('product_id', $this->id)->exists() ||
               \App\Models\AdjustStockItem::where('product_id', $this->id)->exists() ||
               \App\Models\ReturnPurchaseItem::where('product_id', $this->id)->exists() ||
               \App\Models\ReturnItem::where('product_id', $this->id)->exists() ||
               \App\Models\UsedPurchaseItem::where('product_id', $this->id)->exists() ||
               \App\Models\UsedItem::where('product_id', $this->id)->exists() ||
               \App\Models\DamageItem::where('product_id', $this->id)->exists();
    }
}
