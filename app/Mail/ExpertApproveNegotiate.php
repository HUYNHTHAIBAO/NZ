<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExpertApproveNegotiate extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($room ,$data )
    {
        //
        $this->room = $room;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thông Báo Chấp Nhận Thương Lượng Thời Gian Và Tham Gia Cuộc Gọi')
            ->view('email.expert_approve_negotiate')
            ->with([
                'room' => $this->room,
                'data' => $this->data,
            ]);
    }
}
