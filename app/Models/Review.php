<?php

namespace App\Models;

use App\Utils\Links;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $table = 'lck_review';
    protected $fillable = [
        'title',
        'desc',
        'name',
        'job',
        'image_id',
        'image_path',
    ];


    protected $appends = array('file_src');




    public static function get_validation_admin()
    {
        return [
            'title'           => 'required|string',
            'desc'             => 'required|string',
            'name'          => 'required|string',
            'job'          => 'nullable|string',
            'image_id'        => 'required|integer|exists:lck_files,id',
        ];
    }


    public function getFileSrcAttribute()
    {
        return Links::ImageLink($this->image_path);
    }

}
