<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseAPIController;
use App\Jobs\PushNotification;
use App\Models\Basket;
use App\Models\Coupon;
use App\Models\DiscountCode;
use App\Models\HistoryCouPon;
use App\Models\Location\District;
use App\Models\Location\Province;
use App\Models\Location\Ward;
use App\Models\Notification;
use App\Models\Orders;
use App\Models\OrdersDetail;
use App\Models\Product;
use App\Models\ProductPriceRange;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;

class OrdersController extends BaseAPIController
{
    /**
     * @OA\Get(
     *   path="/orders",
     *   tags={"Orders"},
     *   summary="Get all orders",
     *   description="",
     *   operationId="OrdersGetAll",
     *     @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="device_id", description="Device ID", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="token", description="token from api login", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="referral_code", description="mã giới thiệu", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="type", description="null: tất cả, 1:chờ thanh toán, 2:Chờ lấy hàng, 3: Đang giao, 4: Đã giao, 5: Đã hủy", required=false, in="query",
     *         @OA\Schema( enum={1,2,3,4,5} )
     *     ),
     *     @OA\Parameter( name="limit", description="limit", required=false, in="query",
     *         @OA\Schema( type="integer", )
     *     ),
     *     @OA\Parameter( name="page", description="page", required=false, in="query",
     *         @OA\Schema( type="integer", )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     * )
     */
    public function getAll(Request $request)
    {
        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));

        if ($request->get('token', null))
            $user = $this->getAuthenticatedUser();

        $validator = Validator::make($request->all(), [
            'page'  => 'nullable|integer|min:1',
            'limit' => 'nullable|integer|min:1',
            'type'  => 'nullable|integer|in:1,2,3,4,5',
        ]);

        if ($validator->fails()) {
            return $this->throwError($validator->errors()->first(), 400);
        }

        $params = $request->all();

        $params = array_filter($params);
        $params['token'] = $request->get('token');
        $params['referral_code'] = $request->get('referral_code');
        $params['pagin_path'] = route('orders.getAll') . '?' . http_build_query($params);

        if (isset($user))
            $params['user_id'] = $user->id;

        $params['device_id'] = $request->get('device_id');


        $allOrders = Orders::get_by_where($params);
//        $totalPriceSum = $allOrders->where('status_payment', 2)->sum('total_price');


//        return $this->returnResult = [
//            'total_price_sum' => $totalPriceSum,
//            'data' => $allOrders,
//        ];
//
        return $this->returnResult($allOrders);

    }

    /**
     * @OA\Post(
     *   path="/orders",
     *   tags={"Orders"},
     *   summary="add orders",
     *   description="",
     *   operationId="OrdersAdd",
     *     @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="device_id", description="Device ID", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="token", description="token from api login", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *			     @OA\Property(property="address_id", description="AddressID", type="integer", ),
     *			     @OA\Property(property="province_id", description="province_id", type="integer", ),
     *			     @OA\Property(property="district_id", description="district_id", type="integer", ),
     *			     @OA\Property(property="ward_id", description="ward_id", type="integer", ),
     *			     @OA\Property(property="home_number", description="home_number", type="string", ),
     *			     @OA\Property(property="full_address", description="full_address", type="string", ),
     *			     @OA\Property(property="fullname", description="Tên đầy đủ", type="string", ),
     *			     @OA\Property(property="phone", description="Số điện thoại", type="string", ),
     *			     @OA\Property(property="email", description="Email", type="string", ),
     *               @OA\Property(property="basket_item_ids", description="basket_item_ids", type="array", @OA\Items()),
     *			     @OA\Property(property="payment_method_id", description="payment_method_id", type="integer", ),
     *			     @OA\Property(property="shipping_method", description="shipping_method", type="integer", ),
     *			     @OA\Property(property="discount_code", description="Mã giảm giá", type="string", ),
     *			     @OA\Property(property="id_branchs", description="Đại lý", type="integer", ),
     *			     @OA\Property(property="latitude", description="Latitude", type="string", ),
     *			     @OA\Property(property="longitude", description="Longitude", type="string", ),
     *			     @OA\Property(property="date_receiver", description="date_receiver", type="string", ),
     *			     @OA\Property(property="referral_code", description="mã giơi thieu", type="string", ),
     *			     @OA\Property(property="point", description="point", type="integer", ),
     *              required={"address_id","payment_method_id","shipping_method"}
     *          )
     *       )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     * )
     */
    public function add(Request $request)
    {
        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));

        if ($request->get('token', null))
            $user = $this->getAuthenticatedUser();

        $validator = Validator::make($request->all(), [
            'basket_item_ids'   => 'nullable|array',
            'address_id'        => 'nullable|integer',
            'payment_method_id' => 'nullable|integer|in:1,2',
            'discount_code'     => 'nullable|string',
            'notes'             => 'nullable|array',
            'shipping_method'   => 'nullable|integer',
            'date_receiver'     => 'nullable|string',
            'id_branchs'     => 'nullable|integer',
            'fullname'          => ['nullable', 'string'],
            'phone'             => ['nullable', 'string'],
            'email'             => ['nullable', 'email'],
            'home_number'       => ['nullable', 'string'],
            'province_id'       => ['nullable', 'integer', Rule::exists('lck_location_province', 'id'),],
            'district_id'       => ['nullable', 'integer', Rule::exists('lck_location_district', 'id'),],
            'ward_id'           => ['nullable', 'integer', Rule::exists('lck_location_ward', 'id'),],
        ]);

        if ($validator->fails())
            return $this->throwError($validator->errors()->first(), 400);


        if (isset($user))
            $params['user_id'] = $user->id;

        $params['item_ids'] = $request->get('basket_item_ids');
        //$params['device_id'] = $request->get('device_id');
        $params['pagin'] = false;
        \DB::enableQueryLog();

        $baskets = Basket::get_all_product($params);

        if (count($baskets) < 1)
            return $this->throwError('Sản phẩm không tồn tại trong giỏ hàng!', 400);

        $total_reduce_point = $total_product_price = $discount_amount = $total_weight = $shipping_fee = 0;
        if ($request->get('discount_code')) {
            $code = DiscountCode::get_available([
                'code' => $request->get('discount_code')
            ]);

            if (!$code) {
                return $this->throwError('Mã giảm giá không tồn tại!', 400);
            }

            if ($code->limit <= $code->used_count) {
                return $this->throwError('Mã giảm giá đã hết lượt sử dụng', 400);

            }

            $params['discount_info'] = json_encode($code);

        }
        foreach ($baskets as $product) {
            if($product->type_payment == 2) {
                $is_status_payment = 1;
                $price = isset($product->product_variation_debt_price) ? $product->product_variation_debt_price : $product->debt_price;
            } else {
                $is_status_payment = 2;
                $price = isset($product->product_variation_price) ? $product->product_variation_price : $product->price;
            }
//            $price = isset($product->product_variation_price) ? $product->product_variation_price : $product->price;
            $price_old = isset($product->product_variation_price) ? $product->product_variation_price : $product->price_old;
            $array= [
                'quantity' =>$product->quantity,
                'product_id' =>$product->product_id
            ];
            $checkQuantity = ProductPriceRange::check_quantity($array);
            if (!empty($checkQuantity)) {
                $total_product_price += $checkQuantity * $product->quantity;
            } else {
                $total_product_price += $price * $product->quantity;
            }
            //$total_product_price += $price * $product->quantity;
            $total_weight += $product->weight * $product->quantity;
            $order_detail[] = [
                'order_id'               => null,
                'product_id'             => $product->product_id,
                'product_code'           => $product->product_variation_product_code,
                'title'                  => $product->title,
                'thumbnail_path'         => $product->thumbnail->file_path,
                'description'            => $product->description,
                'quantity'               => $product->quantity,
                'specifications'         => $product->specifications,
                'price'                  => $price,
                'total_price'            => $total_product_price,
                'product_variation_id'   => $product->product_variation_id,
                'product_variation_name' => $product->product_variation_name,
                'inventory_management'   => $product->product_variation_inventory,
                'inventory_policy'       => $product->inventory_policy,
                'buy_out_of_stock'       => $product['buy_out_of_stock'],
            ];
        }

        $point = $request->get('point') ?? 0;
        $province = Province::find($request->get('province_id'));
        $district = District::find($request->get('district_id'));
        $ward = Ward::find($request->get('ward_id'));
        $address = $request->get('home_number') . ', ' . $ward->name_origin . ', ' . $district->name_origin . ', ' . $province->name_origin;
        if (isset($code)) {
            $discount_amount = $code->type == 1 ? $code->value : ($code->value * $total_product_price) / 100;
            $discount_amount = $discount_amount >= $total_product_price ? $total_product_price : $discount_amount;
        }

        //$referral_code = '';
//        $historyCoupon = new HistoryCouPon();
//        if (!empty($request->get('referral_code'))) {
//            // Kiểm tra mã giới thiệu
//
//            $promotion_check = Coupon::checkCode([
//                'code' =>  $request->get('referral_code'),
//                'user_id' => $user->id,
//                'price' => $total_product_price - $discount_amount - $total_reduce_point,
//            ]);
//
//            if ($promotion_check['status'] === 'error') {
//                return $this->throwError($promotion_check['message'], 400);
//            } else {
//                $referral_code = $promotion_check['message'];
//            }
//            if (!empty($promotion_check['data'])) {
//                //return $this->returnResult($promotion_check['data']);
//                $historyCoupon->code = $promotion_check['data']['code'];
//                $historyCoupon->user_id_use = $promotion_check['data']['user_id_use'];
//                $historyCoupon->user_id_give = $promotion_check['data']['user_id_give'];
//                $historyCoupon->point_use = $promotion_check['data']['point_use'];
//                $historyCoupon->point_give = $promotion_check['data']['point_give'];
//                $historyCoupon->username_give = $promotion_check['data']['username_give'];
//            }
//        }
//


        $order = Orders::create([
            'company_id'         => config('constants.company_id'),
            'order_code'         => null,
            'user_id'            => isset($user) ? $user->id : null,
            'fullname'           => $request->get('fullname'),
            'phone'              => $request->get('phone'),
            'email'              => $request->get('email'),
            'street'             => $request->get('home_number'),
            'address'            => $address,
            'province_id'        => $request->get('province_id'),
            'district_id'        => $request->get('district_id'),
            'ward_id'            => $request->get('ward_id'),
            'id_branchs'            => $request->get('id_branchs'),
            'total_price'        => $total_product_price - $discount_amount - $total_reduce_point - $point,
            'note'               => $request->get('note'),
            'product_price'      => $total_product_price,
            'discount_code'      => $request->get('discount_code'),
            'total_reduce'       => $discount_amount,
            'total_reduce_point' => $total_reduce_point,
            'status'             => 1,
            'status_payment'             => $is_status_payment, // 1. nợ, 2. ko nợ
            'send_mail_status'   => 0,
            'payment_type'       => $request->get('payment_method_id'),
            'device_id'          => $request->get('device_id'),
            'date_receiver'      => $request->get('date_receiver'),
            'referral_code'      => $request->get('referral_code'),
            'reduce_point'      => $point,
        ]);

        $order->order_code = 'DH' . $order->id;
        $order->save();

        foreach ($order_detail as $k => $v) {
            $order_detail[$k]['order_id'] = $order->id;
        }

        OrdersDetail::insert($order_detail);

        foreach ($order_detail as $k => $v) {
            if ($v['inventory_management'] && !$v['buy_out_of_stock']) {
                if ($v['product_variation_id']) {
                    ProductVariation::update_inventory([
                        'id'         => $v['product_variation_id'],
                        'product_id' => $v['product_id'],
                        'quantity'   => -$v['quantity'],
                    ]);
                } else {
                    Product::update_inventory([
                        'product_id' => $v['product_id'],
                        'quantity'   => -$v['quantity'],
                    ]);
                }
                Product::change_inventory([
                    'product_id' => $v['product_id'],
                ]);
            }
        }
        Basket::whereIn('id', $params['item_ids'])->delete();


        // thông báo về admin có đơn mới
       /* $array_user_admins = [168, 172, 193];// danh sách id user cần thông báo
        foreach ($array_user_admins as $array_user_admin) {
            $form_init['title'] = 'Có đơn hàng mới.';
            $form_init['content'] = 'Khách hàng '.$order->fullname.' vừa đặt đơn hàng số #DH' . $order->id;
            $form_init['type'] = 1;
            $form_init['chanel'] = 2;
            $form_init['company_id'] = config('constants.company_id');
            $form_init['to_user_id'] = $array_user_admin;
            $form_init['user_id_created'] = 168;
            $notification = Notification::create($form_init);
            $this->dispatch((new PushNotification($notification))->onQueue('push_notification'));
        }*/

        return $this->returnResult();
    }

    /**
     * @OA\Get(
     *   path="/orders/{order_id}",
     *   tags={"Orders"},
     *   summary="get a orders detail",
     *   description="",
     *   operationId="OrdersGetDetail",
     *     @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="token", description="token from api login", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="order_id", description="order_id", required=true, in="path",
     *         @OA\Schema( type="integer", )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     * )
     */
    public function detail($order_id, Request $request)
    {
        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));

        $user = $this->getAuthenticatedUser();

        $order = Orders::where('user_id', $user->id)
            ->where('id', $order_id)
            ->where('company_id', config('constants.company_id'))
            ->with(['order_details', 'user'])
            ->first();

        if (!$order)
            $this->throwError('Đơn hàng không tồn tại!');

        return $this->returnResult($order);
    }

    /**
     * @OA\Post(
     *   path="/orders/cancel/{order_id}",
     *   tags={"Orders"},
     *   summary="Cancel a orders",
     *   description="",
     *   operationId="OrdersCancel",
     *     @OA\Parameter( name="company_id", description="token from api login", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="device_id", description="device id", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="token", description="token from api login", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="order_id", description="order_id", required=true, in="path",
     *         @OA\Schema( type="integer", )
     *     ),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *			     @OA\Property(property="cancel_reason", description="cancel_reason", type="string", ),
     *              required={"cancel_reason"}
     *          )
     *       )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     * )
     */
    public function cancel(Request $request, $order_id)
    {
        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));
        $validator = Validator::make($request->all(), [
            'cancel_reason' => 'required|string|max:255',
        ]);

        if ($validator->fails())
            return $this->throwError($validator->errors()->first(), 400);

        if ($request->get('token', null))
            $user = $this->getAuthenticatedUser();

        $order = Orders::where('user_id', $user->id)
            ->where('company_id', config('constants.company_id'))
            ->where('id', $order_id)
            ->where('status', '<>', Orders::STATUS_CANCEL)
            ->first();

        if (!$order)
            $this->throwError('Đơn hàng không tồn tại!');

        $order->status = Orders::STATUS_CANCEL;
        $order->cancel_reason = $request->get('cancel_reason');
        $order->save();

        return $this->returnResult();
    }

    public function getRating($order_id)
    {
        $user = $this->getAuthenticatedUser();

        $order = Orders::where('user_id', $user->id)
            ->where('id', $order_id)
            ->with(['store', 'payment', 'shipping', 'orders_detail', 'shipping_logs'])
            ->first();

        if (!$order)
            $this->throwError('Đơn hàng không tồn tại!');

        return $this->returnResult();
    }

    public function postRating(Request $request, $order_id)
    {
        $validator = Validator::make($request->all(), [
            'ratings' => 'required|array',
        ]);

        if ($validator->fails())
            return $this->throwError($validator->errors()->first(), 400);

        $user = $this->getAuthenticatedUser();

        $order = Orders::where('user_id', $user->id)
            ->where('id', $order_id)
            ->where('status', Orders::STATUS_FINISH)
            ->whereNull('is_rated')
            ->first();

        if (!$order)
            $this->throwError('Đơn hàng không tồn tại hoặc đã được đánh giá!');

        $rating = [];
        foreach ($request->ratings as $value) {
            if (isset($value['rating']) && ($value['rating'] > 0) && ($value['rating'] < 6) && isset($value['product_id'])) {
                $rating[$value['product_id']] = $value;
            }
        }

        $order_rates = $insert_rates = [];

        foreach ($order->orders_detail as $detail) {
            if (array_key_exists($detail->product_id, $rating)) {
                $insert_rates[] = array_merge([
                    'order_detail_id' => $detail->id,
                ], $rating[$detail->product_id]);

                $order_rates[] = $rating[$detail->product_id]['rating'];
            }
        }

        try {
            DB::beginTransaction();

            foreach ($insert_rates as $value) {
                $product = Product::select(['id', 'rating', 'total_rate',])->find($value['product_id']);
                if ($product) {
                    $product->total_rate = $product->total_rate + 1;
                    $product->rating = $product->rating > 0 ? round(($product->rating + $value['rating']) / 2, 1) : $value['rating'];
                    $product->save();

                    Rate::create([
                        'user_id'         => $user->id,
                        'order_detail_id' => $value['order_detail_id'],
                        'product_id'      => $value['product_id'],
                        'order_id'        => $order_id,
                        'rating'          => $value['rating'],
                        'comment'         => isset($value['comment']) ? $value['comment'] : null,
                        'status'          => 1,
                    ]);
                }
            }

            $rating = round(array_sum($order_rates) / count($order_rates), 1);

            $order->rating = $rating;
            $order->is_rated = 1;
            $order->save();

            $store = CoreUsers::select(['id', 'rating', 'total_rate',])->find($order->store_id);

            if ($store) {
                $store->total_rate = $store->total_rate + 1;
                $store->rating = $store->rating > 0 ? round(($store->rating + $rating) / 2, 1) : $rating;
                $store->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('rating order ' . $e->getMessage());
            return $this->throwError('Có lỗi xảy ra, vui lòng thử lại! ' . $e->getMessage(), 401);
        }

        return $this->returnResult();
    }
}
