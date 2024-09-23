<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\CoreUsers;
use App\Models\PostExpert;
use App\Models\WalletExpert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletController extends BaseBackendController
{
    //
    public function index()
    {
        $data = WalletExpert::with('user')->get();

        $this->_data['data'] = $data;

        return view('backend.wallet.index', $this->_data);
    }

    public function approve(Request $request, $id)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $wallet = WalletExpert::where('id', $id)->first();
                $user = CoreUsers::findOrFail($wallet->user_expert_id);
                // Trừ số tiền price trong WalletExpert từ point của CoreUsers
                $user->point -= $wallet->price;
                // Đảm bảo rằng điểm không âm
//                if ($user->point < 0) {
//                    return redirect()->back()->with('error', 'Số dư không đủ để thực hiện giao dịch');
//                }

                //
                $wallet->status = 2;
                $wallet->save();
                $user->save();

                return redirect()->route('backend.walletExpert.index')->with('success', 'Duyệt thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    }
}


