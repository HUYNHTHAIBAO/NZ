<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VnpayRefund extends Model
{
    //
    protected $table = 'lck_refund';
    protected $fillable = [
        'id',
        'request_expert_id',
        'status', // 1 Yêu cầu thành công 2 yeeu càu tất bại
        'user_name',
        'vnp_ResponseCode',
        'vnp_Amount',
        'vnp_TransactionNo',
    ];

}
