<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertCategoryTags extends Model
{
    //
    protected $table = 'lck_expert_category_tags';
    protected $fillable = [
        'name',
        'status',
    ];


    public function categories()
    {
        return $this->belongsToMany(ExpertCategory::class, 'lck_expert_category_tags_pivot', 'id', 'tags_id');
    }


}
