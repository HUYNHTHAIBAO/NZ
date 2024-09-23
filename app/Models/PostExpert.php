<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PostExpert extends Model
{
    //
    const STATUS_HIDE = 0;
    const STATUS_SHOW = 1;
    const STATUS = [
        ['id' => 0, 'name' => 'Ẩn'],
        ['id' => 1, 'name' => 'Hiển thị'],
    ];
    protected $table = 'lck_post_expert';
    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'detail',
        'thumbnail_file_id',
        'image_extra_file_id',
        'user_id',
        'status',
        'seo_title',
        'seo_descriptions',
        'seo_keywords',
        'expert_category_id',
        'can_index',
        'sort',
        'company_id'
    ];

    public static function get_by_where($params = [], $columns = [])
    {
        $params = array_merge(
            [
                'id'           => null,
                'skip_ids'     => null,
                'keyword'      => null,
                'expert_category_id' => null,
                'status'       => null,
                'multi_status' => null,
                'pagin_path'   => null,
                'limit'        => 10,
                'pagin'        => true,
                'slug'        => null,

                'order_by'           => null,
                'order_by_direction' => 'ASC',
                'sort'               => null,
            ],
            $params
        );

        $columns = array_merge([
            'id',
            'name',
            'slug',
            'excerpt',
            'thumbnail_file_id',
            'expert_category_id',
            'created_at',
            'user_id',
        ], $columns);


//        $data = PostExpert::where('status', 1)
//            ->with(['thumbnail', 'expertCategory', 'user'])
//            ->get();




        $data = self::select($columns)
            ->with(['thumbnail', 'user', 'expertCategory']);


        $data->where('company_id', config('constants.company_id'))->orderBy('id', 'desc');

        if ($params['id'])
            $data->where('id', $params['id']);

        if ($params['skip_ids'])
            $data->whereNotIn('id', $params['skip_ids']);

        if ($params['keyword'])
            $data->where('name', 'like', "%{$params['keyword']}%");

        if ($params['expert_category_id'])
            $data->where('expert_category_id', $params['expert_category_id']);

        if ($params['status'])
            $data->where('status', $params['status']);

        $aSort = [
            'recently_changed' => [
                'column'    => 'updated_at',
                'direction' => 'DESC'
            ],
            'newest'           => [
                'column'    => 'created_at',
                'direction' => 'DESC'
            ],
            'oldest'           => [
                'column'    => 'created_at',
                'direction' => 'ASC'
            ],
            'top-view'         => [
                'column'    => 'views',
                'direction' => 'desc'
            ],
        ];

        if (isset($aSort[$params['sort']])) {
            $data->orderBy($aSort[$params['sort']]['column'], $aSort[$params['sort']]['direction']);
        } else if ($params['order_by']) {
            $data->orderBy($params['order_by'], $params['order_by_direction']);
        } else {
            $data->orderBy('created_at', 'DESC');
        }

        if ($params['pagin']) {
            $data = $data->paginate($params['limit'])
                ->withPath($params['pagin_path']);
        } else {
            if ($params['limit'])
                $data = $data->limit($params['limit']);

            $data = $data->get();
        }

        return $data;
    }

    public static function get_validation_admin()
    {
        return [
            'name'                => 'required|string',
            'slug'                => 'nullable|string',
            'excerpt'             => 'nullable|string',
            'detail'              => 'nullable|string',
            'expert_category_id'  => 'required|integer',
            'status'              => 'nullable|in:0,1',
            'seo_title'           => 'nullable|string',
            'seo_descriptions'    => 'nullable|string',
            'seo_keywords'        => 'nullable|string',
            'user_id'             => 'nullable|integer',
            'thumbnail_file_id'   => 'nullable|integer|exists:lck_files,id',
            'image_extra_file_id' => 'nullable|integer|exists:lck_files,id',
            'can_index'           => 'nullable|in:0,1',
            'sort'           => 'nullable|integer',
        ];
    }
    public function thumbnail()
    {
        return $this->belongsTo(Files::class, 'thumbnail_file_id', 'id')->select(['id', 'file_path']);
    }
    public function expertCategory() {
        return $this->belongsTo(ExpertCategory::class);
    }
    public function user() {
        return $this->belongsTo(CoreUsers::class, 'user_id' , 'id');
    }
    public function comment(){
        return $this->hasMany(CommentPostExpert::class, 'post_id')->orderBy('created_at', 'desc');
    }
    public function likes()
    {
        return $this->hasMany(LikePostExpert::class, 'post_id');
    }
    public function isLikedByAuthUser()
    {
        return $this->likes()->where('user_id', Auth::guard('web')->id())->exists();
    }
}
