<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ExpertProfileOrther extends Model
{
    //
    protected $table = 'lck_profile_orther';
    protected $fillable = [
            'user_id',
            'title',
            'image_file_id',
            'image_file_path',
            'status',
            'slug',
    ];

    public function thumbnail()
    {
        return $this->belongsTo(Files::class, 'image_file_id', 'id')->select(['id', 'file_path']);
    }
    public function user() {
        return $this->belongsTo(CoreUsers::class, 'user_id' , 'id');
    }
}

