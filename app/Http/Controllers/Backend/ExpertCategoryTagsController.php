<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\ExpertCategoryTags;
use App\Models\RatingExpert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ExpertCategoryTagsController extends BaseBackendController
{
    //
    protected $_data = array(
        'title' => 'Danh mục bài viết',
        'subtitle' => 'Danh mục bài viết',
    );

    public function index()
    {
        $data = ExpertCategoryTags::orderBy('id', 'desc')->get();
        $this->_data['data'] = $data;
        return view('backend.expertCategoryTags.index', $this->_data);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ], [
                'name.required' => 'Tên không được để trống',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
                $data = new ExpertCategoryTags();
                $data->name = $request->get('name');
                $data->status = $request->get('status');
                $data->save();
                return redirect()->route('backend.expertCategoryTags.index')->with('success', 'Thêm thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }


        return view('backend.expertCategoryTags.add', $this->_data);
    }

    public function edit(Request $request, $id)
    {

        $data = ExpertCategoryTags::find($id);

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ], [
                'name.required' => 'Tên không được để trống',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
                $data->name = $request->get('name');
                $data->status = $request->get('status');
                $data->save();
                return redirect()->route('backend.expertCategoryTags.index')->with('success', 'Cập nhật thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }

        $this->_data['data'] = $data;
        return view('backend.expertCategoryTags.edit', $this->_data);
    }

    public function del(Request $request, $id)
    {
            try {
                $data = ExpertCategoryTags::find($id);
                $data->delete();
                return redirect()->route('backend.expertCategoryTags.index')->with('success', 'Xóa thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
    }

}
