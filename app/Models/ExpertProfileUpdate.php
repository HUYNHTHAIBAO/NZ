<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertProfileUpdate extends Model
{
    //
    protected $table = 'lck_expert_profiles_update';
    protected $fillable = [
        'category_id_expert',
        'user_id',
        'bio',
        'facebook',
        'instagram',
    ];
}
