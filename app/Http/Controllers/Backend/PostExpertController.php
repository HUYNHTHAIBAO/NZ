<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\ExpertCategory;
use App\Models\Files;
use App\Models\Location\Province;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostExpert;
use App\Utils\Category;
use App\Utils\Common as Utils;
use App\Utils\Filter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostExpertController extends BaseBackendController
{
    //
    protected $_data = array(
        'title' => 'Quản lý bài viết Expert',
        'subtitle' => 'Quản lý bài viết Expert',
    );

    public function __construct()
    {
        $this->_data['status'] = PostExpert::STATUS;
        parent::__construct();
    }

    public function index(Request $request)
    {
        $filter = $params = array_merge(array(
            'name' => null,
            'category_id' => null,
            'status' => null,
        ), $request->all());

        $data = PostExpert::with('expertCategory')->orderByRaw("CASE WHEN sort IS NULL THEN 1 ELSE 0 END, sort ASC")->get();


        $this->_data['list_data'] = $data;
        $this->_data['filter'] = $filter;

        return view('backend.postExpert.index', $this->_data);
    }

    public function add(Request $request)
    {
        $validator_rule = PostExpert::get_validation_admin();

        if ($request->getMethod() == 'POST') {

            Validator::make($request->all(), $validator_rule)->validate();

            $params = array_fill_keys(array_keys($validator_rule), null);
            $params = array_merge(
                $params, $request->only(array_keys($validator_rule))
            );

            try {
                $params['company_id'] = config('constants.company_id');
                $params['slug'] = Filter::setSeoLink($params['name']);
                $params['user_id'] = Auth()->guard('backend')->user()->id;
                $params['can_index'] = $params['can_index'] ? 1 : 0;

                PostExpert::create($params);

                return redirect()->route('backend.postExpert.index')->with('success', 'Thêm thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại');
            }
        }


        $expertCategory = ExpertCategory::where('status', 1)->get();

        $this->_data['subtitle'] = 'Thêm mới';
        $this->_data['expert_category'] = $expertCategory;
        $this->_data['thumbnail_image'] = old('thumbnail_file_id') ? Files::find(old('thumbnail_file_id')) : [];
        $this->_data['image_extra'] = old('image_extra_file_id') ? Files::find(old('image_extra_file_id')) : [];
        $this->_data['image_fb'] = old('image_fb_file_id') ? Files::find(old('image_fb_file_id')) : [];

        return view('backend.postExpert.add', $this->_data);
    }

    public function edit(Request $request, $id)
    {
        $data = PostExpert::findOrFail($id);

        $validator_rule = PostExpert::get_validation_admin();

        if ($request->getMethod() == 'POST') {
            Validator::make($request->all(), $validator_rule)->validate();

            try {
                $params = array_fill_keys(array_keys($validator_rule), null);
                $params = array_merge(
                    $params, $request->only(array_keys($validator_rule))
                );
                $params['company_id'] = config('constants.company_id');

                $params['slug'] = Filter::setSeoLink($params['name']);
                $params['can_index'] = $params['can_index'] ? 1 : 0;
                $params['user_id'] = Auth()->guard('backend')->user()->id;


                $data->update($params);

                return redirect()->route('backend.postExpert.index')->with('success', 'Cập nhật thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại');
            }
        }


        $expertCategory = ExpertCategory::where('status', 1)->get();

        $this->_data['data'] = $data;
        $this->_data['subtitle'] = 'Chỉnh sửa';
        $this->_data['expert_category'] = $expertCategory;

        $this->_data['thumbnail_image'] = old('thumbnail_file_id', $data->thumbnail_file_id) ? Files::find(old('thumbnail_file_id', $data->thumbnail_file_id)) : [];
        $this->_data['image_extra'] = old('image_extra_file_id', $data->image_extra_file_id) ? Files::find(old('image_extra_file_id', $data->image_extra_file_id)) : [];
        $this->_data['image_fb'] = old('image_fb_file_id', $data->image_fb_file_id) ? Files::find(old('image_fb_file_id', $data->image_fb_file_id)) : [];

        return view('backend.postExpert.edit', $this->_data);
    }

    public function delete(Request $request, $id)
    {
        try {
            $data = PostExpert::findOrFail($id);
            $data->delete();
            return redirect()->route('backend.postExpert.index')->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại');
        }
    }

    public function approve(Request $request, $id)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $postExpert = PostExpert::where('id', $id)->first();
                $postExpert->status = 1;
                $postExpert->save(); // Lưu lại thay đổi
                return redirect()->route('backend.postExpert.index')->with('success', 'Duyệt thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    }
    public function reject(Request $request, $id) {
        if ($request->getMethod() == 'POST') {
            try {
                $postExpert = PostExpert::where('id', $id)->first();
                $postExpert->status = 2;
                $postExpert->save();
                return redirect()->route('backend.postExpert.index')->with('success', 'Từ chối thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
    }
}
