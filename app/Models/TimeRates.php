<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeRates extends Model
{
    //
    protected $table = 'settting_time_rates';
    protected $fillable = [
        'name', 'number'
    ];
}
