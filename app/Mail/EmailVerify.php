<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerify extends Mailable
{
    use Queueable, SerializesModels;

    private $link;

    private $type;

    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $type = "register", $user)
    {
        $this->user = (object) $user;
        $this->link = $link;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->view('user::Mail.verify_email', ['link' => $this->link, 'type' => $this->type, 'user' => $this->user]);
        if ($this->type == "register") {
            $data = $data->subject('[Simple Gantt] Yêu cầu xác minh tài khoản');
        }
        if ($this->type == "re_verify") {
            $data = $data->subject('[Simple Gantt] Yêu cầu xác minh tài khoản');
        }
        return $data;
    }
}
