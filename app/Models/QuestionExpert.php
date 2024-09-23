<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionExpert extends Model
{
    //
    protected $table = 'lck_question_expert';
    protected $fillable = [
        'user_expert_id',
        'title',
        'desc',
        'status'
    ];

    public function userExpert()
    {
        return $this->belongsTo(CoreUsers::class);
    }
}
