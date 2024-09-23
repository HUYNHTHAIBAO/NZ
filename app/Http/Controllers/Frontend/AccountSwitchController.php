<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function redirect;

class AccountSwitchController extends BaseFrontendController
{
    //
    public function switchToStudent(Request $request)
    {
        $user = Auth::guard('web')->user();

        if ($user->account_type == 2) {
            $user->account_type = 0;
            $user->save();

            return redirect()->back()->with('success', 'Chuyển đổi sang học viên thành công.');
        }

        return redirect()->back()->with('error', 'Chuyển đổi không thành công.');
    }
    public function switchToExpert(Request $request)
    {
        $user = Auth::guard('web')->user();

        if ($user->account_type == 0) {
            $user->account_type = 2;
            $user->save();

            return redirect()->back()->with('success', 'Chuyển đổi sang chuyên gia thành công.');
        }

        return redirect()->back()->with('error', 'Chuyển đổi không thành công.');
    }
}
