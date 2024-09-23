<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsBranchs extends Model
{
    protected $table = 'lck_products_branches';

    protected $fillable = [
        'id',
        'product_id',
        'branch_id',
        'created_at',
        'updated_at',
    ];
}
