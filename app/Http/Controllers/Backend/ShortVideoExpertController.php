<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\ShortVideoExpert;
use App\Models\YoutubeExpert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShortVideoExpertController extends BaseBackendController
{
    //
    public function index()
    {
        $data = ShortVideoExpert::where('status', 1)->orderBy('id', 'desc')->get();
        $this->_data['data'] = $data;
        return view('backend.shortVideoExpert.index', $this->_data);
    }
    public function approved(Request $request, $id)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $shortVideoExpert = ShortVideoExpert::where('id', $id)->first();
                $shortVideoExpert->status = 2;
                $shortVideoExpert->save(); // Lưu lại thay đổi
                return redirect()->route('backend.shortVideoExpert.index')->with('success', 'Duyệt thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    }
    public function reject(Request $request, $id) {
        if ($request->getMethod() == 'POST') {
            try {
                $shortVideoExpert = ShortVideoExpert::where('id', $id)->first();
                $shortVideoExpert->status = 3;
                $shortVideoExpert->save(); // Lưu lại thay đổi
                return redirect()->route('backend.shortVideoExpert.index')->with('success', 'Từ chối thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    }
}
