<?php

namespace App\Models;

use App\Utils\Links;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    //
    protected $table = 'lck_bookings';
    protected $fillable = [
        'title',
        'desc',
        'image_id',
        'image_path',
        'status',
        'sort',
    ];
    protected $appends = array('file_src');
    public static function get_validation_admin()
    {
        return [
            'title' => 'required|string',
            'status' => 'required|in:0,1',
            'desc' => 'nullable|string',
            'sort' => 'required',
            'image_id' => 'required|integer|exists:lck_files,id',
        ];
    }
    public function getFileSrcAttribute()
    {
        return Links::ImageLink($this->image_path);
    }

}
