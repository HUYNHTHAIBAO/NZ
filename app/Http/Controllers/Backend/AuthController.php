<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\CoreUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseBackendController
{
//    public function login(Request $request)
//    {
//        Auth::shouldUse('backend');
//        if (Auth()->guard('backend')->user()) {
//            return redirect(Route('backend.dashboard'));
//        }
//
//        $data = array(
//            'title' => 'Login'
//        );
//
//        if ($request->getMethod() == 'POST') {
//
//            if (!Auth()->guard('backend')->attempt(['phone' => $request->phone, 'password' => $request->password], true)) {
//                $request->session()->flash('msg', 'Đăng nhập thất bại');
//            } else {
//                return redirect(Route('backend.dashboard'));
//            }
//
//        }
//        return view('backend.login', $data);
//    }
//
    public function login(Request $request)
    {
        Auth::shouldUse('backend');
        if (Auth()->guard('backend')->user()) {
            return redirect(Route('backend.dashboard'));
        }

        $data = array(
            'title' => 'Login'
        );

        if ($request->getMethod() == 'POST') {
            $cre = $request->email_or_phone;
            $user = CoreUsers::where('phone', $cre)
                ->orWhere('email', $cre)
                ->first();

            if (empty($user) || !Hash::check($request->password, $user->password)) {
                $request->session()->flash('msg', 'Thông tin đăng nhập không chính xác');
                return redirect(Route('backend.login'));
            }
            if (empty($user->account_position) || $user->account_position == 0) {
                $request->session()->flash('msg', 'Không có quyền truy cập vào trang này!');
                return redirect(Route('backend.login'));
            }
            if ($user->company_id != config('constants.company_id')) {
                $request->session()->flash('msg', 'Đăng nhập thất bại!');
                return redirect(Route('backend.login'));
            }
            Auth()->guard('backend')->login($user);
            return redirect(Route('backend.dashboard'));

        }
        return view('backend.login', $data);
    }

    public function logout()
    {
        Auth::shouldUse('backend');
        if (Auth()->guard('backend')->user()->id) {
            Auth()->guard('backend')->logout();
        }
//        session_start();
//        session_destroy();
        return redirect(Route('backend.login'));
    }
}
