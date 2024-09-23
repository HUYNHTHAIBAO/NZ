<?php
/**
 * User: LuanNT
 * Date: 29/05/2018
 * Time: 2:43 CH
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseAPIController;
use App\Models\Basket;
use App\Models\Coupon;
use App\Models\DiscountCode;
use App\Models\Product;
use App\Models\ProductPriceRange;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BasketController extends BaseAPIController
{
    /**
     * @OA\Get(
     *   path="/basket",
     *   tags={"Basket"},
     *   summary="Get basket of user",
     *   description="",
     *   operationId="BasketGetAll",
     *     @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="api_key", description="api_key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="device_id", description="Device ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="token", description="Access token", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="discount_code", description="discount code", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="limit", description="limit", required=false, in="query",
     *         @OA\Schema( type="integer", )
     *     ),
     *     @OA\Parameter( name="page", description="page", required=false, in="query",
     *         @OA\Schema( type="integer", )
     *     ),
     *    @OA\Parameter(name="referral_code", description="mã giới thiệu", required=false, in="query",
     *         @OA\Schema(type="string",)
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
        ]);
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
        }
        if ($validator->fails()) {
            return $this->throwError($validator->errors()->first(), 400);
        }

        $params = $request->all();

        $params = array_filter($params);
        $params['token'] = $request->get('token');
        if (!empty($params['token'])) {
            $params['device_id'] = null;
        } else {
            $params['device_id'] = $request->get('device_id');
        }
        $params['pagin_path'] = route('basket.getAll') . '?' . http_build_query($params);

        $params['pagin'] = false;



        if (isset($user))
            $params['user_id'] = $user->id;

        $total_reduce_point = $total_product_price = $discount_amount = $total_weight = $shipping_fee = 0;

        $basket = Basket::get_all_product($params);

        //
        foreach ($basket as $product) {
//            return $this->returnResult($product);

            if($product->type_payment == 2) {
                $price = isset($product->product_variation_debt_price) ? $product->product_variation_debt_price : $product->debt_price;
            } else {
                $price = isset($product->product_variation_price) ? $product->product_variation_price : $product->price;
            }

            $price_old = isset($product->product_variation_price) ? $product->product_variation_price : $product->price_old;

            $array= [
                'quantity' =>$product->quantity,
                'product_id' =>$product->product_id
            ];
            $checkQuantity = ProductPriceRange::check_quantity($array);
            if (!empty($checkQuantity)) {
                $total_product_price += $checkQuantity* $product->quantity;

            } else {
                $total_product_price += $price * $product->quantity;

            }
            $PriceRanges = ProductPriceRange::where('product_id', $product->product_id)->get();
            $product['PriceRange'] = $PriceRanges;
            if (!empty($PriceRanges)) {
                foreach ($PriceRanges as $k=>$PriceRange) {
                    $quantity_end = '';
                    $PriceRangetext = '';
                    if ($PriceRange['quantity_max'] == 9999999) {
                        $quantity_end = 'Trở lên';
                        $PriceRangetext = 'Mua từ '.$PriceRange['quantity_min'].' sản phẩm trở lên giá : '.number_format($PriceRange['quantity_price']).' vnđ';
                    } else {
                        $quantity_end = (string) $PriceRange['quantity_max'];
                        $PriceRangetext = 'Mua từ '.$PriceRange['quantity_min'].' đến '.$PriceRange['quantity_max'] .' sản phẩm giá : '.number_format($PriceRange['quantity_price']).' vnđ';
                    }
                    $product['PriceRange'][$k]['PriceRangetext'] = $PriceRangetext;
                    $product['PriceRange'][$k]['quantity_end'] = $quantity_end;
                    $product['PriceRange'][$k]['quantity_start'] = (string) $PriceRange['quantity_min'];
                }
            }

            $total_weight += $product->weight * $product->quantity;
            //return $this->returnResult($total_product_price);
        }
        if (!empty($code)) {
            $discount_amount = $code->type == 1 ? $code->value : ($code->value * $total_product_price) / 100;
            $discount_amount = $discount_amount >= $total_product_price ? $total_product_price : $discount_amount;
        }

        // nieu co ma gioi thieu referral_code
        $referral_discount = 0;
        $referral_value = 0;
        if (!empty($request->get('referral_code'))) {
            $Totalpercent_discount = 0; // nhóm hang
            $referral_code = $request->get('referral_code');
            $promotion_check = Coupon::checkCode([
                'code' =>  $referral_code,
                'user_id' => $user->id,
                'price' => $total_product_price - $discount_amount,
                'totalpercent_discount' => $Totalpercent_discount,
            ]);

            if ($promotion_check['status'] === 'error') {
                return $this->throwError($promotion_check['message'], 400);
            } else {
                $referral_code = $promotion_check['message'];
            }
            if (!empty($promotion_check['data'])) {
                $referral_discount = $promotion_check['data']['point_use'];
                $referral_value = $promotion_check['data']['point_use_value'];
            }
        }

        $return = [
            'items'                => $basket,
            'total_product_price'  => $total_product_price,
            'discount_amount'      => (int)$discount_amount,
            'discount_system'      => (int)$discount_amount,
            'total_after_discount' => $total_product_price - $discount_amount,
            'promotion'            => !empty($code) ? $code : [],
            'referral_discount'    => $referral_discount,
            'referral_value'    => (int)$referral_value,
        ];

        return $this->returnResult($return);
    }

    /**
     * @OA\Get(
     *   path="/basket/counter",
     *   tags={"Basket"},
     *   summary="Get basket counter",
     *   description="",
     *   operationId="BasketCounter",
     *     @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="token", description="token from api login", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     * )
     */
    public function counter(Request $request)
    {
        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));

        $user = $this->getAuthenticatedUser();

        $total = Basket::select(DB::raw('sum(quantity) as total'))
            ->where('user_id', $user->id)
            ->groupBy('user_id')
            ->first();

        $return = $total;

        return $this->returnResult($return);
    }

    /**
     * @OA\Post(
     *   path="/basket",
     *   tags={"Basket"},
     *   summary="add product to basket",
     *   description="",
     *   operationId="BasketAddProduct",
     *      @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *      @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *			     @OA\Property(property="token", description="access token", type="string", ),
     *			     @OA\Property(property="device_id", description="device id", type="string", ),
     *			     @OA\Property(property="product_id", description="product_id", type="integer", ),
     *			     @OA\Property(property="product_variation_id", description="product_variation_id", type="integer", ),
     *			     @OA\Property(property="quantity", description="quantity", type="integer", ),
     *			     @OA\Property(property="type_payment", description="1.Tiền mặt, 2. Công nợ", type="integer", ),
     *              required={"product_id","quantity","token", "type_payment"},
     *          )
     *       )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     *     @OA\Response(response="404", description="Account not exits"),
     *     @OA\Response(response="405", description="Account has not been activated yet"),
     * )
     */
    public function add(Request $request)
    {
        if (!$request->get('company_id') || !$request->get('api_key')) {
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');
        }

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));

        if ($request->get('token', null)) {
            $user = $this->getAuthenticatedUser();
        }

        $validator = Validator::make($request->all(), [
            'product_id'           => 'required|integer',
            'product_variation_id' => 'nullable|integer',
            'quantity'             => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return $this->throwError($validator->errors()->first(), 400);
        }

        $product_id = $request->get('product_id');
        $company_id = $request->get('company_id');
        $type_payment = $request->get('type_payment');
        $product_variation_id = $request->get('product_variation_id', null);
        $quantity = $request->get('quantity');

        $product = Product::where('company_id', $company_id)->find($product_id);

        if (empty($product)) {
            return $this->throwError('Sản phẩm không tồn tại!', 400);
        }

        // Kiểm tra giỏ hàng của người dùng

            $basket = Basket::where('user_id', $user->id)->first();
//            if (!empty($basket)) {
//                $check_debt_price = Product::where('id', $basket->product_id)->first()->debt_price;
//                if (!$check_debt_price && !empty($product->debt_price)) {
//                    return $this->throwError('Không thể thêm vào giỏ hàng vì sản phẩm không có giá nợ!', 400);
//                } elseif ($check_debt_price && !$product->debt_price) {
//                    return $this->throwError('Không thể thêm vào giỏ hàng vì sản phẩm không có giá nợ!', 400);
//                }
//            }
        if(!empty($basket)) {
            if($type_payment != $basket->type_payment ) {
                return $this->throwError('Bạn phải thêm vào giỏ hàng theo đúng phương thức bạn chọn trước đó!', 400);
            }
        }


            $basket = Basket::where('user_id', $user->id)->where('product_id', $product_id);
            if ($product_variation_id) {
                $basket = $basket->where('product_variation_id', $product_variation_id);
            }
            $basket = $basket->first();
            if (empty($basket)) {
                Basket::create([
                    'company_id' => $company_id,
                    'user_id' => isset($user) ? $user->id : '',
                    'device_id' => null,
                    'product_id' => $product_id,
                    'product_variation_id' => $product_variation_id,
                    'quantity' => $quantity,
                    'type_payment' => $request->type_payment,
                ]);
            } else {
                $basket->quantity = $basket->quantity + $quantity;
                $basket->save();
        }
        return $this->returnResult();
    }


    /**
     * @OA\Post(
     *   path="/basket/update",
     *   tags={"Basket"},
     *   summary="update basket",
     *   description="",
     *   operationId="BasketUpdate",
     *      @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *      @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *      @OA\Parameter( name="device_id", description="Device ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *      @OA\Parameter( name="token", description="Access token", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="basket_data_androi", description="basket_data for androi", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *			     @OA\Property(property="basket_data", description="Object basket data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="basket_item_id", description="basket_item_id", type="integer", ),
     *			            @OA\Property(property="quantity", description="số lượng", type="integer", ),
     *                  )
     *              ),
     *              required={"basket_data"}
     *          )
     *       )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     *     @OA\Response(response="404", description="Account not exits"),
     *     @OA\Response(response="405", description="Account has not been activated yet"),
     * )
     */
    public function update(Request $request)
    {
        //Log::debug(file_get_contents('php://input'));
        //Log::debug($request->all());
        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));

        if ($request->get('token', null))
            $user = $this->getAuthenticatedUser();

        $validator = Validator::make($request->all(), [
            'basket_data' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->throwError($validator->errors()->first(), 400);
        }

        if (!empty($request->get('basket_data_androi'))) {
            $arrayJsons = json_decode($request->get('basket_data_androi'), true);
            foreach ($arrayJsons as $arrayJson) {
                $basket = Basket::where('id', $arrayJson['basket_item_id'])->where('user_id', $user->id)->first();
                $basket->quantity = $arrayJson['quantity'];
                $basket->save();
            }
        } else {

//        $device_id = $request->get('device_id');
            $basket_data = $request->get('basket_data');

            $array = [];
            if (is_array($basket_data)) {
                foreach ($basket_data as $item) {
                    if (is_string($item)) {
                        $item = json_decode($item, true);
                    }
                    $array[] = [
                        "basket_item_id" => $item['basket_item_id'],
                        "quantity" => $item['quantity'],
                    ];
                }
            }

            if (empty($basket_data))
                return $this->throwError('Basket_data empty or invalid', 400);

//        $basket_data = is_array($basket_data) ? $basket_data : json_decode($basket_data, true);
            $basket_data =  $array;




            foreach ($basket_data as $item) {
                if (isset($user)) {
                    $basket = Basket::where('id', $item['basket_item_id'])->where('user_id', $user->id)->first();
                }
//            else {
////                $basket = Basket::where('id', $item['basket_item_id'])->where('device_id', $device_id)->first();
//                $basket = Basket::where('id', $item['basket_item_id'])->first();
//            }
                if ($basket) {
                    if ($item['quantity'] < 1 || empty($basket->product)) {
                        $basket->delete();
                    } else {
                        $basket->quantity = $item['quantity'];
                        $basket->save();
                    }
                } else {
                    return $this->throwError('Basket invalid', 400);
                }
            }
        }


        return $this->returnResult();
    }

    /**
     * @OA\Post(
     *   path="/basket/remove-item",
     *   tags={"Basket"},
     *   summary="Remove items from basket",
     *   description="",
     *   operationId="BasketRemoveItems",
     *      @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *      @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *      @OA\Parameter( name="device_id", description="token from api login", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *      @OA\Parameter( name="token", description="token from api login", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *			     @OA\Property(property="basket_item_ids", description="list item id in basket", type="string", ),
     *              required={"basket_item_ids",}
     *          )
     *       )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     *     @OA\Response(response="404", description="Account not exits"),
     *     @OA\Response(response="405", description="Account has not been activated yet"),
     * )
     */
    public function removeItems(Request $request)
    {
        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));


        if ($request->get('token', null))
            $user = $this->getAuthenticatedUser();

        $validator = Validator::make($request->all(), [
            'basket_item_ids' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->throwError($validator->errors()->first(), 400);
        }

        $basket_item_ids = explode(',', $request->get('basket_item_ids'));

//        Basket::where('device_id', $request->get('device_id'))->whereIn('id', $basket_item_ids)->delete();
        Basket::whereIn('id', $basket_item_ids)->delete();

        return $this->returnResult();
    }


    /**
     * @OA\Post(
     *   path="/basket/remove-all",
     *   tags={"Basket"},
     *   summary="Remove All items from basket",
     *   description="",
     *   operationId="BasketRemoveAllItems",
     *      @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *      @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *      @OA\Parameter( name="token", description="token from api login", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     *     @OA\Response(response="404", description="Account not exits"),
     *     @OA\Response(response="405", description="Account has not been activated yet"),
     * )
     */
    public function removeAllItems(Request $request) {

        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));


        if ($request->get('token', null))
            $user = $this->getAuthenticatedUser();


        // Kiểm tra xem người dùng có mục nào trong giỏ hàng không trước khi xóa
        $userBasketItems = Basket::where('user_id', $user->id)->get();

        if ($userBasketItems->isNotEmpty()) {
            // Nếu người dùng có mục trong giỏ hàng, hãy xóa chúng
            $removeAll = Basket::where('user_id', $user->id)->delete();

            return $this->returnResult();
        } else {
            // Người dùng không có mục nào trong giỏ hàng
            return $this->throwError('Không có mục nào trong giỏ hàng để xóa!', 400);
        }
        return $this->returnResult();
    }
}
