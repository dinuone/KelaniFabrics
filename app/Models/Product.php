<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use  SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

   protected static function boot()
  {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->product_ref)) {
                $lastProduct = self::withTrashed()
                    ->whereNotNull('product_ref')
                    ->orderBy('product_ref', 'desc')
                    ->first();

                $lastNumber = 0;

                if ($lastProduct && preg_match('/PRO(\d+)/', $lastProduct->product_ref, $matches)) {
                    $lastNumber = (int) $matches[1];
                }

                $product->product_ref = 'PRO' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    protected static function booted()
    {
        static::deleting(function ($product) {
            if ($product->isForceDeleting()) {
                // If permanently deleting (force delete)
                $product->sizes()->detach();
                $product->colors()->detach();
            } else {
                // Still detach even when soft deleting
                $product->sizes()->detach();
                $product->colors()->detach();
            }
        });
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes', 'product_id', 'size_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_cat_id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors', 'product_id', 'color_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function availableStocks()
    {
        return $this->hasMany(Stock::class)->where('availability', 'In Stock');
    }
}
