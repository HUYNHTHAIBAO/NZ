<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertCategoryTagsPivot extends Model
{
    //
    protected $table = 'lck_expert_category_tags_pivot';
    protected $fillable = [
        'expert_category_id',
        'tags_id',
    ];


}
