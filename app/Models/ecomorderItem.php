<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ecomorderItem extends Model
{
    protected $table = 'ecomorder_items';

   protected $fillable = [
        'order_id', 'product_id', 'color_id', 'size_id', 'quantity', 'price'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(EcomOrder::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
