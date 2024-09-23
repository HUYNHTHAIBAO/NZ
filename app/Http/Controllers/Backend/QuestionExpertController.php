<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\QuestionExpert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionExpertController extends BaseBackendController
{
    //
    public function index()
    {
        $data = QuestionExpert::where('status', 1)->orderBy('id', 'desc')->get();
        $this->_data['data'] = $data;
        return view('backend.questionExpert.index', $this->_data);
    }
    public function approved(Request $request, $id)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $questionExpert = QuestionExpert::where('id', $id)->first();
                $questionExpert->status = 2;
                $questionExpert->save(); // Lưu lại thay đổi
                return redirect()->route('backend.questionExpert.index')->with('success', 'Duyệt thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    }
    public function reject(Request $request, $id) {
        if ($request->getMethod() == 'POST') {
            try {
                $questionExpert = QuestionExpert::where('id', $id)->first();
                $questionExpert->status = 3;
                $questionExpert->save(); // Lưu lại thay đổi
                return redirect()->route('backend.questionExpert.index')->with('success', 'Từ chối thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    }
}
