<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryCouPon extends Model
{
    //
    protected $table = 'lck_history_coupon';
    protected $fillable = ['code' ,
        'user_id_use',
        'user_id_give',
        'point_use',
        'point_give',
        'order_id',
        'username_give',
        ];
}
