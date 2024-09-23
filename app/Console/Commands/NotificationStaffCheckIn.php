<?php

namespace App\Console\Commands;


use App\Mail\ExpertCancelBooking;
use App\Models\CoreUsers;
use App\Models\Notification;
use App\Models\RequestExpert;
use App\Models\Subscribe;
use App\Models\VnpayRefund;
use App\Utils\Payment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Jobs\PushNotification;
use App\Models\Location\Province;
use App\Models\Product;

use App\Utils\Firebase;
use App\Utils\GoogleMaps;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;

class NotificationStaffCheckIn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //đặt tên cho lệnh artisan: cú pháp thực thi php artisan notification:staff-check-in
    protected $signature = 'notification:staff-check-in';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gui thong bao den cac nhan vien den gio chekin!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // thơi gian hiện tại > $thoigianmetting
        $requestExpert = RequestExpert::where('type', 1)->with('user')->get();
        $currentTime = Carbon::now();
        $thoigianhientai = $currentTime->format('Y-m-d H:i:s'); // Lấy giờ, phút, giây

        foreach ($requestExpert as $k => $item) {
            // todo : chuyên gia
            // gợi ý chuyên gia khác khi hủy booking
//            $userExpert = CoreUsers::where('id', $item->user_expert_id)->first();
//            $categoryId = $userExpert->category_id_expert;
//            // Tìm các chuyên gia tương tự trong cùng một danh mục
//            $similarExperts = CoreUsers::where('category_id_expert', $categoryId)
//                ->where('id', '<>', $item->user_expert_id) // Không lấy chính chuyên gia hiện tại
//                ->limit(5) // Giới hạn số lượng chuyên gia gợi ý
//                ->get();
            $thoigiandatlich =  $item->created_at;
            $requestTime = Carbon::parse($item->date)->format('Y-m-d') . ' ' .$item->time;
            $date = Carbon::createFromFormat('Y-m-d h:i A', $requestTime);
            $thoigianmetting = $date->format('Y-m-d H:i:s');
            // Chuyển đổi các thời gian sang đối tượng Carbon để tính toán
            $startTime = Carbon::parse($thoigiandatlich);
            $endTime = Carbon::parse($thoigianmetting);
            $currentTime = Carbon::parse($thoigianhientai);

            // Tính tổng thời gian từ lúc đặt lịch đến lúc meeting
            $totalDuration = $startTime->diffInSeconds($endTime);

            // Tính thời gian đã trôi qua từ lúc đặt lịch đến thời điểm hiện tại
            $elapsedTime = $startTime->diffInSeconds($currentTime);

            // Tính phần trăm thời gian đã trôi qua
            $percentage = ($elapsedTime / $totalDuration) * 100;


            if($percentage >= 1) {
                $item->type = 3;
                $item->note_reject = 'Hệ thống tự hủy vì đã vượt quá 50% thời gian';
                $item->save();
            }
        }

//        $data = Subscribe::insert([
//            [
//                'company_id' => 6,
//                'email' => '',
//                'id' => ''
//            ],
//            // Thêm nhiều bản ghi nếu cần
//        ]);

    }
            // todo : user
//            if($percentage >= 75) {
//                $item->type = 3;
////                $item->type_request_user = 3;
//                $item->save();
//                $params = VnpayRefund::create([
//                    'user_name' => Auth::guard('web')->user()->fullname,
//                    'request_expert_id' => $item->id,
//                    'vnp_Amount' => $item->price * 100,
//                    'vnp_TransactionNo' => $item->vnp_TransactionNo,
//                ]);
//                Payment::Refund($params->toArray());
//                Mail::to($item->email_user)->send(new ExpertCancelBooking($item, $similarExperts));
//
//            }
}
