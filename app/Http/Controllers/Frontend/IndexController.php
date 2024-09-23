<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;
use App\Models\Banner;
use App\Models\Bookings;
use App\Models\ExpertCategory;
use App\Models\ExpertPlan;
use App\Models\ExpertProfileOrther;
use App\Models\ExpertProfiles;
use App\Models\Files;
use App\Models\FollowExpert;
use App\Models\Partner;
use App\Models\CoreUsers;
use App\Models\Post;
use App\Models\PostExpert;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\QuestionExpert;
use App\Models\RatingExpert;
use App\Models\RequestExpert;
use App\Models\Review;
use App\Models\RoomMeet;
use App\Models\SettingHome;
use App\Models\ShortVideoExpert;
use App\Models\YoutubeExpert;
use App\Utils\Category;
use App\Utils\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use View;

class IndexController extends BaseFrontendController
{
    protected $_data = [];

    public function index()
    {

        // banner
        $this->_data['banners'] = Banner::get_by_where([
            'company_id' => config('constants.company_id'),
            'status' => 1,
            'type' => 1,
            'pagin' => false,
        ]);


        // setting home topic
        $this->_data['aiNeztWork'] = SettingHome::where('type', 1)->first();
        $this->_data['groupNeztWork'] = SettingHome::where('type', 2)->first();

        $this->_data['expertCategoryTopic'] = ExpertCategory::where('status', 1)
            ->whereHas('tags') // Chỉ lấy những danh mục có ít nhất một tag
            ->with('tags') // Eager load các tags liên quan
            ->inRandomOrder() // Lấy ngẫu nhiên
            ->take(4) // Giới hạn kết quả chỉ lấy 4 danh mục
            ->get(); // Lấy kết quả




        // danh mục
        $this->_data['expertCategory'] = ExpertCategory::where('status', 1)->orderBy('id', 'desc')->get();

        // top Expert
        $this->_data['topExpert'] = CoreUsers::where('account_type', 2)->orWhere('approved', 2)->orWhere('approved', 5)->orderBy('id', 'desc')->with('categoryExpert')->get();

        // partner
        $this->_data['partner'] = Partner::where('status', 1)->orderBy('id', 'desc')->get();

        // booking
        $this->_data['booking'] = Bookings::where('status', 1)->orderBy('sort', 'asc')->get();

        // review
        $this->_data['review'] = Review::orderBy('id', 'desc')->get();

        // blog expert
        $this->_data['postExpertOne'] = PostExpert::where('status', 1)->where('sort', 1)->orderBy('id', 'desc')->get();

        $this->_data['postExpertTwo'] = PostExpert::where('status', 1)->where('sort', 2)->orderBy('id', 'desc')->get();

        $this->_data['postExpertThree'] = PostExpert::where('status', 1)->where('sort', 3)->orderBy('id', 'desc')->get();

        $this->_data['postExpertFour'] = PostExpert::where('status', 1)->where('sort', 4)->orderBy('id', 'desc')->get();

        $this->_data['postExpertFive'] = PostExpert::where('status', 1)->where('sort', 5)->orderBy('id', 'desc')->get();

        // post admin
        $news = Post::get_by_where([
            'status' => Post::STATUS_SHOW,
//            'category_id' => 8,
//            'limit' => 4,
            'pagin' => false,
        ]);
        $this->_data['news'] = $news;


        return view('frontend.index.index', $this->_data);
    }

    public function Expert($slug, $id)
    {
        $currentDate = Carbon::now()->format('Y-m-d');

        $expert = CoreUsers::with(['duration', 'expertProfile', 'categoryExpert'])
            ->with(['times' => function ($query) use ($currentDate) {
                $query->whereDate('date', '>=', $currentDate);
            }])
            ->find($id);

        $times = $expert->times->toArray();

        $result = Common::ArraysFrameTime($times);


        // video youtube
        $videoYoutube = YoutubeExpert::where('user_expert_id', $expert->id)->where('status', 2)->get();
        // video ngắn
        $videoShort = ShortVideoExpert::where('user_expert_id', $expert->id)->where('type', 2)->where('status', 2)->get();
        // video tiktok
        $videoTiktok = ShortVideoExpert::where('user_expert_id', $expert->id)->where('type', 1)->where('status', 2)->get();
        $videoFacebook = ShortVideoExpert::where('user_expert_id', $expert->id)->where('type', 3)->where('status', 2)->get();
        $videoIntagram = ShortVideoExpert::where('user_expert_id', $expert->id)->where('type', 4)->where('status', 2)->get();
        // question
        $questionExpert = QuestionExpert::where('user_expert_id', $expert->id)->where('status', 2)->get();
        // bài viết của chuyên gia
        $postExpert = PostExpert::where('user_id', $expert->id)->where('status', 1)->paginate(12);

        // các gói
        $expertPlan = ExpertPlan::where('user_id', $expert->id)->where('status', 1)->orderBy('sort', 'asc')->get();

        // Hồ sơ khác
        $expertProfileOrther = ExpertProfileOrther::where('user_id', $expert->id)->where('status', 1)->orderBy('id', 'desc')->get();


        // todo : Chuyên gia tương tự
        // Lấy danh mục của chuyên gia cụ thể
        $categoryId = $expert->category_id_expert;

        // Lấy các chuyên gia khác cùng danh mục
        $expertsRelated = CoreUsers::where('category_id_expert', $categoryId)->with('categoryExpert')
            ->where('id', '!=', $id) // Loại trừ chính chuyên gia đang xem
            ->get();


        // Truy vấn tất cả các đánh giá của chuyên gia
        $ratings = RatingExpert::where('user_expert_id', $expert->id)->pluck('rating');
        // Tính tổng điểm đánh giá
        $totalRating = $ratings->sum();
        // Tính số lượng đánh giá
        $countRating = $ratings->count();
        // Tính điểm trung bình, kiểm tra để tránh chia cho 0
        $averageRating = $countRating > 0 ? $totalRating / $countRating : 0;
        // Làm tròn đến một chữ số thập phân
        $rating = round($averageRating, 1);
        // todo : end

        $this->_data['expert'] = $expert;
        $this->_data['times'] = $result;
        $this->_data['videoYoutube'] = $videoYoutube;
        $this->_data['videoShort'] = $videoShort;
        $this->_data['videoFacebook'] = $videoFacebook;
        $this->_data['videoIntagram'] = $videoIntagram;
        $this->_data['videoTiktok'] = $videoTiktok;
        $this->_data['questionExpert'] = $questionExpert;
        $this->_data['postExpert'] = $postExpert;
        $this->_data['expertRelated'] = $expertsRelated;
        $this->_data['rating'] = $rating;
        $this->_data['expertPlan'] = $expertPlan;
        $this->_data['expertProfileOrther'] = $expertProfileOrther;


        return view('frontend.expert.index', $this->_data);
    }


    public function followExpert($expertId)
    {
        $userId = Auth::guard('web')->id();
        $expert = CoreUsers::find($expertId);

        if ($userId) {
            FollowExpert::create([
                'user_id' => $userId,
                'expert_id' => $expert->id,
            ]);
            return redirect()->back()->with('success', 'Theo dõi thành công, bạn sẽ nhận thông báo bài viên mới nhất từ chuyên gia');
        } else {
            return redirect()->back()->with('info', 'Vui lòng đăng nhập để theo dõi');
        }
    }

    public function unfollowExpert($expertId)
    {
        $userId = Auth::guard('web')->id();
        $expert = CoreUsers::find($expertId);

        if ($userId) {
            FollowExpert::where('user_id', $userId)
                ->where('expert_id', $expert->id)
                ->delete();
            return redirect()->back()->with('success', 'Bỏ theo dõi thành công, bạn sẽ không nhận được thông báo bài viết mới nhất từ chuyên gia');
        } else {
            return redirect()->back()->with('info', 'Vui lòng đăng nhập để bỏ theo dõi');
        }
    }

    public function policy()
    {
        return view('frontend.info.policy-return-exchange', $this->_data);
    }

    public function faq()
    {
        return view('frontend.info.faq', $this->_data);
    }

    public function termOfUse()
    {
        return view('frontend.info.term-of-use', $this->_data);
    }

    public function orderingGuide()
    {
        return view('frontend.info.ordering-guide', $this->_data);
    }

    public function informationPrivacy()
    {
        return view('frontend.info.info-privacy', $this->_data);
    }

    public function shippingPolicy()
    {
        return view('frontend.info.shipping-policy', $this->_data);
    }

    public function STORAGE_INSTRUCTIONS()
    {
        return view('frontend.info.STORAGE_INSTRUCTIONS', $this->_data);
    }

    public function chat()
    {
        return view('frontend.info.chat', $this->_data);
    }

    public function smartttubeStable()
    {
        $apkUrl = asset('storage/frontendNew/assets/smarttube_stable_4.apk');
        $this->_data['apkUrl'] = $apkUrl;

        return view('frontend.info.smarttube_stable', $this->_data);
    }

    public function meeting(Request $request)
    {
        $user =  Auth::guard('web')->user();
        if (empty($user)) {
            return redirect()->route('frontend.user.login')->with('error', 'Vui lòng đăng nhập.');
        }



        if ($request->getMethod() == 'POST') {
            $room = $request->get('room');
            $Isroom = RoomMeet::CheckRoomCode($room);
            if ($Isroom['status'] == true) {
                $alias = $Isroom['alias'];


                $token =  auth('api')->login($user); // token cua chuyen gia
                $user->update(['token_api' => $token]);


                $expires_in = auth('api')->factory()->getTTL() * 60;


                //access_token=#{access_token}&token_type=Bearer&expires_in=#{expires_in}&start_with=host&quality=conference
                $token_type = 'access_token=' . $token . '&token_type=Bearer&expires_in=' . $expires_in . '&start_with=participant';

                $this->data['token']   = $token_type;
                $this->data['alias']   = $alias;

                return view('frontend.info.chat', $this->data);
            } else {
                return redirect()->back()->with('error', $Isroom['message']);
            }

        }

        return view('frontend.info.metting', $this->_data);
    }

    public function formBookingExpert(Request $request, $id)
    {
        $data = RequestExpert::where('id', $id)->with(['user', 'userExpert'])->first();
        if ($request->isMethod('post')) {
            try {
            $file_path = null;
            if ($request->hasFile('image_file_id_form')) {
                $file = $request->file('image_file_id_form');
                $filename = uniqid();
                $sub_dir = date('Y/m/d');
                $ext = $file->extension();
                $origin_file_name = $filename . '.' . $ext;
                $file_path = $sub_dir . '/' . $origin_file_name;
                $file->storeAs('public/uploads/' . $sub_dir, $origin_file_name);
                $fileRecord = new Files();
                $fileRecord->file_path = $file_path;
                $fileRecord->user_id = $data->user_id;

                $fileRecord->save();
            }
                $data->note_form = $request->get('note_form');
                if (isset($fileRecord)) {
                    $data->image_file_id_form = $fileRecord->id;
                }
                $data->save();
                return redirect()->route('frontend.formBookingExpertSummary', $data->id)->with('success', 'Chuyển đến thanh toán');
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
            }
        }
        $this->_data['data'] = $data;
        return view('frontend.expert.components.form', $this->_data);
    }

    public function formBookingExpertSummary(Request $request, $id)
    {
        $data = RequestExpert::where('id', $id)->with(['user', 'userExpert'])->first();
        $this->_data['data'] = $data;

        return view('frontend.expert.components.form_summary', $this->_data);
    }


    public function formBookingExpertPackageGroup(Request $request, $encryptedId)
    {
        $user =  Auth::guard('web')->user();
        if (empty($user)) {
            return redirect()->route('frontend.user.login')->with('error', 'Vui bạn đăng nhập.');
        }
//        // Giải mã id từ URL
//        try {
//            $id = Crypt::decrypt($encryptedId);
//        } catch (\Exception $e) {
//            abort(404); // Xử lý khi giải mã thất bại
//        }

        $data = ExpertPlan::where('id', $encryptedId)->with(['userExpert'])->first();

        if ($request->isMethod('post')) {
            try {
                $file_path = null;
                if ($request->hasFile('image_file_id_form')) {
                    $file = $request->file('image_file_id_form');
                    $filename = uniqid();
                    $sub_dir = date('Y/m/d');
                    $ext = $file->extension();
                    $origin_file_name = $filename . '.' . $ext;
                    $file_path = $sub_dir . '/' . $origin_file_name;
                    $file->storeAs('public/uploads/' . $sub_dir, $origin_file_name);
                    $fileRecord = new Files();
                    $fileRecord->file_path = $file_path;
                    $fileRecord->user_id = $data->user_id;

                    $fileRecord->save();
                }
                $data->note_form = $request->get('note_form');
                if (isset($fileRecord)) {
                    $data->image_file_id_form = $fileRecord->id;
                }
                $data->save();
                return redirect()->route('frontend.formBookingExpertSummary', $data->id)->with('success', 'Chuyển đến thanh toán');
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
            }
        }

        $this->_data['data'] = $data;
        $this->_data['id'] = $encryptedId;
        $this->_data['user_id'] =  Auth::guard('web')->user()->id;
        $this->_data['listPackageEmail'] = CoreUsers::get();
        return view('frontend.expert.components.formPackageGroup', $this->_data);
    }


    public function processPayment($id)
    {
        $expert = RequestExpert::findOrFail($id);
        $vnpayUrl = $this->createUrl($expert);

        return redirect()->to($vnpayUrl);
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



        //

    public function INTELLECTUAL_PROPERTY_POLICY()
    {
        return view('frontend.info.terms_of_use.INTELLECTUAL_PROPERTY_POLICY', $this->_data);
    }

    public function FRAMEWORK_SERVICE_AGREEMENT()
    {
        return view('frontend.info.terms_of_use.FRAMEWORK_SERVICE_AGREEMENT', $this->_data);
    }

    public function PRIVACY_NEZTWORK()
    {
        return view('frontend.info.terms_of_use.PRIVACY_NEZTWORK', $this->_data);
    }

    public function TERMS_FOR_EXPERTS()
    {
        return view('frontend.info.terms_of_use.TERMS_FOR_EXPERTS', $this->_data);
    }

    public function TERMS_FOR_AFFILIATEST()
    {
        return view('frontend.info.terms_of_use.TERMS_FOR_AFFILIATEST', $this->_data);
    }

    public function SERVICE_LAUNCH()
    {
        return view('frontend.info.terms_of_use.SERVICE_LAUNCH', $this->_data);
    }

    public function PRICING_POLICY()
    {
        return view('frontend.info.terms_of_use.PRICING_POLICY', $this->_data);
    }

    public function VNPAY()
    {
        return view('frontend.info.vnpay', $this->_data);
    }
}
