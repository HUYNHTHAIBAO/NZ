<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Links;

class OrdersDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'lck_orders_detail';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'specifications',
        'product_id',
        'product_code',
        'thumbnail_path',
        'title',
        'description',
        'quantity',
        'price',
        'total_price',
        'product_variation_id',
        'product_variation_name',
        'inventory_management',
        'inventory_policy',
        'buy_out_of_stock',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $appends = array('thumbnail_src');

    public function getThumbnailSrcAttribute()
    {
        return Links::ImageLink($this->thumbnail_path);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')
            ->select(['id','is_multilevel']);
    }
}
