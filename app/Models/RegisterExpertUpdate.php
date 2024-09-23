<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterExpertUpdate extends Model
{
    //
    protected $table = 'lck_register_expert_update';
    protected $fillable = [
        'user_id',
        'bio',
        'facebook_link',
        'x_link',
        'instagram_link',
        'tiktok_link',
        'linkedin_link',
        'category_id_expert',
        'tags_id',
        'approved',
        'reason_for_refusal',
        'job',
        'advise',
        'questions',
    ];
    public function user() {
        return $this->belongsTo(CoreUsers::class);
    }
}
