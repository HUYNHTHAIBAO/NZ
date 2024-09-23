<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeDurations extends Model
{
    //
    protected $table = 'duration_time';
    protected $fillable = [
        'user_id', 'date', 'key', 'time'
    ];

    public function user()
    {
        return $this->belongsTo(CoreUsers::class);
    }


}
