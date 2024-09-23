<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'lck_warehouse';
    protected $fillable = [
        'name',
        'branch_id',
        'status',
        'description',
        'thumbnail_id',
        'thumbnail_image',
        'order_id',
    ];
    public static function get_validation_admin()
    {
        return [

            'name'             => 'required|string',
         /*   'branch_id'        => 'nullable|integer',
            'status'           => 'required|integer',*/
            'description'      => 'required|string',
            /*'thumbnail_id'     => 'nullable|integer|exists:lck_files,id',
            'image_fb_file_id' => 'nullable|integer|exists:lck_files,id',
            'image_ids'        => 'nullable|array',*/
        ];
    }
    public static function getAll($params, $limit = 50)
    {
        $params = array_merge([
            'search' => null,
            'branch_id' => null,
            'status' => null,
            'status1' => null,
        ], $params);
        $result = self::Join('lck_branch', 'lck_warehouse.branch_id', '=', 'lck_branch.id')
           /* ->LeftJoin('lck_orders', 'lck_warehouse.id', '=', 'lck_orders.warehouse_id')*/
            ->select('lck_branch.name as namebranch','lck_warehouse.*');

        if (!empty($params['search'])) {
            $result->where('search', 'LIKE', '%' . $params['search'] . '%');
        }

        if (!empty($params['branch_id'])) {
            $result->where('branch_id', '=', $params['branch_id']);
        }
        if (!empty($params['status'])) {
            $result->where('status', '=', $params['status']);
        }
        if (!empty($params['status1'])) {
            $result->where('status', '<>', $params['status1']);
        }
        $result->orderBy('id', 'DESC');
        return empty($limit) ? $result->get() : $result->paginate($limit);
    }

   /* public function thumbnail()
    {
        // noi khoa ngoai foreignKey search ra khoa chinh cua bang related
        return $this->belongsTo(Files::class, 'thumbnail_id')
            ->select(['lck_files.id', 'lck_files.file_path'])
            // sap sep theo tang dan
            ->orderBy('lck_files.id', 'ASC');
    }*/

    public function thumbnail()
    {
        return $this->belongsToMany(Files::class, 'lck_ban_images', 'warehouse_id', 'file_id')
            ->select(['lck_files.id', 'lck_files.file_path'])
            ->orderBy('lck_ban_images.id', 'ASC');
    }
    public function image_fb()
    {
        return $this->belongsTo(Files::class, 'thumbnail_id', 'id')->select(['id', 'file_path']);
    }

    public function branch() {
        return $this->belongsTo(Branch::class,'id');
    }
}
