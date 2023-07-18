<?php

namespace App\Services\Admin;

use App\Mail\EmailVerify;
use App\Repositories\Admin\AdminUserRepositoryInterface;
use App\Services\System\Mail\MailService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class AdminAuthService
{
    private $mailService;
    private $repository;

    public function __construct(AdminUserRepositoryInterface $repository, MailService $mailService)
    {
        $this->repository = $repository;
        $this->mailService = $mailService;
    }

    public function login($params)
    {
        $remember = isset($params['remember']);
        $login = Auth::guard(config("sys_auth.admin"))->attempt(['email' => $params['email'], 'password' => $params['password']], $remember);
        if ($login){
            Auth::shouldUse(config("sys_auth.admin"));
            return $login;
        }
        return false;
    }

    public function registerUser($data){
        DB::beginTransaction();
        try {
            $dataUser = [
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $newUser = $this->repository->create($dataUser);
            $url = $this->verificationUrl($newUser);
            if (!$this->repository->create($dataUser)) return false;
            $statusMail = $this->mailService->to($data['email'])->send(new EmailVerify($url, "register", $dataUser));

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }


    public function verificationUrl($user)
    {
        return URL::temporarySignedRoute(
            'user.verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
                'email' => $user->email,
            ]
        );
    }

    public function verifyEmail(){
        $email = request('email');
        if (!$email) return false;
        $user = $this->repository->find(['email' => $email]);
        if ($user->email_verified_at) {
            throw new \Exception("Your Email has verified", 1);
        }
        if (! hash_equals((string) request("id"),
            (string) $user->getKey())) {
            return false;
        }

        if (! hash_equals((string) request('hash'),
            sha1($user->getEmailForVerification()))) {
            return false;
        }
        $user->markEmailAsVerified();

//        auth('users')->login($user);
        return $user;
    }

}
