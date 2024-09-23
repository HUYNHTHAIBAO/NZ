<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;
use App\Models\CoreUsers;
use App\Models\ExpertCategory;
use App\Models\ExpertProfileOrther;
use App\Models\ExpertProfiles;
use App\Models\Files;
use App\Models\PostExpert;
use App\Utils\Common as Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ExpertProfileOrtherController extends BaseFrontendController
{
    protected $_data = [];


    public function index(Request $request)
    {

        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        $data = ExpertProfileOrther::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(5);

        $this->_data['data'] = $data;



        return view('frontend.profileOther.index', $this->_data);
    }

    public function create(Request $request)
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);

        if ($request->getMethod() == 'POST') {
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'image_file_id' => 'required|file|max:1024 ',
            ], [
                'title.required' => 'Tên bài viết không được để trống',
                'title.max' => 'Tiêu đề không đượt vượt quá 255 ký tự',
                'image_file_id.required' => 'File không được để trống',
                'image_file_id.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
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
                }
                //
                $data = new ExpertProfileOrther();
                $data->title = $request->get('title');
                $data->user_id = $user->id;
                $data->status = 0;
                $data->slug = str_slug($request->get('title'));
                if (isset($fileRecord)) {
                    $data->image_file_id = $fileRecord->id;
                }
                $data->save();
                return redirect()->route('frontend.profileOrther.index')->with('info', 'Thêm thành công, vui lòng chờ duyệt');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
        return view('frontend.profileOther.create', $this->_data);
    }

    public function edit(Request $request, $id)
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        $data = ExpertProfileOrther::where('user_id', $user->id)->where('id', $id)->first();

        if ($request->getMethod() == 'POST') {
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
            ], [
                'title.required' => 'Tên bài viết không được để trống',
                'title.max' => 'Tiêu đề không đượt vượt quá 255 ký tự',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
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
                }
                // Tạo bài viết mới
                $data->title = $request->get('title');
                $data->user_id = $user->id;
                $data->status = 0;
                $data->slug = str_slug($request->get('title'));
                if (isset($fileRecord)) {
                    $data->image_file_id = $fileRecord->id;
                }
                $data->save();
                return redirect()->route('frontend.profileOrther.index')->with('info', 'Cập nhật thành công, vui lòng chờ duyệt');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
        $this->_data['data'] = $data;
        return view('frontend.profileOther.edit', $this->_data);
    }

    public function delete(Request $request, $id)
    {
        try {
            $data = ExpertProfileOrther::find($id);
            $data->delete();

            return redirect()->route('frontend.profileOrther.index')->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }

    }

}

