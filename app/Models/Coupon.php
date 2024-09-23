<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
    //
    protected $table = 'setting_coupon';
    protected $fillable = ['admin_discount' , 'user_discount'];
//  admin_discount cấp 1
// user_discount cấp 2
    public static function checkCode($params)
    {
        $params = array_merge([
            'code' => null,
            'user_id' => null,
            'price' => 0,
        ], $params);
//        return $params;
        $is_checkuser = CoreUsers::where('discount_code', $params['code'])->first();

        $user_use = CoreUsers::where('discount_code', $is_checkuser->recommender)->first(); // cấp 1

        $user_give = CoreUsers::where('discount_code', $user_use->recommender)->first();// cấp 2
//        return $user_give;
        if (!$user_use) {
            return [
                'status' => 'error',
                'message' => 'Người dùng không tồn tại.'
            ];
        }
        if (!$user_give) {
            return [
                'status' => 'error',
                'message' => 'Mã giới thiệu không đúng.'
            ];
        }

//        if ($user_use->id == $user_give->id) {
//            return [
//                'status' => 'error',
//                'message' => 'Bạn không thể sử dụng mã của chính mình.'
//            ];
//        }

        $value_use = Coupon::find(1)->admin_discount;// ngươi mua nhận bao nhiu %
        $value_give = Coupon::find(1)->user_discount; // người tạo mã nhận bao nhiêu %

        $point_use = ($value_use*$params['price'])/100;
        $point_give = ($value_give*$params['price'])/100;
//        $user_use->point= $user_use->point+$point_use;
//        $user_use->save();
//        $user_give->point = $user_give->point + $point_give;
//        $user_give->save();
        $data = [
            'code'=>$params['code'],
            'user_id_use'=>$user_use['id'],
            'user_id_give'=>$user_give['id'],
            'point_use'=> $point_use,
            'point_give'=>$point_give,
            'username_give'=>$user_use['fullname'],
            'point_use_value'=>$value_use,
        ];
        return [
            'status' => 'success',
            'message' => $params['code'],
            'data' => $data,
        ];
    }

}
