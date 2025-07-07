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



    public static function generateOrderRef()
    {
       $latest = DB::table('orders')->select('order_ref')->orderByDesc('id')->first();

        $number = $latest
            ? ((int) filter_var($latest->order_ref, FILTER_SANITIZE_NUMBER_INT)) + 1
            : 1;

        return 'ORD-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

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
