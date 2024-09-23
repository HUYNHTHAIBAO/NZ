<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExpertCancelBooking extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $similarExperts;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $similarExperts)
    {
        //
        $this->data = $data;
        $this->similarExperts = $similarExperts;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
//    public function build()
//    {
//        return $this->view('email.expert_cancel_booking')->with('data', $this->data);
//    }


    public function build()
    {
        return $this->subject('Thông Báo Từ Chối Cuộc Gọi')
            ->view('email.expert_cancel_booking');
    }
}
