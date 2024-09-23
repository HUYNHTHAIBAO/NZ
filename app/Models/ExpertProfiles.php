<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertProfiles extends Model
{
    //

    protected $table = 'lck_expert_profiles';
    protected $fillable = [
        'category_id_expert',
        'user_id',
        'bio',
        'facebook',
        'instagram',
        'status', 
    ];
    public function user()
    {
        return $this->belongsTo(CoreUsers::class, 'user_id', 'id');
    }
    public function applications()
    {
        return $this->hasMany(ExpertApplications::class, 'user_id', 'user_id');
    }
    public function expertCategory()
    {
        return $this->belongsTo(ExpertCategory::class);
    }
}
