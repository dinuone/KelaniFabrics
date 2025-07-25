<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ecomorder extends Model
{
    protected $table = 'ecomorders';



    protected $fillable = [
        'order_number',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_city',
        'customer_state',
        'customer_name',
        'customer_id',
        'payment_method',
        'status',
        'total_amount',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(EcomOrderItem::class, 'order_id');
    }
}
