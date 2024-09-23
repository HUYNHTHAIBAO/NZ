<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertCategoryTagTable extends Model
{
    //
    protected $table = 'lck_expert_category_tags_table';
    protected $fillable = [
        'category_id',
        'tag_id',
    ];
}
