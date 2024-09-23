<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\Files;
use App\Models\Partner;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ReviewController extends BaseBackendController
{
    //
    protected $_data = array(
        'title'    => 'Quản lý Review',
        'subtitle' => 'Quản lý Review',
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


        $data = Review::orderBy('created_at', 'desc')->get();

        $this->_data['list_data'] = $data;
        $this->_data['filter'] = $filter;

        return view('backend.review.index', $this->_data);
    }

    public function add(Request $request)
    {
        $validator_rule = Review::get_validation_admin();

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

                Review::create($params);

                return redirect()->route('backend.review.index')->with('success', 'Thêm thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
            }
        }


        $this->_data['subtitle'] = 'Thêm mới';
        $this->_data['image_file'] = old('image_id') ? Files::find(old('image_id')) : [];

        return view('backend.review.add', $this->_data);
    }
    public function edit(Request $request, $id)
    {
        $data = Review::findOrFail($id);

        $validator_rule = Review::get_validation_admin();

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

                return redirect()->route('backend.review.index')->with('success', 'Cập nhật thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
            }
        }
        $this->_data['image_file'] = old('image_id', $data->image_id) ? Files::find(old('image_id', $data->image_id)) : [];
        $this->_data['data'] = $data;

        $this->_data['subtitle'] = 'Chỉnh sửa';

        return view('backend.review.edit', $this->_data);
    }

    public function delete(Request $request, $id)
    {
        try {
            $data = Review::findOrFail($id);
            $data->delete();
            return redirect()->route('backend.review.index')->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
        }
    }
}
