<?php

namespace App\Jobs;

use App\Models\RequestExpert;
use App\Models\VnpayRefund;
use App\Utils\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RejectExpiredRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $requestExpertId;

    /**
     * Create a new job instance.
     *
     * @param int $requestExpertId
     * @return void
     */
    public function __construct($requestExpertId)
    {
        $this->requestExpertId = $requestExpertId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = RequestExpert::find($this->requestExpertId);

        if ($data && $data->type === 1) { // Giả sử type 1 là yêu cầu đã gửi
            // Hoàn tiền
            $params = VnpayRefund::create([
                'user_name' => $data->user_name,
                'request_expert_id' => $this->requestExpertId,
                'vnp_Amount' => $data->price * 100,
                'vnp_TransactionNo' => $data->vnp_TransactionNo,
            ]);

            $pay = Payment::Refund($params->toArray());

            // Cập nhật trạng thái yêu cầu
            $data->type = 3; // Giả sử type 3 là yêu cầu bị từ chối tự động
            $data->save();
        }
    }
}
