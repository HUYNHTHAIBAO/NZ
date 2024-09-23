<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\CoreUsers;
use App\Models\RequestExpert;
use App\Utils\Avatar;
use App\Utils\Common as Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UsersController extends BaseBackendController
{
    protected $_data = array(
        'title'    => 'Quản lý tài khoản',
        'subtitle' => 'Quản lý tài khoản',
    );

    public function profile(Request $request)
    {
        $validator_rule = [
            'fullname'    => 'required|string',
            'email'       => [
                'bail',
                'nullable',
                'email',
                Rule::unique('lck_core_users')->ignore(Auth()->guard('backend')->user()->id),
            ],
            'file_avatar' => 'nullable|image',
        ];

        $form_init = array_merge(
            array(
                'fullname'    => null,
                'email'       => null,
                'oldpassword' => null,
                'newpassword' => null,
            ), Utils::J_filterEntities($request->all())
        );

        if ($request->getMethod() == 'POST') {

            Validator::make($request->all(), $validator_rule)->validate();

            try {
                $user = CoreUsers::find(Auth()->guard('backend')->user()->id);

                $aUpdate = array(
                    'fullname' => $form_init['fullname'],
                    'email'    => $form_init['email'],
                );

                if (!empty($form_init['newpassword'])) {
                    if (empty($form_init['oldpassword'])) {
                        return redirect()->back()
                            ->withInput($request->all())
                            ->withErrors(['message' => "Vui lòng nhập mật khẩu cũ!"]);
                    } elseif (!Hash::check($form_init['oldpassword'], Auth()->guard('backend')->user()->password)) {
                        return redirect()->back()
                            ->withInput($request->all())
                            ->withErrors(['message' => "Mật khẩu cũ không chính xác!"]);
                    } else {
                        $aUpdate['password'] = bcrypt($form_init['newpassword']);
                    }
                }

                if ($request->hasFile('file_avatar') && $request->file('file_avatar')->isValid()) {

                    $sub_dir = date('Y/m/d');

                    $filename = md5(time()) . '.' . $request->file_avatar->extension();
                    $full_dir = config('constants.upload_dir.root');

                    if (!is_dir($full_dir . '/' . $sub_dir)) {
                        mkdir($full_dir . '/' . $sub_dir, 0777, true);
                    }

                    Image::make(Input::file('file_avatar'))->fit(300)
                        ->save($full_dir . '/' . $sub_dir . '/' . $filename);

                    $aUpdate['avatar'] = config('constants.upload_dir.url') . '/' . $sub_dir . '/' . $filename;

                    Avatar::delete($user->avatar, $full_dir);
                }

                $user->update($aUpdate);

                $request->session()->flash('msg', ['info', 'Cập nhật thành công!']);
            } catch (\Exception $e) {
                $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
            }
            return redirect(Route('backend.users.profile'));
        }
        $this->_data['title'] = 'Thông tin tài khoản';
        return view('backend.users.profile', $this->_data);
    }

    public function index(Request $request)
    {
        $filter = $params = array_merge(array(
            'fullname' => null,
            'phone'    => null,
            'email'    => null,
            'status'   => null,
        ), Utils::J_filterEntities($request->all()));

        $objU = new CoreUsers();

        $params['pagin_path'] = Utils::get_pagin_path($filter);
        $params['is_staff'] = false;
        $params['account_type'] = [0, 1];

        $users = $objU->get_by_where($params);

        $start = ($users->currentPage() - 1) * config('constants.item_perpage');

        $this->_data['users'] = $users;
        $this->_data['start'] = $start;
        $this->_data['filter'] = $filter;

        return view('backend.users.index', $this->_data);
    }

    public function add(Request $request)
    {
        $validator_rule = [
            'fullname' => ['nullable', 'string'],
            'email'    => ['required', 'email', Rule::unique('lck_core_users'),],
            'phone'    => ['required',  Rule::unique('lck_core_users'),],
            'password' => ['required', 'string'],
            'status'   => ['required', 'string'],
        ];
//        if (!isset($form_init['discount_code']) || is_null($form_init['discount_code'])) {
//            $form_init['discount_code'] = 'Tai';
//        }

        function generateRandomLetters($length = 4)
        {
            $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $random_letters = substr(str_shuffle($letters), 0, $length);
            return $random_letters;
        }
        // Sử dụng hàm để tạo 4 ký tự chữ cái ngẫu nhiên
        $random = generateRandomLetters(4);
        $phone = $request->input('phone');
        $last_4_digits = substr($phone, -4);
        // Tạo giá trị cho trường discount_code
        $discount_code = $random . $last_4_digits;
        $form_init = array_merge(
            array(
                'fullname' => null,
                'email'    => null,
                'phone'    => null,
                'password' => null,
                'avatar'   => null,
                'status'   => null,
                'discount_code'   => $discount_code,
            ), Utils::J_filterEntities($request->all())
        );

        $form_init = array_merge($form_init, $request->old());

        $this->_data['form_init'] = (object)$form_init;

        if ($request->getMethod() == 'POST') {

            Validator::make($request->all(), $validator_rule)->validate();

            try {
                $form_init['company_id'] = config('constants.company_id');

                $form_init['password'] = Hash::make($form_init['password']);

                $full_dir = config('constants.upload_dir.root') . '/backend';

                $form_init['avatar'] = Avatar::generate($form_init['fullname'], $full_dir);

                CoreUsers::create($form_init);

                $request->session()->flash('msg', ['info', 'Thêm tài khoản thành công!']);
            } catch (\Exception $e) {
                $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!' . $e->getMessage()]);
            }
            return redirect(Route('backend.users.index'));
        }

        $this->_data['subtitle'] = 'Thêm mới';

        return view('backend.users.form', $this->_data);
    }

    public function edit(Request $request, $id)
    {
        $user = CoreUsers::find($id);

        if (empty($user)) {
            $request->session()->flash('msg', ['danger', 'Tài khoản không tồn tại!']);
            return redirect($this->_ref ? $this->_ref : Route('backend.users.index'));
        }

        if (Auth()->guard('backend')->user()->id == $id) {
            $request->session()->flash('msg', ['danger', 'Không thể cập nhật tài khoản này!']);
            return redirect($this->_ref ? $this->_ref : Route('backend.users.index'));
        }

        $validator_rule = [
            'fullname' => ['nullable', 'string'],
            'email'    => ['required', 'email', Rule::unique('lck_core_users')->ignore($user->id),],
            'status'   => ['required', 'string'],

        ];
        function generateRandomLetters($length = 4)
        {
            $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $random_letters = substr(str_shuffle($letters), 0, $length);
            return $random_letters;
        }
        // Sử dụng hàm để tạo 4 ký tự chữ cái ngẫu nhiên
        $random = generateRandomLetters(4);
        $phone = $request->input('phone');
        $last_4_digits = substr($phone, -4);
        // Tạo giá trị cho trường discount_code
        $discount_code = $random . $last_4_digits;
        $form_init = array_merge(
            array(
                'fullname'     => null,
                'email'        => null,
                'phone'        => null,
                'password'     => null,
                'agency_level' => null,
                'status'       => null,
                'discount_code'       => $discount_code,
            ), Utils::J_filterEntities($request->all())
        );

        if ($request->getMethod() == 'POST') {

            Validator::make($request->all(), $validator_rule)->validate();

            try {
                unset($form_init['avatar']);
                if (empty($form_init['password'])) {
                    unset($form_init['password']);
                } else {
                    $form_init['password'] = Hash::make($form_init['password']);
                }
                $user->update($form_init);

                $request->session()->flash('msg', ['info', 'Cập nhật tài khoản thành công!']);
            } catch (\Exception $e) {
                $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!' . $e->getMessage()]);
            }
            return redirect(Route('backend.users.index'));
        }

        $form_init = array_merge($form_init, $user->toArray());

        $this->_data['form_init'] = (object)$form_init;

        $this->_data['subtitle'] = 'Cập nhật';
        return view('backend.users.form', $this->_data);
    }

    public function delete(Request $request, $id)
    {
        try {
            $user = CoreUsers::find($id);

            if (empty($user)) {
                $request->session()->flash('msg', ['danger', 'Tài khoản không tồn tại!']);
            } else {
                if (Auth()->guard('backend')->user()->id == $id) {
                    $request->session()->flash('msg', ['danger', 'Không thể xóa tài khoản này!']);
                } else {
                    $full_dir = config('constants.upload_dir.root') . '/backend';
                    Avatar::delete($user->avatar, $full_dir);
                    $user->delete();
                    $request->session()->flash('msg', ['info', 'Đã xóa thành công!']);
                }
            }
        } catch (\Exception $e) {
            $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
        }
        return redirect($this->_ref ? $this->_ref : Route('backend.users.index'));
    }
    public function settingsExpert(Request $request, $id)
    {
        $user = CoreUsers::find($id);
        if (!$user) {
            return redirect()->back()->with('warning', 'Người dùng không tồn tại');
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'show' => 'required',
            ], [
                'show.required' => 'Chọn loại không được để trống',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                $user->show = $request->get('show');
                $user->priority = $request->get('priority');
                $user->update();

                return redirect()->route('backend.expert.index')->with('success', 'Cài đặt chuyên gia thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }


        $this->_data['user'] = $user;
        $this->_data['subtitle'] = 'Cài đặt chuyên gia';
        return view('backend.users.settingsExpert', $this->_data);
    }
    public function chart(Request $request, $id) {

        $user = CoreUsers::find($id);

        $total = RequestExpert::where('user_expert_id', $user->id)->count();
        $accept = RequestExpert::where('user_expert_id', $user->id)->where('type', 2)->count();
        $nonAccept = RequestExpert::where('user_expert_id', $user->id)->where('type', 3)->count();
        $deal = RequestExpert::where('user_expert_id', $user->id)->where('type', 5)->count();




        $this->_data['total'] = $total;
        $this->_data['accept'] = $accept;
        $this->_data['nonAccept'] = $nonAccept;
        $this->_data['deal'] = $deal;
        return view('backend.expert.chart', $this->_data);
    }


}
