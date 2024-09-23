<?php

namespace App\Jobs;

use App\Mail\ExpertCancelBooking;
use App\Models\CoreUsers;
use App\Models\RequestExpert;
use App\Models\VnpayRefund;
use App\Utils\Payment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class CancelRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(RequestExpert $request)
    {
        //
        $this->request = $request;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        {
            $dateNow = Carbon::now();
            $dateRequestExpertCarbon = Carbon::parse($this->request->date)
                ->setTimeFromTimeString($this->request->time);

            $totalTimeDifference = $dateRequestExpertCarbon->diffInSeconds($dateNow);
            $timeElapsed = $dateNow->diffInSeconds($dateRequestExpertCarbon);

            if ($timeElapsed > ($totalTimeDifference * 0.5)) {
                // Hủy yêu cầu
                $params = VnpayRefund::create([
                    'user_name' => $this->request->user->fullname,
                    'request_expert_id' => $this->request->id,
                    'vnp_Amount' => $this->request->price * 100,
                    'vnp_TransactionNo' => $this->request->vnp_TransactionNo,
                ]);

                Payment::Refund($params->toArray());

                $this->request->type = 3; // Đặt trạng thái hủy
                $this->request->note_reject = 'Hệ tống tự động hủy do quá 50% thời gian.';
                $this->request->update();

                // Gợi ý chuyên gia khác (nếu cần)
                $similarExperts = CoreUsers::where('category_id_expert', $this->request->user_expert->category_id_expert)
                    ->where('id', '<>', $this->request->user_expert_id)
                    ->limit(5)
                    ->get();

                // Gửi email thông báo
                Mail::to($this->request->email_user)->send(new ExpertCancelBooking($this->request, $similarExperts));
            }
        }
    }
}
