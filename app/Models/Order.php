<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];



   

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
