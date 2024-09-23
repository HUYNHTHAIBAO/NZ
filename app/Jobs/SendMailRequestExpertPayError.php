<?php

namespace App\Jobs;

use App\Mail\BookingNotification;
use App\Mail\PaymentFailedNotification;
use App\Mail\UserPaymentSuccess;
use App\Models\RequestExpert;
use App\Models\VnpayRefund;
use App\Utils\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendMailRequestExpertPayError implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @param int $requestExpertId
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         $order = $this->data;
        $emailUser = $order->email_user;
        $mailUser = new PaymentFailedNotification($order);
        Mail::to($emailUser)->send($mailUser);
    }
}
