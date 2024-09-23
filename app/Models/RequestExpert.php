<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestExpert extends Model
{
    //
    protected $table = 'lck_request_expert';
    protected $fillable = [
      'user_id',
      'user_expert_id',
      'duration_id',
      'time',
      'date',
      'status',
      'vnp_TransactionNo',
      'note',
      'note_reject',
      'order_code',
      'price',
      'payment_type_vnpay',
      'email_user',
      'email_user_expert',
      'type',
      'type_request_user',
      'time_negotiate',
      'date_negotiate',
      'rating_type',
      'fullname_form',
      'email_form',
      'note_form',
      'image_file_id_form',
      'image_file_path_form',
      'list_email',
      'sumary',
      'key',
    ];
    public function user() {
        return $this->belongsTo(CoreUsers::class, 'user_id', 'id');
    }
    public function duration() {
        return $this->belongsTo(TimeRatesDuration::class);
    }
    public function userExpert() {
        return $this->belongsTo(CoreUsers::class, 'user_expert_id', 'id');
    }
    public function thumbnail()
    {
        return $this->belongsTo(Files::class, 'image_file_id_form', 'id')->select(['id', 'file_path']);
    }
}
