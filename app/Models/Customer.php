<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use  SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

     protected $fillable = [
        'id',
        'cust_fname',
        'cust_lname',
        'contact_number',
        'email',
        'address',
        'gender',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
