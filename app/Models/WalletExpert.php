<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletExpert extends Model
{
    //
    protected $table = 'lck_wallet_expert';
    protected $fillable = [
      'user_expert_id',
      'bank_stk',
      'bank_name',
      'name',
      'price',
      'note',
      'status',
    ];



    public function user() {
        return $this->belongsTo(CoreUsers::class, 'user_expert_id', 'id');
    }
}
