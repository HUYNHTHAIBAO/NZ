<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;
use App\Models\CoreUsers;
use App\Models\ExpertCategory;
use App\Models\Files;
use App\Models\PostExpert;
use App\Models\RequestExpert;
use App\Models\WalletExpert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WalletExpertController extends BaseFrontendController
{
    //
    public function index(Request $request)
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        $requestExpert = RequestExpert::where('user_expert_id', $user->id)->first();

        if ($request->getMethod() == 'POST') {
            $validator = Validator::make($request->all(), [
                'bank_stk' => 'required',
                'bank_name' => 'required',
                'name' => 'required',
                'price' => 'required|numeric|min:1', // Đảm bảo rằng giá trị price là số và lớn hơn 0
            ], [
                'bank_stk.required' => 'Số tài khoản không được để trống',
                'bank_name.required' => 'Tên ngân hàng không được để trống',
                'name.required' => 'Tên tài khoản không được để trống',
                'price.required' => 'Số tiền cần rút không được để trống',
                'price.numeric' => 'Số tiền cần rút phải là một số',
                'price.min' => 'Số tiền cần rút phải lớn hơn 0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Kiểm tra số tiền không được lớn hơn trường price trong bảng RequestExpert
            $requestedPrice = $request->input('price');
            if ($requestedPrice > $user->point) {
                return redirect()->back()
                    ->withErrors(['price' => 'Số tiền cần rút không được lớn hơn số dư hiện tại'])
                    ->withInput();
            }

            try {
                $data = new WalletExpert();
                $data->user_expert_id = $user->id;
                $data->bank_stk = $request->input('bank_stk');
                $data->bank_name = $request->input('bank_name');
                $data->name = $request->input('name');
                $data->price = $requestedPrice;
                $data->note = $request->input('note');
                $data->status = 1;
                $data->save();

                return redirect()->route('frontend.wallet.index')->with('info', 'Gửi yêu cầu thành công, vui lòng chờ duyệt');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }

        $this->_data['user'] = $user;
        $this->_data['requestExpert'] = $requestExpert;
        return view('frontend.wallet.index', $this->_data);
    }
    public function history() {

        $data = WalletExpert::paginate(10);

        $this->_data['data'] = $data;

        return view('frontend.wallet.history', $this->_data);
    }
}
