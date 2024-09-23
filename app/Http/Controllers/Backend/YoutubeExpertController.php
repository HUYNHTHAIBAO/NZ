<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\YoutubeExpert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class YoutubeExpertController extends BaseBackendController
{
    //
    public function index()
    {
        $data = YoutubeExpert::where('status', 1)->orderBy('id', 'desc')->paginate(10);
        $this->_data['data'] = $data;
        return view('backend.youtubeExpert.index', $this->_data);
    }
    public function approved(Request $request, $id)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $postExpert = YoutubeExpert::where('id', $id)->first();
                $postExpert->status = 2;
                $postExpert->save(); // Lưu lại thay đổi
                return redirect()->route('backend.youtubeExpert.index')->with('success', 'Duyệt thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    }
    public function reject(Request $request, $id) {
        if ($request->getMethod() == 'POST') {
            try {
                $postExpert = YoutubeExpert::where('id', $id)->first();
                $postExpert->status = 3;
                $postExpert->save(); // Lưu lại thay đổi
                return redirect()->route('backend.youtubeExpert.index')->with('success', 'Từ chối thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    }
}
