<?php

namespace App\Models;

use App\Utils\Links;
use Illuminate\Database\Eloquent\Model;

class ExpertCategory extends Model
{
    //
    protected $table = 'lck_expert_category';
    protected $fillable = [
        'image_id',
        'image_path',
        'image_id_after',
        'image_path_after',
        'name',
        'slug',
        'status',
        'tags_id',
    ];

    protected $appends = ['file_src', 'mobile_file_src', 'file_src_after'];



    public function user()
    {
        return $this->belongsTo(CoreUsers::class,'id', 'category_id_expert');
    }
    public function getFileSrcAttribute()
    {
        return Links::ImageLink($this->image_path);
    }

    public function getFileSrcAfterAttribute()
    {
        return Links::ImageLink($this->image_path_after);
    }


    public function expertProfile()
    {
        return $this->belongsTo(ExpertProfiles::class);
    }


    public function tags()
    {
        return $this->belongsToMany(ExpertCategoryTags::class, 'lck_expert_category_tags_pivot', 'expert_category_id', 'tags_id');
    }



}
