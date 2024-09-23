<?php

namespace App\Http\Controllers\Frontend;

use App\File_Uploaded;
use App\Http\Controllers\BaseFrontendController;
use App\Mail\BookingNotification;
use App\Models\Address;
use App\Models\CoreUsers;
use App\Models\DiscountCode;
use App\Models\ExpertCategoryTags;
use App\Models\ExpertPlan;
use App\Models\Files;
use App\Models\Location\District;
use App\Models\Location\Province;
use App\Models\Location\Ward;
use App\Models\NotiExpert;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\RequestExpert;
use App\Models\RoomMeet;
use App\Models\Subscribe;
use App\Models\TimeRatesDuration;
use App\Models\Wishlist;
use App\Notification;
use App\Utils\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Types\Integer;
use Softon\LaravelFaceDetect\Facades\FaceDetect;
use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Optipng;
use Spatie\ImageOptimizer\Optimizers\Pngquant;

class AjaxController extends BaseFrontendController
{

    public function addItemCart(Request $request)
    {
        $product_id = $request->get('product_id');
        $product_variation_id = $request->get('product_variation_id');
        $quantity = $request->get('quantity');

        if (empty($product_id) || $quantity < 1)
            return $this->throwError("Dữ liệu không hợp lệ");

        $product = Product::where('id', $product_id)->where('status', 1)->first();

        if (!$product)
            return $this->throwError("Dữ liệu không hợp lệ");

        if ((int)$product->price <= 0)
            return $this->throwError("Không thể mua sản phẩm này");

        $product_variants = ProductVariation::get_product_variations_with_combine($product_id);

        $variant = null;

        if (count($product_variants)) {
            if (empty($product_variation_id)) {
                return $this->throwError("Vui lòng chọn phiên bản sản phẩm");
            } else {
                $variant = ProductVariation::where('product_id', $product_id)->where('id', $product_variation_id)->first();
                if (!$variant)
                    return $this->throwError("Phiên bản sản phẩm không hợp lệ");
            }
        }

        //check inventory
        $inventory_management = $product->inventory_management;
        $inventory_policy = $product->inventory_policy;
        $inventory = $product->inventory;
        if ($variant) {
            $inventory_management = $variant->inventory_management;
            $inventory_policy = $variant->inventory_policy;
            $inventory = $variant->inventory;
        }

        if ($inventory_management && !$inventory_policy && $inventory < 1)
            return $this->throwError("Sản phẩm đã hết hàng");

        Cart::update($product_id, $product_variation_id, (int)$quantity, true);

        return $this->returnResult([
            'total' => Cart::get_total_items(),
            'total_format' => number_format(Cart::get_total_items()),
        ]);
    }

    public function throwError($errors = 'error', $code = 400)
    {
        header('Content-type: application/json');
        echo json_encode([
            'status' => false,
            'code' => $code,
            'message' => $errors
        ]);
        exit;
    }

    public function returnResult($data = [], $msg = '')
    {
        return Response()->json([
            'status' => true,
            'code' => 200,
            'data' => $data,
            'message' => $msg
        ]);
    }

    public function deleteItemCart(Request $request)
    {
        $item_id = $request->get('item_id');
        if ($item_id === null)
            return $this->throwError("Dữ liệu không hợp lệ");

        Cart::delete_item($item_id);

        return $this->returnResult([
            'total' => Cart::get_total_items(),
            'total_format' => number_format(Cart::get_total_items()),
        ]);
    }

    public function clearCart()
    {
        Cart::clear();

        return $this->returnResult([
            'total' => 0,
            'total_format' => 0,
        ]);
    }

    public function uploadImage(Request $request)
    {
        $photos = $request->file('file');

        $thumb_sizes = $request->get('thumb_sizes');

        if (empty($photos))
            return \Response::json(['e' => 1, 'r' => 'Vui lòng chọn hình upload!']);

        if (!is_array($photos)) {
            $photos = [$photos];
        }

        $sub_dir = date('Y/m/d');
        $full_dir = config('constants.upload_dir.root') . '/' . $sub_dir;

        if (!is_dir($full_dir)) {
            mkdir($full_dir, 0755, true);
        }

        $items = [];
        for ($i = 0; $i < count($photos); $i++) {
            $photo = $photos[$i];

            $filename = uniqid();

            $ext = $photo->extension();

            $origin_file_name = $filename . '.' . $ext;

            $file_path = $sub_dir . '/' . $origin_file_name;

            $origin_file_path = $full_dir . '/' . $origin_file_name;

            $optimized_file_path = $full_dir . '/optimized_' . $origin_file_name;

            /*$image = Image::make($photo)->resize(2048, null, function ($constraint) {
                $constraint->aspectRatio();
            })->orientate()->save($origin_file_path);*/

            $image = Image::make($photo)->orientate();

            if ($image->width() > 2048)
                $image->resize(2048, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

            $image->save($origin_file_path, 100);

            if (config('app.env') == 'production') {
                try {
                    $optimizerChain = (new OptimizerChain)
                        ->addOptimizer(new Jpegoptim([
                            '-m85',
                            '--strip-all',
                            '--all-progressive',

                        ]))
                        ->addOptimizer(new Pngquant([
                            '--force'
                        ]))
                        ->addOptimizer(new Optipng([
                            '-i0',
                            '-o2',
                            '-quiet',
                        ]));

                    $optimizerChain->optimize($origin_file_path, $optimized_file_path);
                } catch (\Exception $e) {
                    \Log::error('image optimizer' . $e->getMessage());
                }
            }

            if ($thumb_sizes) {

                $dimension = explode('x', $thumb_sizes);

                //$thumb_filename = $filename . '_' . $thumb_sizes . '.' . $ext;
                $thumb_filename = $filename . '_' . $thumb_sizes . '.png';
                $thumb_file_path = $full_dir . '/' . $thumb_filename;

                $width = $dimension[0];
                $height = $dimension[1];

                $image->width() < $image->height() ? $width = null : $height = null;

                $image->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $image2 = Image::canvas($dimension[0], $dimension[1]);

                $image2->insert($image, 'center')
                    ->save($thumb_file_path, 70);

                $file_path = $sub_dir . '/' . $thumb_filename;
            }


            $image = Files::create([
                'user_id' => Auth()->guard('web')->user()->id,
                'file_path' => $file_path,
            ]);
            $items[] = [
                'id' => $image->id,
                'path' => $file_path,
                'url' => config('constants.upload_dir.url') . '/' . $file_path,
            ];
        }

        return \Response::json(['e' => 0, 'r' => $items]);
    }

    public function subscribeEmail(Request $request)
    {
        $email = $request->get('email');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return $this->throwError('Email không hợp lệ!');

        $check = Subscribe::where('email', $email)->first();

        if (!$check) {
            Subscribe::create([
                'email' => $email,
                'ip' => $request->getClientIp(),
            ]);
        }

        return $this->returnResult([], 'Bạn hãy thường xuyên kiểm tra email để nhận thông tin mới nhất của chúng tôi');

    }

    public function checkDiscount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_price' => 'required|integer',
            'discount_code' => 'required|string',
        ]);

        if ($validator->fails())
            return $this->throwError($validator->errors()->first(), 400);

        $code = DiscountCode::get_available([
            'code' => $request->discount_code
        ]);

        if (!$code)
            return $this->throwError('Mã giảm giá không hợp lệ', 400);

        if ($code->limit <= $code->used_count)
            return $this->throwError('Mã giảm giá đã hết lượt sử dụng', 400);

        $total_reduce = $code->type == 1 ? $code->value : ($code->value * $request->product_price) / 100;
        $total_reduce = $total_reduce >= $request->product_price ? $request->product_price : $total_reduce;

        return $this->returnResult([
            'reduce' => $total_reduce
        ]);
    }

    public function addWishlist(Request $request)
    {
        if (!Auth::guard('web')->user()->id)
            return abort(404);

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:lck_product,id',
        ]);

        if ($validator->fails())
            return $this->throwError($validator->errors()->first(), 400);
        $wishlist_exists = Wishlist::where('product_id', $request->get('product_id'))
            ->where('user_id', Auth::guard('web')->user()->id)
            ->first();
        if (!$wishlist_exists) {
            $wishlist = Wishlist::create([
                'product_id' => $request->get('product_id'),
                'user_id' => Auth::guard('web')->user()->id,
            ]);
            return $this->returnResult($wishlist);
        } else {
            return $this->throwError('Đã có trong danh sách', 400);
        }
    }

    public function deleteWishlist(Request $request)
    {
        if (!Auth::guard('web')->user()->id)
            return abort(404);

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:lck_product,id',
        ]);

        if ($validator->fails())
            return $this->throwError($validator->errors()->first(), 400);
        $wishlist_exists = Wishlist::where('product_id', $request->get('product_id'))
            ->where('user_id', Auth::guard('web')->user()->id)
            ->first();

        if ($wishlist_exists) {
            $wishlist_exists->delete();
            return $this->returnResult();
        } else {
            return $this->throwError('Sản phẩm không tồn tại!', 400);
        }


    }
//    public function subscribe(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'email' => 'required|email|lck_subscribers,email',
//        ]);
//        if ($validator->fails())
//            return $this->throwError($validator->errors()->first(), 400);
//        Subscribe::create([
//            'email' => $request->get('email'),
//            'ip' => $request->ip()
//        ]);
//    }
    public function deleteAddress(Request $request)
    {
        if (!Auth::guard('web')->user()->id)
            return abort(404);

        $validator = Validator::make($request->all(), [
            'address_id' => 'required|integer|exists:lck_address,id',
        ]);

        if ($validator->fails())
            return $this->throwError($validator->errors()->first(), 400);

        $address = Address::where('id', $request->get('address_id'))->first();

        if ($address) {
            $address->delete();
            return $this->returnResult();
        } else {
            return $this->throwError('Địa chỉ không tồn tại!', 400);
        }


    }

    public function addAddress(Request $request)
    {
        $user = $this->getUser();

        if (empty($user))
            return $this->throwError('Vui lòng đăng nhập để tiếp tục!', 401);

        $validate_rule = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => "required|bail|numeric",
            'province_id' => "required|bail|required|exists:lck_location_province,id",
            'district_id' => "required|bail|required|exists:lck_location_district,id",
            'ward_id' => "required|bail|required|exists:lck_location_ward,id",
            'street_name' => 'required|bail|string|max:200',
            'is_default_recipient' => "nullable|bail|in:0,1",
            'is_warehouse' => "nullable|bail|in:0,1",
            'is_return' => "nullable|bail|in:0,1",
        ];

        if ($request->isMethod('POST')) {

            $validator = Validator::make($request->all(), $validate_rule);

            if ($validator->fails()) {
                $errors = $validator->errors();
                $error_return = [];

                foreach (array_keys($validate_rule) as $v) {
                    if ($errors->first($v))
                        $error_return[$v] = $errors->first($v);
                }

                return $this->throwError($error_return, 1);
            }

            try {
                DB::beginTransaction();

                $params = array_fill_keys(array_keys($validate_rule), null);
                $params = array_merge(
                    $params, $request->only(array_keys($params))
                );
                $params['user_id'] = $user->id;
                $params['full_address'] = Address::get_full_address($params);
                $data = Address::create($params);

                if ($params['is_default_recipient'] == 1) {
                    Address::where('is_default_recipient', '=', 1)
                        ->where('id', '<>', $data->id)
                        ->where('user_id', $user->id)
                        ->update(['is_default_recipient' => 0]);
                }
                if ($params['is_warehouse'] == 1) {
                    Address::where('is_warehouse', '=', 1)
                        ->where('id', '<>', $data->id)
                        ->where('user_id', $user->id)
                        ->update(['is_warehouse' => 0]);
                }
                if ($params['is_return'] == 1) {
                    Address::where('is_return', '=', 1)
                        ->where('id', '<>', $data->id)
                        ->where('user_id', $user->id)
                        ->update(['is_return' => 0]);
                }

                DB::commit();

                $this->returnResult();
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->throwError('Có lỗi xảy ra, vui lòng thử lại!', 500);
            }
        }

        return redirect()->back();
    }

    public function getAddressById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:lck_address,id',
        ]);

        if ($validator->fails())
            return $this->throwError($validator->errors()->first(), 400);

        $address = Address::find($request->get('id'));
        $this->_data['provinces'] = Province::orderBy('name', 'ASC')->get();
        $this->_data['districts'] = District::where('province_id', $address->province_id)->orderBy('priority', 'ASC')->get();
        $this->_data['wards'] = Ward::where('district_id', $address->district_id)->orderBy('priority', 'ASC')->get();
        $this->_data['address'] = $address;
//        return $this->returnResult($address);
        $html = view('frontend.cart.address-template', $this->_data)->render();

        return $this->returnResult(['html' => $html]);
    }

    public function checkDiscountPoint(Request $request)
    {
        $this->getUser();

        if (!Auth::guard('web')->check())
            return $this->throwError('Vui lòng đăng nhập!', 400);

        $validator = Validator::make($request->all(), [
            'product_price' => 'required|integer',
            'point' => 'required|string',
        ]);

        if ($validator->fails())
            return $this->throwError($validator->errors()->first(), 400);
        if (Auth::guard('web')->user()->point < $request->get('point'))
            return $this->throwError('Điểm tích lũy không đủ', 400);

        $total_price_discount = $request->get('point') * 1000;
        $total_price_can_discount = $request->get('product_price') * 0.5;

        if ($total_price_discount > $total_price_can_discount) {
            return $this->throwError('Số tiền giảm giá không vượt quá 50% giá trị đơn hàng!', 400);
        }

        $total_reduce = $total_price_discount;

        return $this->returnResult([
            'reduce' => $total_reduce
        ]);
    }

    // todo : gửi yêu cầu thuê gói 1 1
    public function requestExpert(Request $request)
    {
        // Khởi tạo biến số thứ tự
        $data = new RequestExpert();
        $data->date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $data->time = $request->input('time');
        $data->duration_id = $request->input('duration_name');
        $data->user_id = $request->input('user_id');
        $data->user_expert_id = $request->input('user_expert_id');
        $data->price = $request->input('price');
        $data->email_user = $request->input('email_user');
        $data->email_user_expert = $request->input('email_user_expert');
        // Tạo mã đơn hàng duy nhất
        $orderNumber = 'NZ_' . Str::random(10);
        // Cập nhật mã đơn hàng và lưu lại
        $data->order_code = $orderNumber;
        $data->save();
        return $this->returnResult([
            'id' => $data->id,
            'data' => $data,
            'order_code' => $data->order_code,
        ]);
    }

    // todo : gửi yêu cầu thuê gói tháng
    public function requestExpertMonth(Request $request)
    {
        // Khởi tạo biến số thứ tự
        $data = new RequestExpert();
        $data->date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $data->time = $request->input('time');
        $data->duration_id = $request->input('duration_name');
        $data->user_id = $request->input('user_id');
        $data->user_expert_id = $request->input('user_expert_id');
        $data->price = $request->input('price');
        $data->email_user = $request->input('email_user');
        $data->email_user_expert = $request->input('email_user_expert');
        // Tạo mã đơn hàng duy nhất
        $orderNumber = 'NZ_' . Str::random(10);
        // Cập nhật mã đơn hàng và lưu lại
        $data->order_code = $orderNumber;
        $data->save();
        $url_thanhtoan = $this->createUrl($data);
        return $this->returnResult([
            'data' => $data,
            'url_payment' => $url_thanhtoan
        ]);
    }

    public function createUrl($expert)
    {
        $vnp_Url = 'https://pay.vnpay.vn/vpcpay.html';
        $vnp_Returnurl = 'https://neztwork.com/thanh-toan-vnpay/vnpay-return';
        $vnp_TmnCode = 'NEZTWORK';//Mã website tại VNPAY
        $vnp_HashSecret = 'IU4WWY9O7N2X94ZO2U8SOAMU7HP2VIGH'; //Chuỗi bí mật


        $vnp_TxnRef = $expert->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toan don hang';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $expert->price * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,

        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }

    public function getPrice(Request $request)
    {
        $duration_id = $request->input('duration_id');

        $user_expert_id = $request->input('user_expert_id');

        // Tìm giá price dựa trên id và user_id (nếu cần thiết)
        $price = TimeRatesDuration::where('duration_id', $duration_id)->where('user_id', $user_expert_id)->value('price');

        // Bạn có thể thêm logic tùy chỉnh ở đây để kiểm tra hoặc lấy thông tin khác từ user_id

        if ($price !== null) {
            $request->session()->put('payment_amount', $price);

            return response()->json(['success' => true, 'price' => $price, 'user_expert_id' => $user_expert_id]);
        } else {
            return response()->json(['success' => false]);
        }
    }



    public function notiExpert(Request $request)
    {
        $data = new NotiExpert();
        $data->user_id = $request->input('user_id');
        $data->expert_id = $request->input('expert_id');
        $data->note = $request->input('note');
        $data->save();

        return $this->returnResult([
            'data' => $data
        ]);
    }



    public function endCall(Request $request)
    {
        $id = $request->input('id');
        $data = RequestExpert::find($id);

        if ($data) {
            $data->type = 4;
            $data->save();
        }

        return response()->json([
            'data' => $data
        ]);
    }


// Controller
    // Controller
    public function getTagsByCategory(Request $request)
    {
        $category_id_expert = $request->input('category_id_expert');

        // Lấy các tags thuộc danh mục đã chọn
        $tags_expert = ExpertCategoryTags::where('status', 1)
            ->whereIn('id', function($query) use ($category_id_expert) {
                $query->select('tags_id')
                    ->from('lck_expert_category_tags_pivot')
                    ->where('expert_category_id', $category_id_expert);
            })
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($tags_expert);
    }


    public function BookingPlan(Request $request)
    {

        $list_email = !empty($request->get('email')) ? implode(',', $request->get('email')) : '';

        $user_id = $request->get('user_id');
        $email_user = Auth::guard('web')->user()->email;
        $id = $request->get('id');
        $planExpert = ExpertPlan::find($id);
        $key = $request->get('key');


        $data = new RequestExpert();
        $data->date = now()->format('Y-m-d');
        $data->time = null;
        $data->duration_id = null;
        $data->user_id = $user_id;
        $data->user_expert_id = $planExpert->user_id;
        $data->price = $planExpert->price;
        $data->email_user = $email_user;
        $data->key = $request->get('key');
        $data->email_user_expert = CoreUsers::find($planExpert->user_id)->email;
        // Tạo mã đơn hàng duy nhất
        $orderNumber = 'NZ_' . Str::random(10);
        // Cập nhật mã đơn hàng và lưu lại
        $data->order_code = $orderNumber;
        $data->list_email = $list_email;

        if ($key == 3) {
            $data->date = $request->get('date');
            $data->time = date("g:i A", strtotime($request->get('time')));
            $data->duration_id = 30;
        }
        $data->save();
        $url_thanhtoan = $this->createUrl($data);
        return $this->returnResult([
            'data' => $data,
            'url_payment' => $url_thanhtoan
        ]);


    }

    public function SearchEmail(Request $request) {
        $s = $request->input('email');
        $data = CoreUsers::where('email','like', '%'.$s.'%')->get();
        $html = '';
        foreach ($data as $key => $value) {
            $html .= '<li onclick="chooseEmail(\''.$value->email.'\')">'.$value->email.'</li>';
        }

        return $this->returnResult([
            'data' => $data,
            'html' => $html
        ]);
    }

    public function checkroom(Request $request)
    {
        $id_room = $request->get('roomId');
        $data = RoomMeet::where('rom_code', $id_room)->first();
        // check id thơi gian trong phòng họp
        if (empty($data)) {
            return $this->returnResult([
                'data' => $data,
                'status' => 'error',
                'message' => 'Không tìm thấy phòng họp.',
            ]);
        } else {
            return $this->returnResult([
                'data' => $data,
                'status' => 'success',
                'message' => 'Tìm thấy phòng họp',
            ]);

        }

    }

    public function webhookmemobot(Request $request)
    {
        $data = $request->all();
        Log::info('webhookmomobot', $data);


        $url = $data['record']['meetingId'];



        $parsed_url = parse_url($url);
        parse_str($parsed_url['query'], $query_params);


        $room = $query_params['room'];

        $room_id = explode('_', $room)[0];

        $orderId = RoomMeet::where('rom_code', $room_id)->first();
        $requetExpert = RequestExpert::find($orderId->order_id);
        if (!empty($requetExpert)) {
            if (!empty($data['record']['summary'])) {
                $requetExpert->sumary = $data['record']['summary'];
                $requetExpert->save();
            }
        }

        return $this->returnResult([
            'data' => $data
        ]);

    }

    public function callbackquickom(Request $request)
    {

        $response_code = $request->get('response_code');

        if ($response_code == '01') {
            return redirect()->route('frontend.user.conference')->with('error', 'Có lỗi xẩy ra. Vui lòng thử lại.');
        }
    }



}
