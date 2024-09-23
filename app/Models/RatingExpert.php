<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingExpert extends Model
{
    //
    protected $table = 'lck_requestExpert_rating';
    protected $fillable = [
        'request_id',
        'user_id',
        'rating',
        'comment',
        'user_expert_id',
    ];
}
