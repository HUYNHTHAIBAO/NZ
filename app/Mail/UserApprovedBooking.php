<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserApprovedBooking extends Mailable
{
    use Queueable, SerializesModels;


    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($room, $data)
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
        return $this->subject('Thông báo Tham gia cuộc gọi')
            ->view('email.user_approved_booking')
            ->with([
                'room' => $this->room,
                'data' => $this->data,
            ]);
    }
}
