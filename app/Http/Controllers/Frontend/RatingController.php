<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;
use App\Models\RatingExpert;
use App\Models\RequestExpert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RatingController extends BaseFrontendController
{
    //
    public function index()
    {

        return view('frontend.user.rating.index', $this->_data);
    }

    public function add(Request $request, $id)
    {
        $rating = RequestExpert::find($id);

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'comment' => 'required',
            ], [
                'comment.required' => 'Nội dung không được để trống',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
                $data = new RatingExpert();
                $data->rating = $request->get('rating');
                $data->comment = $request->get('comment');
                $data->user_id = $rating->user_id;
                $data->user_expert_id = $rating->user_expert_id;
                $data->request_id = $rating->id;
                $data->save();
                $rating->rating_type = 2;
                $rating->save();
                return redirect()->route('frontend.user.bookingHistory')->with('info', 'Đánh giá thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }

        $this->_data['rating'] = $rating;
        return view('frontend.user.rating.add', $this->_data);
    }
    public function detail(Request $request, $id) {

        $requestExpert = RequestExpert::find($id);
        $rating = RatingExpert::where('request_id', $requestExpert->id)->first();

        $this->_data['rating'] = $rating;
        return view('frontend.user.rating.detail', $this->_data);
    }
}
