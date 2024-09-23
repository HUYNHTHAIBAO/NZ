<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\Bookings;
use App\Models\Files;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BookingController extends BaseBackendController
{
    //
    protected $_data = array(
        'title'    => 'Quản lý đối tác',
        'subtitle' => 'Quản lý đối tác',
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


        $data = Bookings::orderBy('sort', 'asc')->get();

        $this->_data['list_data'] = $data;
        $this->_data['filter'] = $filter;

        return view('backend.bookings.index', $this->_data);
    }
    public function add(Request $request)
    {
        $validator_rule = Bookings::get_validation_admin();

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


                Bookings::create($params);


                return redirect()->route('backend.booking.index')->with('success', 'Thêm thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
            }
        }


        $this->_data['subtitle'] = 'Thêm mới';
        $this->_data['image_file'] = old('image_id') ? Files::find(old('image_id')) : [];


        return view('backend.bookings.add', $this->_data);
    }
    public function edit(Request $request, $id)
    {
        $data = Bookings::findOrFail($id);

        $validator_rule = Bookings::get_validation_admin();

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

                return redirect()->route('backend.booking.index')->with('success', 'Cập nhật thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
            }
        }
        $this->_data['image_file'] = old('image_id', $data->image_id) ? Files::find(old('image_id', $data->image_id)) : [];
        $this->_data['data'] = $data;

        $this->_data['subtitle'] = 'Chỉnh sửa';

        return view('backend.bookings.edit', $this->_data);
    }

    public function delete(Request $request, $id)
    {
        try {
            $data = Bookings::findOrFail($id);
            $data->delete();
            return redirect()->route('backend.booking.index')->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại');
        }
    }


}
