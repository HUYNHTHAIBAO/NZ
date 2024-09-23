<?php

namespace App\Http\Controllers\Frontend;

use App\Jobs\CancelRequestJob;
use App\Jobs\RejectExpiredRequest;
use App\Mail\ExpertApproveNegotiate;
use App\Mail\ExpertCancelBooking;
use App\Mail\ExpertNegotiateTime;
use App\Mail\UserApproveNegotiate;
use App\Models\ExpertCategoryTags;
use App\Models\VnpayRefund;
use App\Services\MailService;
use App\Utils\Common;
use App\Utils\Payment;
use App\Utils\Quikcom;
use Illuminate\Support\Facades\Http;

// Import lớp Http

use App\Classes\ActivationService;
use App\Classes\ResetPasswordService;
use App\Http\Controllers\BaseFrontendController;
use App\Mail\ExpertApprovedBooking;
use App\Mail\UserApprovedBooking;
use App\Mail\UserCancelBooking;
use App\Models\ExpertProfileUpdate;
use App\Models\Address;
use App\Models\Banks;
use App\Models\CoreUsers;
use App\Models\ExpertApplications;
use App\Models\ExpertCategory;
use App\Models\ExpertProfiles;
use App\Models\FileExpert;
use App\Models\Files;
use App\Models\Location\District;
use App\Models\Location\Province;
use App\Models\Location\Ward;
use App\Models\NotiExpert;
use App\Models\Orders;
use App\Models\RegisterExpertUpdate;
use App\Models\RequestExpert;
use App\Models\RoomMeet;
use App\Models\YourBank;
use App\Utils\Common as Utils;
use App\Utils\File;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class UserController extends BaseFrontendController
{
    protected $_data = [];
    protected $mailService;

    use RegistersUsers;

    public function __construct(ActivationService $activationService, ResetPasswordService $resetPasswordService, MailService $mailService)
    {
        parent::__construct();
        $this->activationService = $activationService;
        $this->_data['bank'] = Banks::all();
        $this->resetPasswordService = $resetPasswordService;
        $this->mailService = $mailService;
    }


    public function index(Request $request)
    {
        Auth::shouldUse('web');

        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        if ($request->isMethod('POST')) {
            $validate_rule = [
                'fullname' => 'required|max:255',
                'phone' => "required|numeric|unique:lck_core_users,phone,{$user->id}",
                'email' => "required|email|unique:lck_core_users,email,{$user->id}",
            ];

            $messsages = array(
                'fullname.required' => 'Họ tên không được để trống!',
                'phone.required' => 'Số điện thoại không được để trống!',
                'phone.unique' => 'Số điện thoại đã tồn tại trong hệ thống!',
                'phone.numeric' => 'Số điện thoại không hợp lệ!',
                'email.email' => 'Email không hợp lệ',
                'email.unique' => 'Email đã tồn tại trong hệ thống',
                'email.required' => 'Email không được để trống',
            );

            Validator::make($request->all(), $validate_rule, $messsages)->validate();
//
            try {
                DB::beginTransaction();

                $user->phone = $request->get('phone', $user->phone);
                $user->fullname = $request->get('fullname', $user->fullname);
                $user->email = $request->get('email', $user->email);
                $user->gender = $request->get('gender', $user->gender);
                $user->birthday = $request->get('birthday', $user->birthday);
                $user->address = $request->get('address', $user->address);
                $user->save();
                DB::commit();
                return redirect()->back()->with('success', 'Cập nhật thông tin thành công');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau !');
            }
        }
        $breadcrumbs = [];
        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => 'Cập nhật thông tin'
        );
        $this->_data['title'] = 'Cập nhật thông tin';
        $this->_data['menu_active'] = '';
        $this->_data['breadcrumbs'] = $breadcrumbs;
        $this->_data['user'] = $user;


//        $this->_data['provinces'] = Province::orderBy('priority', 'ASC')->get();
//        $this->_data['districts'] =District::orderBy('priority', 'ASC')->get();
//        $this->_data['wards'] =  Ward::orderBy('priority', 'ASC')->get();


        return view('frontend.user.index', $this->_data);
    }

    public function profile(Request $request)
    {
        Auth::shouldUse('web');

        $user = CoreUsers::find(Auth()->guard('web')->user()->id);


        $breadcrumbs = [];

        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => 'Thông tin tài khoản'
        );
        $this->_data['title'] = 'Thông tin tài khoản';
        $this->_data['user'] = $user;
        $this->_data['menu_active'] = '';
        $this->_data['breadcrumbs'] = $breadcrumbs;
        return view('frontend.user.profile', $this->_data);
    }

    public function login(Request $request)
    {

        if (Auth()->guard('web')->user()) {
            return redirect(Route('frontend.user.account'));
        }
        // Validate dữ liệu đầu vào từ form đăng nhập
        $validator = Validator::make($request->all(), [
            'phone_or_email' => 'required',
            'password' => 'required',
        ], [
            'phone_or_email.required' => 'Số điện thoại & Email không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
        ]);

        if ($request->isMethod('POST')) {
            // Kiểm tra xem dữ liệu đã được validate chưa
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $credentials = $request->only(['phone_or_email', 'password']);
            try {

                $user = CoreUsers::where(['email' => $credentials['phone_or_email']])
                    ->orWhere(['phone' => $credentials['phone_or_email']])
                    ->first();


                if (!$user) {
                    return redirect()->back()->with('warning', 'Tài khoản không tồn tại');

                }
                if (!Hash::check($credentials['password'], $user->password)) {
                    return redirect()->back()->with('warning', 'Tài khoản hoặc Mật khẩu không hợp lệ');
                }

                if ($user->status == CoreUsers::$status_banned) {
                    return redirect()->back()->with('danger', 'Tài khoản đã bị khóa!');
                }

                if ($user->status == CoreUsers::$status_inactive) {
                    return redirect()->back()->with('warning', 'Tài khoản chưa kích hoạt, đang đợi Admin xét duyệt!');
                }

                $user->last_login = date('Y-m-d H:i:s');
                $user->token_api = auth('api')->login($user);
                $user->save();
                Auth::shouldUse('web');
                Auth::guard('web')->login($user, true);
                return redirect()->route('frontend.user.profile')->with('success', 'Đăng nhập thành công');
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                return redirect()->back()->with('warning', 'Đăng nhập thất bại, vui lòng thử lại sau !');

            }
        }
        $breadcrumbs = [];
        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => 'Đăng nhập'
        );

        $this->_data['title'] = 'Đăng nhập';
        $this->_data['menu_active'] = '';
        $this->_data['breadcrumbs'] = $breadcrumbs;
        return view('frontend.user.login', $this->_data);
    }

    public function register(Request $request)
    {
        if (Auth()->guard('web')->user()) {
            return redirect(url('/'));
        }

        $validator_rule = [
            'fullname' => 'required',
            'email' => 'required|email|unique:lck_core_users,email',
            'phone' => 'required|unique:lck_core_users,phone',
            'password' => 'required|min:6',
            'referrer_id' => 'nullable',
        ];
        $messages = [
            'fullname.required' => 'Họ tên không được để trống',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'email.required' => 'Email không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.unique' => 'Số điện thoại đã tồn tại trong hệ thống!',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ];


        $form_init = array_fill_keys(array_keys($validator_rule), null);
        $form_init = array_merge($form_init, $request->all());
        $form_init = array_merge($form_init, $request->old());

        // Tạo avatar từ tên người dùng
        $avatarInitials = Common::generateAvatarInitials($form_init['fullname']);
        if ($request->getMethod() == 'POST') {
            Validator::make($request->all(), $validator_rule, $messages)->validate();
            DB::beginTransaction();
            try {
                $form_init['status'] = CoreUsers::$status_active;
                $form_init['password'] = Hash::make($form_init['password']);
                $form_init['avatar_name'] = $avatarInitials;
                $user = CoreUsers::create($form_init);

                if ($user) {
                    if (!empty($form_init['phone_referrer'])) {
                        $user_be_referrer = CoreUsers::where('phone', $form_init['phone_referrer'])->first();
                        if (!empty($user_be_referrer)) {
                            $user->referrer_id = $user_be_referrer->id;
                            if (!empty($user_be_referrer->agency_level)) {
                                $user->agency_level = $user_be_referrer->agency_level + 1;
                            }
                        }
                        $user->save();
                    }

                    $this->activationService->sendActivationMail($user);
                    DB::commit();
                    return redirect()->route('frontend.user.login')->with('success', 'Đăng ký thành công');
                } else {
                    DB::rollBack();
                    return redirect()->route('frontend.user.register')->with('error', 'Đăng ký thất bại, vui lòng thử lại sau');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('frontend.user.register')->with('error', 'Đăng ký thất bại, vui lòng thử lại sau');
            }
        }

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'link' => 'javascript:;',
            'name' => 'Đăng ký'
        ];
        $this->_data['title'] = 'Đăng ký tài khoản';
        $this->_data['menu_active'] = '';
        $this->_data['breadcrumbs'] = $breadcrumbs;
        return view('frontend.user.register', $this->_data);
    }


    public function bank(Request $request)
    {
        $banks = YourBank::where('user_id', Auth('web')->user()->id)->first();
        $validator_rule = YourBank::get_validation_admin();
        $params = array_fill_keys(array_keys($validator_rule), null);
        if ($request->getMethod() == 'POST') {
            Validator::make($request->all(), $validator_rule)->validate();
            $params = array_merge(
                $params, $request->only(array_keys($validator_rule))
            );
            try {
                $params['user_id'] = Auth()->guard('web')->user()->id;
                if (!empty($banks)) {
                    $banks->update($params);
                } else {
                    YourBank::create($params);
                    $request->session()->flash('msg', ['success', 'Cập nhật thông tin thành công!']);
                    return redirect()->back();
                }
                $request->session()->flash('msg', ['success', 'Cập nhật thông tin thành công!']);
            } catch (\Exception $e) {
                $request->session()->flash('msg', ['error', 'Có lỗi xảy ra, vui lòng thử lại!' . $e->getMessage()]);
            }
        }
        $breadcrumbs = [];
        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => 'Tài khoản ngân hàng'
        );
        $this->_data['title'] = 'Tài khoản ngân hàng';

        $this->_data['breadcrumbs'] = $breadcrumbs;
        $this->_data['banks'] = $banks;
        return view('frontend.user.bank', $this->_data);
    }

    public function activate($token, Request $request)
    {
        if ($request->get('confirm')) {
            $msg = 'Kích hoạt tài khoản thất bại!';
            $class = 'danger';

            if ($user = $this->activationService->activateUser($token)) {
                $msg = 'Kích hoạt tài khoản thành công!';
                $class = 'success';
            }
            $this->_data['msg'] = $msg;
            $this->_data['class'] = $class;
        } else {
            $this->_data['token'] = $token;
        }
        $breadcrumbs = [];
        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => 'Kích hoạt tài khoản'
        );

        $this->_data['title'] = 'Kích hoạt tài khoản';
        $this->_data['menu_active'] = '';
        $this->_data['breadcrumbs'] = $breadcrumbs;

        return view('frontend.user.activate', $this->_data);
    }

    public function forgotPassword(Request $request)
    {
        if (Auth()->guard('web')->user())
            return redirect(url('/'));

        $validator_rule = [
            'email' => 'required|email|exists:lck_core_users,email',
        ];
        $messsages = array(
            'email.required' => 'Vui lòng nhập Email',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Không tồn tại tài khoản có Email này',
        );
        if ($request->getMethod() == 'POST') {

            Validator::make($request->all(), $validator_rule, $messsages)->validate();

            $user = CoreUsers::where('email', $request->email)->first();

            if ($user) {
                $request->session()->flash('msg', ['success', 'Vui lòng kiểm tra hộp thư email và làm theo hướng dẫn trong đó để đặt lại mật khẩu!']);
                $this->resetPasswordService->sendActivationMail($user);
                return redirect(route('frontend.user.forgotPassword'));
            }
        }

        $breadcrumbs = [];

        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => 'Quên mật khẩu'
        );
        $this->_data['title'] = 'Quên mật khẩu';
        $this->_data['menu_active'] = '';
        $this->_data['breadcrumbs'] = $breadcrumbs;
        return view('frontend.user.forgot-password', $this->_data);
    }

    public function resetPassword($token, Request $request)
    {
        if (!$user = $this->resetPasswordService->checkToken($token))
            return redirect(url('/'));

        if ($request->getMethod() == 'POST') {

            $validator_rule = [
                'password' => 'required|min:6|confirmed',
            ];
            $messsages = array(
                'password.required' => 'Vui lòng nhập mật khẩu!',
                'password.confirmed' => 'Xác nhận mật khẩu không hợp lệ!',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            );

            Validator::make($request->all(), $validator_rule, $messsages)->validate();
            DB::beginTransaction();
            try {

                $user->password = Hash::make($request->password);
                $user->save();

                $request->session()->flash('msg', ['success', 'Đổi mật khẩu thành công']);

                $this->resetPasswordService->deleteToken($token);

                DB::commit();

                return redirect(route('frontend.user.login'));
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }

        $breadcrumbs = [];

        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => 'Đặt mật khẩu'
        );
        $this->_data['title'] = 'Đặt mật khẩu';
        $this->_data['menu_active'] = '';
        $this->_data['breadcrumbs'] = $breadcrumbs;

        return view('frontend.user.reset-password', $this->_data);
    }

    public function intro(Request $request, $phone)
    {
        $user_intro = CoreUsers::where('phone', $phone)->first();
        $request->session()->flash('msg', ['aaaaa', $user_intro->toArray()]);
        return redirect(url('/user/register'));
    }

    public function order(Request $request)
    {
        $filter = $params = array_merge(array(
            'phone' => null,
            'status' => null,
            'limit' => 10,
        ), $request->all());

        $objModel = new Orders();

        $params['pagin_path'] = Utils::get_pagin_path($filter);

        $params['user_id'] = Auth()->guard('web')->user()->id;
        $data_list = $objModel->get_by_where($params);

        $start = ($data_list->currentPage() - 1) * $filter['limit'];

        $this->_data['data_list'] = $data_list;
        $this->_data['start'] = $start;
        $this->_data['filter'] = $filter;

        $breadcrumbs = [];

        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => 'Đơn hàng'
        );

        $this->_data['status'] = Orders::$status;
        $this->_data['title'] = 'Đơn hàng';
        $this->_data['menu_active'] = '';
        $this->_data['breadcrumbs'] = $breadcrumbs;

        return view('frontend.user.order', $this->_data);
    }

    public function logout(Request $request)
    {
        Auth::shouldUse('web');
        if (Auth()->guard('web')->user()->id) {
            Auth()->guard('web')->logout();
        }

        if ($request->get('ref'))
            return redirect($request->get('ref'));
        else
            return redirect()->route('frontend.user.login')->with('success', 'Đăng xuất thành công');
    }

    public function address(Request $request)
    {
        $user = $this->getUser();

        $address = Address::where('user_id', $user->id)->get();

        $this->_data['address'] = $address;
        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => 'Sổ địa chỉ'
        );
        $this->_data['provinces'] = Province::orderBy('priority', 'ASC')->get();

        $this->_data['breadcrumbs'] = $breadcrumbs;
        return view('frontend.user.address', $this->_data);
    }

    public function editAddress(Request $request, $id)
    {

        $this->_data['breadcrumbs'] = [
            [
                'link' => 'javascript:;',
                'name' => 'Kênh người bán'
            ],
            [
                'link' => 'javascript:;',
                'name' => 'Địa chỉ'
            ],
            [
                'link' => 'javascript:;',
                'name' => 'Sửa địa chỉ'
            ]
        ];

        $user = $this->getUser();

        $address = Address::where('user_id', $user->id)->where('id', $id)->first();

        if (!$address) return abort(404);

        if ($request->isMethod('POST')) {
            $validate_rule = [
                'name' => 'required|string|max:255',
                'phone' => "required|bail|numeric",
                'province_id' => "required|bail|required|exists:lck_location_province,id",
                'district_id' => "required|bail|required|exists:lck_location_district,id",
                'ward_id' => "required|bail|required|exists:lck_location_ward,id",
                'street_name' => 'required|bail|string|max:200',
                'is_default_recipient' => "nullable|bail|in:0,1",
                'is_warehouse' => "nullable|bail|in:0,1",
                'is_return' => "nullable|bail|in:0,1",
            ];

            Validator::make($request->all(), $validate_rule)->validate();

            try {
                DB::beginTransaction();

                $params = array_fill_keys(array_keys($validate_rule), null);
                $params = array_merge(
                    $params, $request->only(array_keys($params))
                );

                $params['full_address'] = Address::get_full_address($params);

                Address::where('id', $id)->where('user_id', $user->id)->update($params);

                if ($params['is_default_recipient'] == 1) {
                    Address::where('is_default_recipient', '=', 1)
                        ->where('id', '<>', $id)
                        ->where('user_id', $user->id)
                        ->update(['is_default_recipient' => 0]);
                }
                if ($params['is_warehouse'] == 1) {
                    Address::where('is_warehouse', '=', 1)
                        ->where('id', '<>', $id)
                        ->where('user_id', $user->id)
                        ->update(['is_warehouse' => 0]);
                }
                if ($params['is_return'] == 1) {
                    Address::where('is_return', '=', 1)
                        ->where('id', '<>', $id)
                        ->where('user_id', $user->id)
                        ->update(['is_return' => 0]);
                }

                DB::commit();
                $request->session()->flash('msg', ['success', 'Cập nhật thành công']);

                return redirect(route('frontend.user.address'));
            } catch (\Exception $e) {
                DB::rollBack();
                $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
                return redirect()->back();
            }
        }
        $this->_data['address'] = $address;
        $this->_data['provinces'] = Province::orderBy('priority', 'ASC')->get();

        $this->_data['districts'] = District::where('province_id', $address->province_id)->orderBy('priority', 'ASC')->get();

        $this->_data['wards'] = Ward::where('district_id', $address->district_id)->orderBy('priority', 'ASC')->get();

        return view('frontend.user.edit-address', $this->_data);
    }

    public function changePassword(Request $request)
    {
        Auth::shouldUse('web');

        $user = CoreUsers::find(Auth()->guard('web')->user()->id);

        if ($request->isMethod('POST')) {
            $validate_rule = [
                'password_old' => 'required|string',
                'password' => 'required|string|min:6',
                'password_confirmation' => 'required|string|min:6|same:password',
            ];


            $messsages = [
                'password_old.required' => 'Mật khẩu cũ không được để trống',
                'password.required' => 'Mật khẩu mới không được để trống',
                'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự',
                'password_confirmation.required' => 'Xác nhận lại mật khẩu không được để trống',
                'password_confirmation.min' => 'Xác nhận lại mật khẩu phải có ít nhất 6 ký tự',
                'password_confirmation.same' => 'Xác nhận lại mật khẩu không khớp với mật khẩu mới',
            ];

            Validator::make($request->all(), $validate_rule, $messsages)->validate();

            try {
                DB::beginTransaction();
                $password_old = $request->get('password_old', null);
                $password = $request->get('password', null);
                $password_confirmation = $request->get('password_confirmation', null);
                if ($password) {
                    if (empty($password_old))
                        return redirect()->back()->with('warning', 'Vui lòng nhập mật khẩu cũ');
                    if (!Hash::check($password_old, $user->password))
                        return redirect()->back()->with('warning', 'Mật khẩu cũ không hợp lệ');
                    if ($password != $password_confirmation)
                        return redirect()->back()->with('warning', 'Xác nhận lại mật khẩu mới không khớp');

                    $user->password = Hash::make($password);
                }
                $user->save();

                DB::commit();

                return redirect()->route('frontend.user.logout')->with('success', 'Đổi mật khẩu thành công');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại sau !');
            }
        }
        return view('frontend.user.changePassword', $this->_data);
    }

    public function registerExpert(Request $request)
    {
        Auth::shouldUse('web');
        $user = Auth::guard('web')->user();

        if ($request->isMethod('POST')) {

            $validate_rule = [
                'category_id_expert' => 'required',
                'tags_id' => 'required',
                'bio' => 'required|string',
                'job' => 'required|string',
                'advise' => 'required|string',
                'questions' => 'required|string',
                'facebook_link' => 'nullable|url',
                'x_link' => 'nullable|url',
                'instagram_link' => 'nullable|url',
                'tiktok_link' => 'nullable|url',
                'linkedin_link' => 'nullable|url',
            ];
            $messages = [
                'bio.required' => 'Thông tin giới thiệu không được để trống',
                'job.required' => 'Nghề nghiệp hiện tại không được để trống',
                'advise.required' => 'Thing I can advice on không được để trống',
                'questions.required' => 'Question to ask with me không được để trống',
                'category_id_expert.required' => 'Danh mục không được để trống',
                'tags_id.required' => 'Tags không được để trống',
                'facebook_link.url' => 'Link không đúng định dạng',
                'x_link.url' => 'Link không đúng định dạng',
                'instagram_link.url' => 'Link không đúng định dạng',
                'tiktok_link.url' => 'Link không đúng định dạng',
                'linkedin_link.url' => 'Link không đúng định dạng',
            ];

            Validator::make($request->all(), $validate_rule, $messages)->validate();

            try {
                DB::beginTransaction();

                if ($user->account_type != 2) {
                    // Người dùng đăng ký lần đầu
                    $user->bio = $request->get('bio');
                    $user->job = $request->get('job');
                    $user->advise = $request->get('advise');
                    $user->questions = $request->get('questions');
                    $user->facebook_link = $request->get('facebook_link');
                    $user->x_link = $request->get('x_link');
                    $user->instagram_link = $request->get('instagram_link');
                    $user->tiktok_link = $request->get('tiktok_link');
                    $user->linkedin_link = $request->get('linkedin_link');
                    $user->category_id_expert = $request->get('category_id_expert');
                    $user->account_type = 1;
                    $user->approved = 1;
                    $user->tags_id = json_encode($request->get('tags_id'));
                    $user->save();
                    DB::commit();
                    return redirect()->route('frontend.user.registerExpert')->with('success', 'Đăng ký thành công, vui lòng chờ duyệt');

                } else {
                    // Người dùng đã tồn tại, lưu thông tin cập nhật vào RegisterExpertUpdate
                    $registerExpertUpdate = RegisterExpertUpdate::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'bio' => $request->get('bio'),
                            'job' => $request->get('job'),
                            'advise' => $request->get('advise'),
                            'questions' => $request->get('questions'),
                            'facebook_link' => $request->get('facebook_link'),
                            'x_link' => $request->get('x_link'),
                            'instagram_link' => $request->get('instagram_link'),
                            'tiktok_link' => $request->get('tiktok_link'),
                            'linkedin_link' => $request->get('linkedin_link'),
                            'category_id_expert' => $request->get('category_id_expert'),
                            'approved' => 1 // Chỉ định đã được duyệt
                        ]
                    );
                    // Xóa dữ liệu trong trường reason_for_refusal
                    $registerExpertUpdate->reason_for_refusal = null;
                    $registerExpertUpdate->tags_id = json_encode($request->get('tags_id'));
                    $registerExpertUpdate->save();
                    $user->approved = 4;
                    $user->save();
                    DB::commit();
                    return redirect()->route('frontend.user.registerExpert')->with('success', 'Cập nhật thành công, vui lòng chờ duyệt');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('warning', 'Có lỗi, vui lòng thử lại sau!');
            }
        }

        $category_id_expert = $request->get('category_id_expert') ?? $user->category_id_expert;
        $category_expert = ExpertCategory::where('status', 1)->get();
        $tags_expert = [];
        $selectedTags = [];
        $tags_expert_details = collect(); // Khởi tạo mảng rỗng cho biến này

        if ($category_id_expert) {
            $tags_expert_raw = CoreUsers::where('category_id_expert', $category_id_expert)
                ->pluck('tags_id')
                ->toArray();

            $tags_expert_ids = [];
            foreach ($tags_expert_raw as $tags) {
                $decoded_tags = json_decode($tags, true);
                if (is_array($decoded_tags)) {
                    $tags_expert_ids = array_merge($tags_expert_ids, $decoded_tags);
                }
            }

            $tags_expert_ids = array_unique($tags_expert_ids);
            $tags_expert_details = ExpertCategoryTags::whereIn('id', $tags_expert_ids)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->get();

            $selectedTags = $tags_expert_details->pluck('id')->toArray();
        }

        return view('frontend.user.registerExpert', compact('category_expert', 'tags_expert', 'tags_expert_details', 'selectedTags'));
    }

    public function bookingHistory()
    {
        $userId = auth()->guard('web')->id();
        $accountType = auth()->guard('web')->user()->account_type;
        // Lấy dữ liệu từ bảng RequestExpert kèm theo quan hệ userExpert và duration
        $query = RequestExpert::where('status', 1)->with(['userExpert', 'duration'])
            ->orderBy('id', 'desc');
        // Thêm điều kiện lọc dựa vào kiểu tài khoản
        if ($accountType == 2) {
            // Nếu là expert, chỉ lấy dữ liệu của user_expert_id đó
            $query->where('user_expert_id', $userId);
        } else {
            // Nếu là user, chỉ lấy dữ liệu của user_id đó
            $query->where('user_id', $userId);
        }
        $data = $query->paginate(10);
        // Khởi tạo mảng để chứa thông tin hoàn tiền cho từng request_expert
        $refunds = [];
        // Lặp qua từng phần tử trong $data để lấy thông tin hoàn tiền
        foreach ($data as $requestExpert) {
            $refund = VnpayRefund::where('request_expert_id', $requestExpert->id)->first();
            $refunds[$requestExpert->id] = $refund;
        }
        // Đưa dữ liệu vào view
        $this->_data['data'] = $data;
        $this->_data['refunds'] = $refunds;

        return view('frontend.user.bookingHistory', $this->_data);
    }

    public function check(Request $request, $id)
    {
        $data = RequestExpert::find($id);

        if ($data->key == 2) {// goi thang
            return $this->checkMonth($data);
        }

        if ($data->key == 3) {// goi nhóm
            return $this->checkGroup($data);
        }


        $userExpertId = $data->user_expert_id; // Lấy ID của chuyên gia

        $currentDate = Carbon::now()->format('Y-m-d');

        // Tìm chuyên gia với các quan hệ và thời gian
        $expert = CoreUsers::with(['duration', 'expertProfile', 'categoryExpert', 'times' => function ($query) use ($currentDate) {
            $query->whereDate('date', '>=', $currentDate);
        }])
            ->find($userExpertId);

        // Kiểm tra nếu chuyên gia tồn tại và có thời gian
        $times = $expert ? $expert->times->toArray() : [];

        $result = Common::ArraysFrameTime($times);

        $this->_data['times'] = $result;
        $this->_data['data'] = $data;
        return view('frontend.user.checkBooking', $this->_data);
    }

    public function checkMonth($data)
    {

        $this->_data['data'] = $data;
        return view('frontend.user.checkBookingMonth', $this->_data);
    }

    public function checkGroup($data)
    {

        $this->_data['data'] = $data;
        return view('frontend.user.checkBookingGroup', $this->_data);
    }

    public function approve(Request $request, $id)
    {
        try {
            // Tìm bản ghi RequestExpert hoặc trả về lỗi nếu không tìm thấy
            $data = RequestExpert::with(['user', 'userExpert'])->findOrFail($id);
            // Tìm người dùng có user_id tương ứng với dữ liệu request
            $user = CoreUsers::where('id', $data->user_id)->firstOrFail();
            if ($request->isMethod('post')) {
                // Cập nhật các thuộc tính của RequestExpert
                $data->note = $request->input('note', ''); // Lấy giá trị của 'note', mặc định là chuỗi rỗng
                $data->type = 2;
                $data->save();
                // Gửi email thông báo
                $htmlContent = view('email.expert_approved_booking', [
                    'data' => $data,
                ])->render(); // view

                // email người nhận
                $recipients = [$data->email_user];
                $mailResponses = [];

                foreach ($recipients as $recipient) {
                    $mailResponses[] = $this->mailService->sendMail(
                        'CHUYÊN GIA XÁC NHẬN ĐẶT LỊCH',
                        $htmlContent,
                        '',
                        $recipient,
                        '',          // Đường dẫn tệp đính kèm (nếu có)
                        [
                            'customerName' => '',
                            'customerEmail' => '',
                        ]
                    );
                }
                // Kiểm tra kết quả của tất cả các lần gửi email
                $allSuccessful = true;
                $errorMessages = '';
                foreach ($mailResponses as $mailResponse) {
                    if ($mailResponse['status'] !== 200) {
                        $allSuccessful = false;
                        $errorMessages .= $mailResponse['body'] . ' ';
                    }
                }
                if ($allSuccessful) {
                    return redirect()->route('frontend.user.check', ['id' => $id])->with('success', 'Xác nhận thành công');
                } else {
                    return redirect()->back()->with('danger', 'Có lỗi xảy ra khi gửi email: ' . $errorMessages);
                }
            }

            // Trả về view bookingHistory với dữ liệu
            $this->_data['data'] = $data;
            return view('frontend.user.bookingHistory', $this->_data);
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại: ' . $e->getMessage());
        }
    }


    public function reject(Request $request, $id)
    {
        $data = RequestExpert::find($id);
        if (!$data) {
            return redirect()->back()->with('danger', 'Yêu cầu không tồn tại');
        }

        $user = CoreUsers::where('id', $data->user_expert_id)->firstOrFail();
        $categoryId = $user->category_id_expert;

        // Tìm các chuyên gia tương tự trong cùng một danh mục
        $similarExperts = CoreUsers::where('category_id_expert', $categoryId)
            ->where('id', '<>', $data->user_expert_id) // Không lấy chính chuyên gia hiện tại
            ->limit(5) // Giới hạn số lượng chuyên gia gợi ý
            ->get();
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'note_reject' => 'required',
            ], [
                'note_reject.required' => 'Lý do từ chối không được để trống',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
                // Gọi hàm hoàn tiền
                $params = VnpayRefund::create([
                    'user_name' => Auth::guard('web')->user()->fullname,
                    'request_expert_id' => $id,
                    'vnp_Amount' => $data->price * 100,
                    'vnp_TransactionNo' => $data->vnp_TransactionNo,
                ]);
                Payment::Refund($params->toArray());

                // Cập nhật trạng thái yêu cầu
                $data->note_reject = $request->get('note_reject');
                $data->type = 3;
                $data->update();
                // Gửi email thông báo
                // Render nội dung email từ view
                $htmlContent = view('email.expert_cancel_booking', [
                    'data' => $data,
                    'similarExperts' => $similarExperts,
                ])->render();

// Địa chỉ email người nhận
                $recipients = [$data->email_user];
                $mailResponses = [];

// Gửi email cho từng người nhận
                foreach ($recipients as $recipient) {
                    $mailResponses[] = $this->mailService->sendMail(
                        'CHUYÊN GIA TỪ CHỐI ĐẶT LỊCH',
                        $htmlContent,
                        '', // Đường dẫn tệp đính kèm (nếu có)
                        $recipient,
                        '',
                        [
                            'customerName' => '', // Có thể điền tên khách hàng nếu cần
                            'customerEmail' => '', // Có thể điền email khách hàng nếu cần
                        ]
                    );
                }
                $allSuccessful = true;
                $errorMessages = '';
                foreach ($mailResponses as $mailResponse) {
                    if ($mailResponse['status'] !== 200) {
                        $allSuccessful = false;
                        $errorMessages .= $mailResponse['body'] . ' ';
                    }
                }
                if ($allSuccessful) {
                    return redirect()->route('frontend.user.check', ['id' => $id])->with('success', 'Từ chối thành công');
                } else {
                    return redirect()->back()->with('danger', 'Có lỗi xảy ra khi gửi email: ' . $errorMessages);
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
            }
        }

        $this->_data['data'] = $data;
        return view('frontend.user.bookingHistory', $this->_data);
    }

    public function negotiatetime($id, Request $request)
    {

        $data = RequestExpert::find($id);
        try {
            $data->time = date("g:i A", strtotime($request->get('time')));
            $data->date = date('Y-m-d', strtotime($request->get('date'))); // Chuyển đổi định dạng date
            $data->duration_id = $request->get('duration_id');
            $data->type = 2;
            $data->update();

            $htmlContent = view('email.expert_negotiatetime_month', [
                'data' => $data,
            ])->render();
            $recipients = [$data->email_user];
            $mailResponses = [];

// Gửi email cho từng người nhận
            foreach ($recipients as $recipient) {
                $mailResponses[] = $this->mailService->sendMail(
                    'CHUYÊN GIA THƯƠNG LƯỢNG THỜI GIAN ĐĂT GÓI THEO THÁNG',
                    $htmlContent,
                    '', // Đường dẫn tệp đính kèm (nếu có)
                    $recipient,
                    '',
                    [
                        'customerName' => '', // Có thể điền tên khách hàng nếu cần
                        'customerEmail' => '', // Có thể điền email khách hàng nếu cần
                    ]
                );
            }
            $allSuccessful = true;

            $errorMessages = '';
            foreach ($mailResponses as $mailResponse) {
                if ($mailResponse['status'] !== 200) {
                    $allSuccessful = false;
                    $errorMessages .= $mailResponse['body'] . ' ';
                }
            }
            if ($allSuccessful) {
                return redirect()->route('frontend.user.check', ['id' => $id])->with('success', 'Thương lượng thời gian thành công. Vui lòng đợi khách hàng phản hồi.');
            } else {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra khi gửi email: ' . $errorMessages);
            }


        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');

        }


    }

    public function timeNegotiate(Request $request, $id)
    {
        $data = RequestExpert::find($id);
        $user = CoreUsers::where('id', $data->user_expert_id)->firstOrFail();

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'time' => 'required',
            ], [
                'time.required' => 'Thời gian không được để trống',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {

                $data->time_negotiate = $request->get('time');
                $data->date_negotiate = date('Y-m-d', strtotime($request->get('date'))); // Chuyển đổi định dạng date
                $data->type = 5;

                $data->update();
                $htmlContent = view('email.expert_negotiateTime_booking', [
                    'data' => $data,
                ])->render();

                // Địa chỉ email người nhận
                $recipients = [$data->email_user];
                $mailResponses = [];

                // Gửi email cho từng người nhận
                foreach ($recipients as $recipient) {
                    $mailResponses[] = $this->mailService->sendMail(
                        'CHUYÊN GIA THƯƠNG LƯỢNG LẠI THỜI GIAN ĐẶT LỊCH',
                        $htmlContent,
                        '', // Đường dẫn tệp đính kèm (nếu có)
                        $recipient,
                        '',
                        [
                            'customerName' => '', // Có thể điền tên khách hàng nếu cần
                            'customerEmail' => '', // Có thể điền email khách hàng nếu cần
                        ]
                    );
                }


                $allSuccessful = true;
                $errorMessages = '';
                foreach ($mailResponses as $mailResponse) {
                    if ($mailResponse['status'] !== 200) {
                        $allSuccessful = false;
                        $errorMessages .= $mailResponse['body'] . ' ';
                    }
                }


//                Mail::to($data->email_user)->send(new ExpertNegotiateTime($data));

                if ($allSuccessful) {
                    return redirect()->route('frontend.user.check', ['id' => $id])->with('success', 'Đã gửi thời gian đề xuất mới tới khách hàng, xin vui lòng chờ khách hàng xác nhận');
                } else {
                    return redirect()->back()->with('danger', 'Có lỗi xảy ra khi gửi email: ' . $errorMessages);
                }

            } catch
            (\Exception $e) {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
            }
        }

        $this->_data['data'] = $data;
        return view('frontend.user.bookingHistory', $this->_data);
    }


    public
    function notification()
    {

        $data = NotiExpert::orderBy('id', 'desc')->paginate(10);

        $this->_data['data'] = $data;
        return view('frontend.user.notificatios', $this->_data);
    }

    public
    function avatar(Request $request)
    {
        Auth::shouldUse('web');

        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        if ($request->isMethod('POST')) {

            try {
                DB::beginTransaction();

                $file_path = null;
                if ($request->hasFile('avatar_file_id')) {
                    $file = $request->file('avatar_file_id');
                    $filename = uniqid();
                    $sub_dir = date('Y/m/d');
                    $ext = $file->extension();
                    $origin_file_name = $filename . '.' . $ext;
                    $file_path = $sub_dir . '/' . $origin_file_name;
                    $file->storeAs('public/uploads/' . $sub_dir, $origin_file_name);
                    $fileRecord = new Files();
                    $fileRecord->file_path = $file_path;
                    $fileRecord->user_id = $user->id;
                    $fileRecord->save();
                    $user->avatar_file_id = $fileRecord->id;
                    $user->avatar_file_path = $fileRecord->file_path;
                }
                $user->save();
                DB::commit();
                return redirect()->back()->with('success', 'Cập nhật ảnh thành công');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau !');
            }
        }

        $this->_data['user'] = $user;
        return view('frontend.user.avatar', $this->_data);
    }

    // todo : khách hàng phê duyệt đặt lịch
    public
    function userApprove(Request $request, $id)
    {
        $data = RequestExpert::findOrFail($id);
        $user = CoreUsers::findOrFail($data->user_id);


        // Ngày giờ hiện tại
        $currentTime = Carbon::now();
        $thoigianhientai = $currentTime->format('Y-m-d H:i:s'); // Lấy giờ, phút, giây
        $thoigiandatlich = $data->created_at;
        $requestTime = Carbon::parse($data->date)->format('Y-m-d') . ' ' . $data->time;
        $thoigianmetting = $requestTime;


        // Chuyển đổi các thời gian sang đối tượng Carbon để tính toán
        $startTime = Carbon::parse($thoigiandatlich);
        $endTime = Carbon::parse($thoigianmetting);
        $currentTime = Carbon::parse($thoigianhientai);

        // Tính tổng thời gian từ lúc đặt lịch đến lúc meeting
        $totalDuration = $startTime->diffInSeconds($endTime);

        // Tính thời gian đã trôi qua từ lúc đặt lịch đến thời điểm hiện tại
        $elapsedTime = $startTime->diffInSeconds($currentTime);

        // Tính phần trăm thời gian đã trôi qua
        $percentage = ($elapsedTime / $totalDuration) * 100;


        DB::beginTransaction();
        try {

            $data->type_request_user = 2;
            $data->save();
            $thoigiandatlich = $data->created_at;
            $requestTime = Carbon::parse($data->date)->format('Y-m-d') . ' ' . $data->time;
            $date = Carbon::createFromFormat('Y-m-d h:i A', $requestTime);
            $thoigianmetting = $date->format('Y-m-d H:i:s');
            // Chuyển đổi các thời gian sang đối tượng Carbon để tính toán

            $duration = intval($data->duration_id);// 15
            $StartTime = Carbon::parse($thoigianmetting);
            $EndTime = Carbon::parse($thoigianmetting)->addMinutes($duration);

            $expire_at = $EndTime->timestamp * 1000;
            $end_date = $EndTime->timestamp * 1000;
            $start_date = $StartTime->timestamp * 1000;
            $quckcom = new Quikcom();
            $room = $quckcom->createRoom($data->id, $expire_at, $start_date, $end_date);


            $hex_id = $alias = '';
            if (!empty($room['hex_id'])) {
                $hex_id = $room['hex_id'];
            }

            if (!empty($room['alias'])) {
                $alias = $room['alias'];
            }

            $params = [
                'user_id' => $data->user_id,
                'expert_id' => $data->user_expert_id,
                'time_start' => str_replace('AM', '', $data->time),
                'date' => $data->date,
                'status' => $data->status,
                'order_id' => $data->id,
                'duration' => str_replace('min', '', $data->duration_id),
                'hex_id' => $hex_id,
                'alias' => $alias,
            ];

            $room = RoomMeet::createRoom($params); // Assuming createRoom returns a RoomMeet instance


            // Gửi email thông báo
            $htmlContent = view('email.user_approved_booking', [
                'room' => $room,
                'data' => $data,
            ])->render();

            // Địa chỉ email người nhận
            $recipients = [$data->email_user_expert, $data->email_user];
            $mailResponses = [];

            // Gửi email cho từng người nhận
            foreach ($recipients as $recipient) {
                $mailResponses[] = $this->mailService->sendMail(
                    'KHÁCH HÀNG CHẤP NHẬN ĐẶT LỊCH',
                    $htmlContent,
                    '', // Đường dẫn tệp đính kèm (nếu có)
                    $recipient,
                    '',
                    [
                        'customerName' => '', // Có thể điền tên khách hàng nếu cần
                        'customerEmail' => '', // Có thể điền email khách hàng nếu cần
                    ]
                );
            }


            if ($data->key == 3) {


                // Địa chỉ email người nhận
                $recipients = explode(',', $data->list_email);
                $mailResponses = [];

                // Gửi email cho từng người nhận
                foreach ($recipients as $recipient) {
                    $data1 = CoreUsers::where('email', $recipient)->first();
                    if (!empty($data1)) {
                        $htmlContent = view('email.email_invited_call_group', [
                            'room' => $room,
                            'data' => $data1,
                            'request' => $data,
                        ])->render();
                        $mailResponses[] = $this->mailService->sendMail(
                            'KHÁCH HÀNG CHẤP NHẬN ĐẶT LỊCH',
                            $htmlContent,
                            '', // Đường dẫn tệp đính kèm (nếu có)
                            $recipient,
                            '',
                            [
                                'customerName' => '', // Có thể điền tên khách hàng nếu cần
                                'customerEmail' => '', // Có thể điền email khách hàng nếu cần
                            ]
                        );
                    }

                }
            }


            $allSuccessful = true;
            $errorMessages = '';
            foreach ($mailResponses as $mailResponse) {
                if ($mailResponse['status'] !== 200) {
                    $allSuccessful = false;
                    $errorMessages .= $mailResponse['body'] . ' ';
                }
            }


            DB::commit();
            if ($allSuccessful) {

                return redirect()->back()->with('successNotiUserApproveAfter', 'Vui lòng kiểm tra email để tham gia cuộc gọi đúng giờ với chuyên gia');
            } else {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra khi gửi email: ' . $errorMessages);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Log lỗi để dễ dàng debug hơn
            return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau !');
        }
    }


    public
    function userCancel(Request $request, $id)
    {
        $data = RequestExpert::findOrFail($id);
        $user = CoreUsers::findOrFail($data->user_id);

        // Ngày giờ hiện tại
        $currentTime = Carbon::now();
        $thoigianhientai = $currentTime->format('Y-m-d H:i:s'); // Lấy giờ, phút, giây
        $thoigiandatlich = $data->created_at;
        $requestTime = Carbon::parse($data->date)->format('Y-m-d') . ' ' . $data->time;
        $date = Carbon::createFromFormat('Y-m-d h:i A', $requestTime);
        $thoigianmetting = $date->format('Y-m-d H:i:s');

        // Chuyển đổi các thời gian sang đối tượng Carbon để tính toán
        $startTime = Carbon::parse($thoigiandatlich);
        $endTime = Carbon::parse($thoigianmetting);
        $currentTime = Carbon::parse($thoigianhientai);

        // Tính tổng thời gian từ lúc đặt lịch đến lúc meeting
        $totalDuration = $startTime->diffInSeconds($endTime);

        // Tính thời gian đã trôi qua từ lúc đặt lịch đến thời điểm hiện tại
        $elapsedTime = $startTime->diffInSeconds($currentTime);

        // Tính phần trăm thời gian đã trôi qua
        $percentage = ($elapsedTime / $totalDuration) * 100;

        DB::beginTransaction();
        try {
            $data->type_request_user = 3;
            $data->save();
            DB::commit();
            // So sánh ngày giờ
            if ($percentage >= 75) {
//                dd('Ngày giờ hiện tại lớn hơn ngày giờ thuê');
                Mail::to($data->email_user_expert)
                    ->send(new UserCancelBooking($data));
                return redirect()->back()->with('successNoti', 'Bạn sẽ không được hoàn vì đã quá 75% thời gian');
            } else {
                // call fun refund money
                $params = VnpayRefund::create([
                    'user_name' => Auth::guard('web')->user()->fullname,
                    'request_expert_id' => $id,
                    'vnp_Amount' => $data->price * 100,
                    'vnp_TransactionNo' => $data->vnp_TransactionNo,
                ]);
                $pay = Payment::Refund($params->toArray());

                // Gửi email thông báo
                $htmlContent = view('email.user_cancel_booking', [
                    'data' => $data,
                ])->render();

                // Địa chỉ email người nhận
                $recipients = [$data->email_user_expert];
                $mailResponses = [];

                // Gửi email cho từng người nhận
                foreach ($recipients as $recipient) {
                    $mailResponses[] = $this->mailService->sendMail(
                        'KHÁCH HÀNG TỪ CHỐI ĐẶT LỊCH',
                        $htmlContent,
                        '', // Đường dẫn tệp đính kèm (nếu có)
                        $recipient,
                        '',
                        [
                            'customerName' => '', // Có thể điền tên khách hàng nếu cần
                            'customerEmail' => '', // Có thể điền email khách hàng nếu cần
                        ]
                    );
                }


                $allSuccessful = true;
                $errorMessages = '';
                foreach ($mailResponses as $mailResponse) {
                    if ($mailResponse['status'] !== 200) {
                        $allSuccessful = false;
                        $errorMessages .= $mailResponse['body'] . ' ';
                    }
                }


//                    Mail::to($data->email_user_expert)
//                        ->send(new UserCancelBooking($data));
                if ($allSuccessful) {
                    return redirect()->back()->with('successNoti', 'Bạn đã hủy thành công. Chúng tôi sẽ hoàn tiền lại cho bạn trong thời gian sớm nhất');
                } else {
                    return redirect()->back()->with('danger', 'Có lỗi xảy ra khi gửi email: ' . $errorMessages);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Log lỗi để dễ dàng debug hơn
            return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau !');
        }
    }

    public
    function userApproveNegotiate(Request $request, $id)
    {
        $data = RequestExpert::findOrFail($id);
        $user = CoreUsers::findOrFail($data->user_id);

        DB::beginTransaction();
        try {

//                dd('Ngày giờ hiện tại bé hơn ngày giờ thuê');
            $data->type_request_user = 5;
            $data->save();
            $requestTime = Carbon::parse($data->date)->format('Y-m-d') . ' ' . $data->time;
            $date = Carbon::createFromFormat('Y-m-d h:i A', $requestTime);
            $thoigianmetting = $date->format('Y-m-d H:i:s');
            // Chuyển đổi các thời gian sang đối tượng Carbon để tính toán

            $duration = intval($data->duration_id);// 15
            $StartTime = Carbon::parse($thoigianmetting);
            $EndTime = Carbon::parse($thoigianmetting)->addMinutes($duration);

            $expire_at = $EndTime->timestamp * 1000;
            $end_date = $EndTime->timestamp * 1000;
            $start_date = $StartTime->timestamp * 1000;
            $quckcom = new Quikcom();
            $room = $quckcom->createRoom($data->id, $expire_at, $start_date, $end_date);

            $hex_id = $alias = '';
            if (!empty($room['hex_id'])) {
                $hex_id = $room['hex_id'];
            }

            if (!empty($room['alias'])) {
                $alias = $room['alias'];
            }
            // Gửi email thông báo
            $params = [
                'user_id' => $data->user_id,
                'expert_id' => $data->user_expert_id,
                'time_start' => str_replace('AM', '', $data->time),
                'date' => $data->date,
                'status' => $data->status,
                'order_id' => $data->id,
                'duration' => str_replace('min', '', $data->duration_id),
                'hex_id' => $hex_id,
                'alias' => $alias,
            ];


            $room = RoomMeet::createRoom($params);
            // Gửi email thông báo
            $htmlContent = view('email.user_approve_negotiate', [
                'data' => $data,
                'room' => $room,
            ])->render();
            // Địa chỉ email người nhận
            $recipients = [$data->email_user_expert];
            $mailResponses = [];
            // Gửi email cho từng người nhận
            foreach ($recipients as $recipient) {
                $mailResponses[] = $this->mailService->sendMail(
                    'KHÁCH HÀNG CHẤP NHẬN THỜI GIAN THƯƠNG LƯỢNG ĐẶT LỊCH',
                    $htmlContent,
                    '', // Đường dẫn tệp đính kèm (nếu có)
                    $recipient,
                    '',
                    [
                        'customerName' => '', // Có thể điền tên khách hàng nếu cần
                        'customerEmail' => '', // Có thể điền email khách hàng nếu cần
                    ]
                );
            }
            $allSuccessful = true;
            $errorMessages = '';
            foreach ($mailResponses as $mailResponse) {
                if ($mailResponse['status'] !== 200) {
                    $allSuccessful = false;
                    $errorMessages .= $mailResponse['body'] . ' ';
                }
            }
            $htmlContent = view('email.expert_approve_negotiate', [
                'data' => $data,
                'room' => $room,
            ])->render();
            // Địa chỉ email người nhận
            $recipients = [$data->email_user];
            $mailResponses = [];
            // Gửi email cho từng người nhận
            foreach ($recipients as $recipient) {
                $mailResponses[] = $this->mailService->sendMail(
                    'BẠN ĐÃ CHẤP NHẬN THỜI GIAN THƯƠNG LƯỢNG ĐẶT LỊCH',
                    $htmlContent,
                    '', // Đường dẫn tệp đính kèm (nếu có)
                    $recipient,
                    '',
                    [
                        'customerName' => '', // Có thể điền tên khách hàng nếu cần
                        'customerEmail' => '', // Có thể điền email khách hàng nếu cần
                    ]
                );
            }
            $allSuccessful = true;
            $errorMessages = '';
            foreach ($mailResponses as $mailResponse) {
                if ($mailResponse['status'] !== 200) {
                    $allSuccessful = false;
                    $errorMessages .= $mailResponse['body'] . ' ';
                }
            }


            DB::commit();
            if ($allSuccessful) {
                return redirect()->back()->with('successNotiUserApproveAfter', 'Vui lòng kiểm tra email để tham gia cuộc gọi đúng giờ với chuyên gia');
            } else {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra khi gửi email: ' . $errorMessages);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Log lỗi để dễ dàng debug hơn
            return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau !');
        }
    }

    public
    function UserCancelNegotiate(Request $request, $id)
    {

        $data = RequestExpert::findOrFail($id);
        $user = CoreUsers::findOrFail($data->user_id);

        // Ngày giờ hiện tại
        $currentTime = Carbon::now();
        $thoigianhientai = $currentTime->format('Y-m-d H:i:s'); // Lấy giờ, phút, giây
        $thoigiandatlich = $data->created_at;
        $requestTime = Carbon::parse($data->date)->format('Y-m-d') . ' ' . $data->time;
        $date = Carbon::createFromFormat('Y-m-d h:i A', $requestTime);
        $thoigianmetting = $date->format('Y-m-d H:i:s');

        // Chuyển đổi các thời gian sang đối tượng Carbon để tính toán
        $startTime = Carbon::parse($thoigiandatlich);
        $endTime = Carbon::parse($thoigianmetting);
        $currentTime = Carbon::parse($thoigianhientai);

        // Tính tổng thời gian từ lúc đặt lịch đến lúc meeting
        $totalDuration = $startTime->diffInSeconds($endTime);

        // Tính thời gian đã trôi qua từ lúc đặt lịch đến thời điểm hiện tại
        $elapsedTime = $startTime->diffInSeconds($currentTime);

        // Tính phần trăm thời gian đã trôi qua
        $percentage = ($elapsedTime / $totalDuration) * 100;

        DB::beginTransaction();
        try {
            // So sánh ngày giờ
            if ($percentage >= 75) {
//                dd('Ngày giờ hiện tại lớn hơn ngày giờ thuê');
                $data->type_request_user = 3;
                $data->save();

                DB::commit();
                return redirect()->back()->with('successNoti', 'Bạn sẽ không được hoàn lại tiền vì đã qua 75% thời gian');
            } else {
                // call fun refund money
                $params = VnpayRefund::create([
                    'user_name' => Auth::guard('web')->user()->fullname,
                    'request_expert_id' => $id,
                    'vnp_Amount' => $data->price * 100,
                    'vnp_TransactionNo' => $data->vnp_TransactionNo,
                ]);


                $data->type_request_user = 6;
                $data->save();

                DB::commit();

                Payment::Refund($params->toArray());
//                    Mail::to($data->email_user_expert)
//                        ->send(new UserCancelBooking($data));
                $htmlContent = view('email.user_cancel_booking', [
                    'data' => $data,
//                        'room' => $room,
                ])->render();
                // Địa chỉ email người nhận
                $recipients = [$data->email_user_expert];
                $mailResponses = [];
                // Gửi email cho từng người nhận
                foreach ($recipients as $recipient) {
                    $mailResponses[] = $this->mailService->sendMail(
                        'KHÁCH HÀNG TỪ CHỐI THƯƠNG LƯỢNG THỜI GIAN ĐẶT LỊCH',
                        $htmlContent,
                        '', // Đường dẫn tệp đính kèm (nếu có)
                        $recipient,
                        '',
                        [
                            'customerName' => '', // Có thể điền tên khách hàng nếu cần
                            'customerEmail' => '', // Có thể điền email khách hàng nếu cần
                        ]
                    );
                }
                $allSuccessful = true;
                $errorMessages = '';
                foreach ($mailResponses as $mailResponse) {
                    if ($mailResponse['status'] !== 200) {
                        $allSuccessful = false;
                        $errorMessages .= $mailResponse['body'] . ' ';
                    }
                }


                if ($allSuccessful) {
                    return redirect()->back()->with('successNoti', 'Bạn đã hủy thành công. Chúng tôi sẽ hoàn tiền lại cho bạn trong thời gian sớm nhất');
                } else {
                    return redirect()->back()->with('danger', 'Có lỗi xảy ra khi gửi email: ' . $errorMessages);
                }

            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Log lỗi để dễ dàng debug hơn
            return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau !');
        }
    }

    public function conference(Request $request)
    {
        $data = RoomMeet::where('expert_id', Auth::guard('web')->user()->id)->get();


        $alias = $request->input('alias');
        if (!empty($alias)) {
            $user = Auth::guard('web')->user();
            $token = $user->token_api; // token cua chuyen gia


            $expires_in = auth('api')->factory()->getTTL() * 60;


            //access_token=#{access_token}&token_type=Bearer&expires_in=#{expires_in}&start_with=host&quality=conference
            $token_type = 'access_token=' . $token . '&token_type=Bearer&expires_in=' . $expires_in . '&start_with=host&quality=conference';

            $this->data['token'] = $token_type;
            $this->data['alias'] = $alias;
            $this->data['data'] = RoomMeet::where('alias', $alias)->first();


            return view('frontend.info.chat', $this->data);

        }
        $this->data['data'] = $data;

        return view('frontend.user.conference', $this->data);
    }
}
