<?php

namespace App\Models;

use App\Utils\Links;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    //
    protected $table = 'lck_partner';
    protected $fillable = [
        'title',
        'image_id',
        'image_path',
        'status',
        'link',
    ];

    protected $appends = array('file_src');

    public static function get_validation_admin()
    {
        return [
            'title'           => 'nullable|string',
            'link'             => 'nullable|string',
            'status'          => 'required|in:0,1',
            'image_id'        => 'required|integer|exists:lck_files,id',
        ];
    }
    public function getFileSrcAttribute()
    {
        return Links::ImageLink($this->image_path);
    }
}
