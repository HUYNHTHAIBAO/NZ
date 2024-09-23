<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeRatesDuration extends Model
{
    //
    protected $table = 'settting_time_rates_duration';
    protected $fillable = [
        'user_id', 'duration_id', 'duration_name', 'duration_type', 'price'
    ];



    public function user() {
        return $this->belongsTo(CoreUsers::class);
    }

}
