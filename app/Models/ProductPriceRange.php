<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPriceRange extends Model
{

    protected $table = 'lck_productpricerange';

    protected $fillable = [
        'product_id',
        'quantity_min',
        'quantity_max',
        'quantity_price',
    ];

    public static function check_quantity($params) {
        $price = 0;


        $data = self::where('product_id', '=', $params['product_id'])
            ->where('quantity_min', '<=',$params['quantity'])
            ->where('quantity_max', '>=',$params['quantity'])
            ->orderBy('id', 'DESC')->first();

        if (!empty($data)) {
            $price = $data['quantity_price'];
        }
        return $price;
    }
}
