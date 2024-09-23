<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertApplications extends Model
{
    //
    protected $table = 'lck_expert_applications';
    protected $fillable = [
        'user_id',
        'status',
        'reason_for_refusal',
        'submitted_at',
        'reviewed_at',
    ];
    public function user()
    {
        return $this->belongsTo(CoreUsers::class);
    }
    public function expertProfile()
    {
        return $this->belongsTo(ExpertProfiles::class, 'user_id', 'user_id');
    }
}
