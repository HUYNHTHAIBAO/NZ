<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;
use App\Models\CoreUsers;
use App\Models\QuestionExpert;
use App\Models\ShortVideoExpert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class QuestionExpertController extends BaseFrontendController
{
    //
    public function index()
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        $data = QuestionExpert::where('user_expert_id', $user->id)->orderBy('id', 'desc')->paginate(5);


        $this->_data['data'] = $data;
        return view('frontend.questionExpert.index', $this->_data);
    }

    public function add(Request $request)
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'desc' => 'required',
            ], [
                'title.required' => 'Tiêu đề không được để trống',
                'desc.required' => 'Mô tả không được để trống',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
                $questionExpert = new QuestionExpert();
                $questionExpert->title = $request->get('title');
                $questionExpert->desc = $request->get('desc');
                $questionExpert->user_expert_id = $user->id;
                $questionExpert->status = 1;
                $questionExpert->save();
                return redirect()->route('frontend.questionExpert.index')->with('info', 'Đăng thành công, vui lòng chờ duyệt từ admin');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
        return view('frontend.questionExpert.add', $this->_data);
    }

    public function edit(Request $request, $id)
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        $questionExpert = QuestionExpert::where('user_expert_id', $user->id)->where('id', $id)->first();
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'desc' => 'required',
            ], [
                'title.required' => 'Tiêu đề không được để trống',
                'desc.required' => 'Mô tả không được để trống',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
                $questionExpert->title = $request->get('title');
                $questionExpert->desc = $request->get('desc');
                $questionExpert->user_expert_id = $user->id;
                $questionExpert->status = 1;
                $questionExpert->save();
                return redirect()->route('frontend.questionExpert.index')->with('info', 'Cập nhật thành công, vui lòng chờ duyệt từ admin');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
        $this->_data['questionExpert'] = $questionExpert;
        return view('frontend.questionExpert.edit', $this->_data);
    }


    public function delete(Request $request, $id)
    {
        try {
            $questionExpert = QuestionExpert::find($id);

            $questionExpert->delete();
            return redirect()->route('frontend.questionExpert.index')->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }
}
