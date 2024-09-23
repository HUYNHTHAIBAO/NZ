<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'lck_branch';
    protected $fillable = [
        'name',
        'o_lat',
        'o_long',
        'daily',
        'phone',
        'address',
        'user_id',
        'image_id',
    ];

    /**
     * @param $params
     * @param int $limit
     * @return mixed
     */
    public static function getAll($params, $limit = 50)
    {
        $params = array_merge([
            'search' => null
        ], $params);
        $result = self::select('lck_branch.*');

        if (!empty($params['search'])) {
            $result->where('search', 'LIKE', '%' . $params['search'] . '%');
        }

        $result->orderBy('id', 'DESC');
        return empty($limit) ? $result->get() : $result->paginate($limit);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class, 'branch_id', 'id');
    }

    public static function build_select_tree($data, $parent = 0, $text = "", $select = array(), &$html = '', $last_name = '')
    {
        foreach ($data as $k => $value) {
            $id = $value['id'];
            $value['name'] = $last_name . ' > ' . self::mb_ucfirst($value['name']);

            if ($select != 0 && in_array($id, $select)) {
                $html .= "<option value='$value[id]' selected='selected'>" . $text . $value['name'] . "</option>";
            } else {
                $html .= "<option value='$value[id]'>" . $text . $value['name'] . "</option>";
            }
            //unset($data[$k]);
            // self::build_select_tree($data, $id, $text . "&nbsp;&nbsp;-", $select, $html, $value['name']);
            /* if ((int)$value['parent_id'] == $parent) {
                 $id = $value['id'];
                 $value['name'] = $last_name . ' > ' . self::mb_ucfirst($value['name']);

                 if ($select != 0 && in_array($id, $select)) {
                     $html .= "<option value='$value[id]' selected='selected'>" . $text . $value['name'] . "</option>";
                 } else {
                     $html .= "<option value='$value[id]'>" . $text . $value['name'] . "</option>";
                 }

                 //unset($data[$k]);
                 //self::build_select_tree($data, $id, $text . "&nbsp;&nbsp;-", $select, $html, $value['name']);
             }*/
        }
        return $html;
    }

    public static function mb_ucfirst($string, $encoding = 'utf8')
    {
        $string = mb_strtolower($string);
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }

    public function thumbnail()
    {
        return $this->belongsTo(Files::class, 'image_id', 'id')->select(['id', 'file_path']);
    }
}
