<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\ExpertProfileOrther;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpertProfileOrtherController extends BaseBackendController
{
    //
    public function index()
    {
        $data = ExpertProfileOrther::where('status', 0)->orderBy('id', 'desc')->paginate(10);
        $this->_data['data'] = $data;
        return view('backend.expertProfileOrther.index', $this->_data);
    }
    public function approved(Request $request, $id)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $postExpert = ExpertProfileOrther::where('id', $id)->first();
                $postExpert->status = 1;
                $postExpert->save(); // Lưu lại thay đổi
                return redirect()->route('backend.ExpertProfileOrther.index')->with('success', 'Duyệt thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    }
    public function reject(Request $request, $id) {
        if ($request->getMethod() == 'POST') {
            try {
                $postExpert = ExpertProfileOrther::where('id', $id)->first();
                $postExpert->status = 2;
                $postExpert->save(); // Lưu lại thay đổi
                return redirect()->route('backend.ExpertProfileOrther.index')->with('success', 'Từ chối thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    }
}
