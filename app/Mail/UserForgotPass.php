<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserForgotPass extends Mailable
{
    use Queueable, SerializesModels;

    private $link;

    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $user)
    {
        $this->user = (object) $user;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->view('user::Mail.forgot', ['link' => $this->link, 'user' => $this->user]);
        $data = $data->subject('[Lonsaku] Thủ tục đặt lại mật khẩu　');
        return $data;
    }
}
