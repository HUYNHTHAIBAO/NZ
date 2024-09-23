<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;
use App\Models\CoreUsers;
use App\Models\ExpertPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;

class ExpertPlanController extends BaseFrontendController
{
    //
    public function index(Request $request) {
        $user = Auth()->guard('web')->user()->id;
        $data = ExpertPlan::where('user_id', $user)->orderBy('sort', 'asc')->paginate(10);
        $this->_data['data'] = $data;
        return view('frontend.expertPlan.index', $this->_data);
    }
    public function add(Request $request) {

        $user = CoreUsers::find(Auth()->guard('web')->user()->id);

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'sort' => 'required|numeric',
                'title' => 'required',
                'desc' => 'required',
                'price' => 'required',
                'status' => 'required',
            ], [
                'sort.required' => 'Số thứ tự không được để trống',
                'sort.numeric' => 'Số thứ tự phải là số',
                'title.required' => 'Tiêu đề không được để trống',
                'desc.required' => 'Mô tả không được để trống',
                'price.required' => 'Giá không được để trống',
                'status.required' => 'Trạng thái không được để trống',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
                $data = new ExpertPlan();
                $data->sort = $request->get('sort');
                $data->title = $request->get('title');
                $data->desc = $request->get('desc');
                $data->price = $request->get('price');
                $data->option_plan = $request->get('option_plan');
                $data->number_people_max = $request->get('number_people_max', 2);
                $data->user_id = $user->id;
                $data->status = $request->get('status');;
                $data->save();
                return redirect()->route('frontend.plan.index')->with('success', 'Thêm thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }

        return view('frontend.expertPlan.add');
    }
    public function edit(Request $request, $id) {

        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        $data = ExpertPlan::find($id);

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'sort' => 'required',
                'title' => 'required',
                'desc' => 'required',
                'price' => 'required',
                'status' => 'required',
            ], [
                'sort.required' => 'Tiêu đề không được để trống',
                'title.required' => 'Tiêu đề không được để trống',
                'desc.required' => 'Mô tả không được để trống',
                'price.required' => 'Giá không được để trống',
                'status.required' => 'Trạng thái không được để trống',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
                $data->sort = $request->get('sort');
                $data->title = $request->get('title');
                $data->desc = $request->get('desc');
                $data->price = $request->get('price');
                $data->option_plan = $request->get('option_plan');
                $data->number_people_max = $request->get('number_people_max', 2);
                $data->user_id = $user->id;
                $data->status = $request->get('status');;
                $data->update();
                return redirect()->route('frontend.plan.index')->with('success', 'Cập nhật thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
        $this->_data['data'] = $data;

        return view('frontend.expertPlan.edit', $this->_data);
    }
}
