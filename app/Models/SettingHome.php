<?php

namespace App\Models;

use App\Utils\Links;
use Illuminate\Database\Eloquent\Model;

class SettingHome extends Model
{
    //
    protected $table = 'lck_setting_home';

    protected $fillable = [
        'image_id',
        'image_path',
        'title_color',
        'title',
        'desc',
        'type',
    ];


    protected $appends = array('file_src', 'mobile_file_src');

    public function getFileSrcAttribute()
    {
        return Links::ImageLink($this->image_path);
    }
}
