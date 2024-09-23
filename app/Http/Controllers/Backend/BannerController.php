<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\Banner;
use App\Models\Files;
use App\Models\ProductType;
use App\Utils\Category;
use App\Utils\Common as Utils;
use Illuminate\Http\Request;
use Validator;

class BannerController extends BaseBackendController
{
    protected $_data = array(
        'title'    => 'Banner',
        'subtitle' => 'Banner',
    );

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $filter = $params = array_merge(array(
            'title' => null,
        ), $request->all());


        $data = Banner::where('company_id', config('constants.company_id'))
            ->orderBy('created_at', 'desc')->get();

        $this->_data['list_data'] = $data;
        $this->_data['filter'] = $filter;
        $this->_data['start'] = 0;

        return view('backend.banner.index', $this->_data);
    }

    public function add(Request $request)
    {
        $validator_rule = Banner::get_validation_admin();

        if ($request->getMethod() == 'POST') {

            Validator::make($request->all(), $validator_rule)->validate();

            $params = array_fill_keys(array_keys($validator_rule), null);
            $params = array_merge(
                $params, $request->only(array_keys($validator_rule))
            );

            try {
                $params['company_id'] = config('constants.company_id');

                $image_id = $request->get('image_id');
                if ($image_id) {
                    $file = Files::find($image_id);
                    $params['image_id'] = $file->id;
                    $params['image_path'] = $file->file_path;
                }

                Banner::create($params);

                return redirect()->route('backend.banner.index')->with('success', 'Thêm banner thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
            }
        }


        $this->_data['subtitle'] = 'Thêm mới';
        $this->_data['image_file'] = old('image_id') ? Files::find(old('image_id')) : [];

        return view('backend.banner.add', $this->_data);
    }

    public function edit(Request $request, $id)
    {
        $data = Banner::findOrFail($id);

        $validator_rule = Banner::get_validation_admin();

        if ($request->getMethod() == 'POST') {
            Validator::make($request->all(), $validator_rule)->validate();

            $params = array_fill_keys(array_keys($validator_rule), null);
            $params = array_merge(
                $params, $request->only(array_keys($validator_rule))
            );

            try {
                $params['company_id'] = config('constants.company_id');
                $image_id = $request->get('image_id');
                if ($image_id) {
                    $file = Files::find($image_id);
                    $params['image_id'] = $file->id;
                    $params['image_path'] = $file->file_path;
                }
                $data->update($params);

                return redirect()->route('backend.banner.index')->with('success', 'Cập nhật banner thành công');

            } catch (\Exception $e) {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
            }
        }
        $this->_data['image_file'] = old('image_id', $data->image_id) ? Files::find(old('image_id', $data->image_id)) : [];

        $this->_data['data'] = $data;
        $product_type = ProductType::select('id', 'name', 'parent_id')->get();
        $product_type_id = old('product_type_id', $data->product_type_id);

        $product_type_html = Category::build_select_tree($product_type->toArray(), 0, '', [$product_type_id]);

        $this->_data['product_type_html'] = $product_type_html;
        $this->_data['subtitle'] = 'Chỉnh sửa';

        return view('backend.banner.edit', $this->_data);
    }

    public function delete(Request $request, $id)
    {
        try {
            $data = Banner::where('company_id', config('constants.company_id'))->findOrFail($id);
            $data->delete();
            return redirect()->route('backend.banner.index')->with('success', 'Xóa banner thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
        }
    }
}
