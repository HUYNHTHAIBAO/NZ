<?php

namespace App\Jobs;

use App\Mail\BookingNotification;
use App\Mail\PaymentFailedNotification;
use App\Mail\UserPaymentSuccess;
use App\Models\RequestExpert;
use App\Models\VnpayRefund;
use App\Services\MailService;
use App\Utils\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailRequestExpert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $mailService;

    /**
     * Create a new job instance.
     *
     * @param mixed $data
     * @param MailService $mailService
     * @return void
     */
    public function __construct($data, MailService $mailService)
    {
        $this->data = $data;
        $this->mailService = $mailService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = $this->data;
         // Gửi email cho danh sách email nếu có
            if (!empty($order->list_email)) {
                $arrayEmail = explode(',', $order->list_email);
                foreach ($arrayEmail as $email) {
                    $mailable = new BookingNotification($order);
                    Mail::to(trim($email))->send($mailable);
                }
            } else {
                $htmlContent = view('email.bookingNotification')->render();

                $this->mailService->sendMail(
                    'Thông báo booking',
                    $htmlContent,
                    '',
                    $order->email_user_expert,
                    '',
                    [
                        'customerName' => '',
                        'customerEmail' => '',
                    ]
                );
            }

            $htmlContent = view('email.user_payment_success')->render();
            $this->mailService->sendMail(
                'Thông báo booking',
                $htmlContent,
                '',
                $order->email_user,
                '',
                [
                    'customerName' => '',
                    'customerEmail' => '',
                ]
            );
    }
}
