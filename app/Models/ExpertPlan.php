<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Psy\Util\Str;

class ExpertPlan extends Model
{
    //
    const OPTION_PLAN = [
        ['id' => 1, 'name' => 'Theo tháng'],
        ['id' => 2, 'name' => 'Theo nhóm'],
    ];
    protected $table = 'lck_expert_plan';
    protected $fillable = [
        'user_id',
        'title',
        'desc',
        'price',
        'status',
        'sort',
        'option_plan', // 1 theo tháng 2 theo nhóm
        'number_people_max',
    ];
    public function user() {
        return $this->belongsTo(CoreUsers::class);
    }



    public function userExpert() {
        return $this->belongsTo(CoreUsers::class, 'user_id', 'id');
    }
}
