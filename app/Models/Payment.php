<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
     protected $fillable = ['order_id', 'amount', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
