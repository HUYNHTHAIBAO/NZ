<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;
use App\Models\CoreUsers;
use App\Models\RequestExpert;
use App\Models\RoomMeet;
use App\Models\TimeDurations;
use App\Models\TimeRates;
use App\Models\TimeRatesDuration;
use App\Utils\Common;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SettingController extends BaseFrontendController
{
    //

    public function SettingTime(Request $request)
    {
        $listTimes = TimeRates::all();
        $user = $this->getUser();
        if (empty($user))  {
            return ('/');
        }
       // Kiêm tra user co time duration hay chưa
        $icheckUser = TimeRatesDuration::where('user_id', $user->id)->first();
        if (empty($icheckUser)) {
            foreach ($listTimes as $item) {
                TimeRatesDuration::create([
                    'user_id' => $user->id,
                    'duration_id' => $item->id,
                    'duration_name' => $item->name,
                    'duration_type' => 1,
                    'price' => 0,
                ]);
            }
        }
        // tính 30 ngày tiếp theo
        $dateArray = [];
        $today = new DateTime();
        $todayFormatted = $today->format('d/m/Y');

        for ($i = 0; $i < 30; $i++) {
            $date = clone $today;
            $date->modify("+$i day");
            $dateArray[] = [
                'date' => $date->format('d/m/Y'),
                'day_name' => $date->format('l'), // định day_name de lay ten ngay
            ];
        }
        $this->_data['dateArray'] = $dateArray;
        $this->_data['user'] = $user;

        $this->_data['listTimes'] =  TimeRatesDuration::where('user_id', $user->id)->get();

        return view('frontend.user.setting.rates', $this->_data);
    }

    public function ChangeType(Request $request)
    {
        $id = $request->get('id');
        $type = TimeRatesDuration::findOrFail($id);
        $type->update([
            'duration_type' => $type->duration_type == 1 ? 2 : 1
        ]);
        return $this->returnResult('message', '');

    }
    public function ChangePrice(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->id;
        $price = intval($request->get('price'));
        $timeRatesDurations = TimeRatesDuration::where('user_id', $userId)->get();
        DB::beginTransaction();

        try {
            foreach ($timeRatesDurations as $item) {
                $timeRate = TimeRates::find($item->duration_id);
                if ($timeRate) {
                    $item->price = $price * $timeRate->number;
                    $item->save();
                }
            }

            DB::commit();
            return $this->returnResult(['data', '2']);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->returnResult('error', $e->getMessage());
        }
    }
    public function FrameTime(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->id;

        $dateString = $request->get('date');
        $date = Carbon::createFromFormat('d/m/Y', $dateString)->format('Y-m-d');

        $hour = $request->get('hour');
        $type = $request->get('type');



        // Kiểm tra và chuyển đổi giờ nếu cần thiết
        $formattedHour = intval($hour);
        if ($formattedHour > 12) {
            $formattedHour = $formattedHour - 12;
        }

        $sumHour = $formattedHour. $type;


        DB::beginTransaction();

        try {
            // Sử dụng hàm GenerateTimeSlots để tạo các mốc thời gian
            $timeSlots = Common::generateTimeSlots($formattedHour, $type);
            $existingTimeDurations = TimeDurations::where('user_id', $userId)
                ->where('date', $date)
                ->where('key',$sumHour)
                ->get();

            if (!$existingTimeDurations->isEmpty()) {
                TimeDurations::where('user_id', $userId)
                    ->where('date', $date)
                    ->where('key', $sumHour)
                    ->delete();
            } else {
                foreach ($timeSlots as $item) {
                    TimeDurations::create([
                        'user_id' => $userId,
                        'date' =>  $date,
                        'key' => $formattedHour. $type,
                        'time' => $item,
                    ]);
                }
            }

            DB::commit();
            return $this->returnResult(['data' => $timeSlots]);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->returnResult('error', $e->getMessage());
        }
    }

    public function endCall(Request $request) {
        // Lấy mã room từ request
        $roomId = $request->input('room');

        // Tìm meeting với mã room tương ứng
        $meeting = RoomMeet::where('rom_code', $roomId)->first();

        if ($meeting) {
            // Lấy order_id từ meeting
            $orderId = $meeting->order_id;

            // Tìm requestExpert với id tương ứng
            $requestExpert = RequestExpert::find($orderId);

            if ($requestExpert) {
                // Tìm chuyên gia dựa trên user_id từ requestExpert
                $expert = CoreUsers::where('id', $requestExpert->user_expert_id)->firstOrFail();

                // Tính số tiền sau khi trừ 25%
                $amountAfterDeduction = $requestExpert->price * (1 - 0.25);

                // Cập nhật điểm của chuyên gia
                $expert->point = $amountAfterDeduction; // Cộng điểm tương ứng với số tiền còn lại sau khi trừ 25%
                $expert->save();
                // Cập nhật trạng thái của requestExpert
                $requestExpert->type = 4; // Cập nhật type thành 4 (hoặc giá trị bạn muốn)
                $requestExpert->type_request_user = 4; // Cập nhật type_request_user thành 4 (hoặc giá trị bạn muốn)
                $requestExpert->save(); // Sử dụng save() thay vì update()

                return redirect()->route('frontend.user.profile')->with('success', 'Kết thúc cuộc gọi thành công');
            } else {
                return redirect()->route('frontend.user.profile')->with('error', 'Request không tìm thấy');
            }
        } else {
            return redirect()->route('frontend.user.profile')->with('error', 'Meeting không tìm thấy');
        }
    }


}
