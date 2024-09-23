<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;
use App\Models\CoreUsers;
use App\Models\Files;
use App\Models\ShortVideoExpert;
use App\Models\YoutubeExpert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ShortVideoExpertController extends BaseFrontendController
{
    //
    public function index()
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        $data = ShortVideoExpert::where('user_expert_id', $user->id)->orderBy('id', 'desc')->paginate(5);


        $this->_data['data'] = $data;
        return view('frontend.shortVideoExpert.index', $this->_data);
    }

    public function add(Request $request)
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'type' => 'required',
                'link' => 'required',
            ], [
                'type.required' => 'Loại không được để trống',
                'link.required' => 'Loại không được để trống',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
                $shortVideo = new ShortVideoExpert();

                $file_path = null;

                if ($request->hasFile('image_file_id')) {
                    $file = $request->file('image_file_id');
                    $filename = uniqid();
                    $sub_dir = date('Y/m/d');
                    $ext = $file->extension();
                    $origin_file_name = $filename . '.' . $ext;
                    $file_path = $sub_dir . '/' . $origin_file_name;
                    $file->storeAs('public/uploads/' . $sub_dir, $origin_file_name);
                    $fileRecord = new Files();
                    $fileRecord->file_path = $file_path;
                    $fileRecord->user_id = $user->id;
                    $fileRecord->save();
                    $shortVideo->image_file_id = $fileRecord->id;
                    $shortVideo->image_file_path = $fileRecord->file_path;
                }

                $shortVideo->title = $request->get('title');
                $shortVideo->link = $request->get('link');
                $shortVideo->type = $request->get('type');
                $shortVideo->user_expert_id = $user->id;
                $shortVideo->status = 1;
                $shortVideo->save();
                return redirect()->route('frontend.shortVideoExpert.index')->with('info', 'Đăng thành công, vui lòng chờ duyệt từ admin');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
        return view('frontend.shortVideoExpert.add', $this->_data);
    }

    public function edit(Request $request, $id)
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        $shortVideo = ShortVideoExpert::where('user_expert_id', $user->id)->where('id', $id)->first();
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'type' => 'required',
                'link' => 'required',
                'title' => 'required',
            ], [
                'type.required' => 'Loại không được để trống',
                'link.required' => 'Loại không được để trống',
                'title.required' => 'Tiêu đề không được để trống',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {

                if ($request->hasFile('image_file_id')) {
                    $file = $request->file('image_file_id');
                    $filename = uniqid();
                    $sub_dir = date('Y/m/d');
                    $ext = $file->extension();
                    $origin_file_name = $filename . '.' . $ext;
                    $file_path = $sub_dir . '/' . $origin_file_name;
                    $file->storeAs('public/uploads/' . $sub_dir, $origin_file_name);
                    $fileRecord = new Files();
                    $fileRecord->file_path = $file_path;
                    $fileRecord->user_id = $user->id;
                    $fileRecord->save();
                    $shortVideo->image_file_id = $fileRecord->id;
                    $shortVideo->image_file_path = $fileRecord->file_path;
                }

                $shortVideo->title = $request->get('title');
                $shortVideo->link = $request->get('link');
                $shortVideo->type = $request->get('type');
                $shortVideo->user_expert_id = $user->id;
                $shortVideo->status = 1;
                $shortVideo->save();
                return redirect()->route('frontend.shortVideoExpert.index')->with('info', 'Cập nhật thành công, vui lòng chờ duyệt từ admin');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
        $this->_data['shortVideo'] = $shortVideo;
        return view('frontend.shortVideoExpert.edit', $this->_data);
    }

    public function delete(Request $request, $id)
    {
        try {
            $shortVideo = ShortVideoExpert::find($id);

            $shortVideo->delete();
            return redirect()->route('frontend.shortVideoExpert.index')->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }
}
