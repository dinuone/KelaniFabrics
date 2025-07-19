<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ecomorder extends Model
{
    protected $table = 'ecomorders';

    protected $fillable = [
        'order_number',
        'customer_id',
        'total_amount',
        'payment_method',
        'status',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(EcomOrderItem::class, 'order_id');
    }
}
