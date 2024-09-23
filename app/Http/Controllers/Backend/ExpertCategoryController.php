<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\ExpertCategory;
use App\Models\ExpertCategoryTags;
use App\Models\Files;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ExpertCategoryController extends BaseBackendController
{
    //
    protected $_data = array(
        'title' => 'Quản lý danh mục',
        'subtitle' => 'Quản lý danh mục',
    );

    public function index()
    {
        $data = ExpertCategory::with('tags')->orderBy('id', 'desc')->get();

        $this->_data['data'] = $data;
        return view('backend.expertCategory.index', $this->_data);
    }

    public function add(Request $request)
    {
        $dataTags = ExpertCategoryTags::orderBy('id', 'desc')->get();

        if ($request->getMethod() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:lck_expert_category|max:255',
                'image_id' => 'required',
                'image_id_after' => 'required',
                'tags_id' => 'required',
            ],
                [
                    'name.required' => 'Tên danh mục không được để trống',
                    'name.unique' => 'Tên danh mục đã tồn tại trong hệ thống',
                    'name.max' => 'Tên danh mục không đượt vượt quá 255 ký tự',
                    'image_id.required' => 'Hình trước danh mục không được để trống',
                    'image_id_after.required' => 'Hình sau danh mục không được để trống',
                    'tags_id.required' => 'Tags không được để trống',
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
//            try {
            $image_id = $request->get('image_id');
            $params = [];

            if ($image_id) {
                $file = Files::find($image_id);
                if ($file) {
                    $params['image_id'] = $file->id;
                    $params['image_path'] = $file->file_path;
                }
            }

            $image_id_after = $request->get('image_id_after');
            if ($image_id_after) {
                $file_after = Files::find($image_id_after);
                if ($file_after) {
                    $params['image_id_after'] = $file_after->id; // Sửa đổi để phù hợp với trường hợp
                    $params['image_path_after'] = $file_after->file_path; // Sửa đổi để phù hợp với trường hợp
                }
            }

            $params['name'] = $request->get('name');
            $params['slug'] = str_slug($request->get('name'));
            $params['status'] = $request->get('status');

            $category = ExpertCategory::create($params);


            // lưu tags
            if ($request->has('tags_id')) {
                $category->tags()->sync($request->get('tags_id'));
            }


            return redirect()->route('backend.expertCategory.index')->with('success', 'Thêm danh mục thành công');
//            } catch (\Exception $e) {
//                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
//            }
        }
        $this->_data['image_file'] = old('image_id') ? Files::find(old('image_id')) : [];
        $this->_data['image_file_after'] = old('image_id_after') ? Files::find(old('image_id_after')) : [];
        $this->_data['dataTags'] = $dataTags;
        $this->_data['subtitle'] = 'Thêm mới';
        return view('backend.expertCategory.add', $this->_data);
    }

    public function edit(Request $request, $id)
    {
        $data = ExpertCategory::findOrFail($id);
        $dataTags = ExpertCategoryTags::orderBy('id', 'desc')->get();
        $selectedTags = $data->tags()->select('lck_expert_category_tags.id')->pluck('id')->toArray();

        if ($request->getMethod() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'image_id' => 'required',
            ], [
                'name.required' => 'Tên danh mục không được để trống',
                'name.max' => 'Tên danh mục không đượt vượt quá 255 ký tự',
                'image_id.required' => 'Hình danh mục không được để trống',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                $image_id = $request->get('image_id');
                $params = [];

                if ($image_id) {
                    $file = Files::find($image_id);
                    if ($file) {
                        $params['image_id'] = $file->id;
                        $params['image_path'] = $file->file_path;
                    }
                }

                $image_id_after = $request->get('image_id_after');
                if ($image_id_after) {
                    $file_after = Files::find($image_id_after);
                    if ($file_after) {
                        $params['image_id_after'] = $file_after->id;
                        $params['image_path_after'] = $file_after->file_path;
                    }
                }

                $params['name'] = $request->get('name');
                $params['slug'] = str_slug($request->get('name'));
                $params['status'] = $request->get('status');

                $data->update($params);

                // lưu tags
                if ($request->has('tags_id')) {
                    $data->tags()->sync($request->get('tags_id'));
                }

                return redirect()->route('backend.expertCategory.index')->with('success', 'Cập nhật danh mục thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }

        $this->_data['image_file'] = old('image_id', $data->image_id) ? Files::find(old('image_id', $data->image_id)) : [];
        $this->_data['image_file_after'] = old('image_id_after', $data->image_id_after) ? Files::find(old('image_id_after', $data->image_id_after)) : [];
        $this->_data['data'] = $data;
        $this->_data['dataTags'] = $dataTags;
        $this->_data['selectedTags'] = $selectedTags;
        $this->_data['subtitle'] = 'Cập nhật';

        return view('backend.expertCategory.edit', $this->_data);
    }


    public function del(Request $request, $id)
    {
        try {
            $data = ExpertCategory::findOrFail($id);
            $data->delete();
            return redirect()->route('backend.expertCategory.index')->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
        }
    }


}
