<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $casts = [
        'cat_status'=>StatusEnum::class
    ];
}
