<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;
use App\Models\CoreUsers;
use App\Models\Files;
use App\Models\YoutubeExpert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class YoutubeExpertController extends BaseFrontendController
{
    //
    public function index()
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        $data = YoutubeExpert::where('user_expert_id', $user->id)->orderBy('id', 'desc')->paginate(5);


        $this->_data['data'] = $data;
        return view('frontend.youtubeExpert.index', $this->_data);
    }

    public function add(Request $request)
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
//                'title' => 'required',
                'link' => 'required',
//                'image_file_id' => 'required',
            ], [
//                'title.required' => 'Tiêu đề không được để trống',
                'link.required' => 'Link không được để trống',
//                'image_file_id.required' => 'Hình ảnh không được để trống',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {

                $youtubeExpert = new YoutubeExpert();
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

                    $youtubeExpert->image_file_id = $fileRecord->id;
                    $youtubeExpert->image_file_path = $fileRecord->file_path;

                }

                $youtubeExpert->title = $request->get('title');
                $youtubeExpert->link = $request->get('link');
                $youtubeExpert->user_expert_id = $user->id;
                $youtubeExpert->status = 1;

                $youtubeExpert->save();

                return redirect()->route('frontend.youtubeExpert.index')->with('info', 'Đăng thành công, vui lòng chờ duyệt từ admin');
            } catch (\Exception $e) {
                return redirect()->back()->with('warni ng', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
        return view('frontend.youtubeExpert.add', $this->_data);
    }

    public function edit(Request $request, $id)
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        $youtubeExpert = YoutubeExpert::where('user_expert_id', $user->id)->where('id', $id)->first();
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
//                'title' => 'required',
                'link' => 'required',
            ], [
//                'title.required' => 'Tiêu đề không được để trống',
                'link.required' => 'Link không được để trống',
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
                    // Xóa file cũ nếu tồn tại
//                    if ($youtubeExpert->image_file_path) {
//                        Storage::delete('public/' . $youtubeExpert->image_file_path);
//                    }
                    $fileRecord = new Files();
                    $fileRecord->file_path = $file_path;
                    $fileRecord->user_id = $user->id;
                    $fileRecord->save();
                    $youtubeExpert->image_file_id = $fileRecord->id;
                    $youtubeExpert->image_file_path = $fileRecord->file_path;
                }
                $youtubeExpert->title = $request->get('title');
                $youtubeExpert->link = $request->get('link');
                $youtubeExpert->user_expert_id = $user->id;
                $youtubeExpert->status = 1;
                $youtubeExpert->save();
                return redirect()->route('frontend.youtubeExpert.index')->with('info', 'Cập nhật thành công, vui lòng chờ duyệt từ admin');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
        $this->_data['youtubeExpert'] = $youtubeExpert;
        return view('frontend.youtubeExpert.edit', $this->_data);
    }


    public function delete(Request $request, $id)
    {
        try {
            $youtubeExpert = YoutubeExpert::find($id);

            $youtubeExpert->delete();
            return redirect()->route('frontend.youtubeExpert.index')->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }

}
