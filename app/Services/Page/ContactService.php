<?php
namespace App\Services\Page;

use App\Helpers\Helpers;
use App\Mail\ContactAdmin;
use App\Mail\ContactUser;
use App\Mail\UserEmailVerify;
use App\Mail\UserForgotPass;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\System\Mail\MailService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class ContactService
{
    private $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function sendMail($data){
        try{
            if (empty($data['email'])) return false;
            if (env('APP_ENV') == 'local') {
                $email = env('APP_MAIL_DEMO','manhhiep91@gmail.com');
            }else{
                $email = env('APP_MAIL_ADMIN','regenesis.jp@gmail.com');
            }
            $this->mailService->to($email)->send(new ContactAdmin($data));
            $this->mailService->to($data['email'])->send(new ContactUser($data));
            return true;
        }catch (\Exception $exception){
            return false;
        }
    }




}
