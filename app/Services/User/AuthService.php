<?php

namespace App\Services\User;

use App\Helpers\Helpers;
use App\Mail\EmailVerify;
use App\Mail\UserForgotPass;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\System\Mail\MailService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class AuthService
{
    private $mailService;
    private $repository;

    public function __construct(UserRepositoryInterface $repository,MailService $mailService)
    {
        $this->repository = $repository;
        $this->mailService = $mailService;
    }

    public function login($params)
    {
        $remember = isset($params['remember']);
        $login = Auth::guard(config("sys_auth.user"))->attempt(['email' => $params['email'], 'password' => $params['password']], $remember);
        if ($login){
            Auth::shouldUse(config("sys_auth.user"));
            $user = Auth::guard(config("sys_auth.user"))->user();
            if (empty($user->email_verified_at)){
                auth('users')->logout();
                return false;
            }
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
                //'email_verified_at' => date('Y-m-d H:i:s'),
                'color' => Helpers::colorRandom(),
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


    public function forgotPass($data)
    {
        try {
            if (empty($data['email'])) return false;
            $user = $this->repository->find(['email' => $data['email']]);
            if (empty($user)) return false;
            $url = $this->forgotPassUrl($user);
            $this->mailService->to($data['email'])->send(new UserForgotPass($url, $user));
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }


    public function updatePass($data)
    {
        try {
            if (!$data['email']) return false;
            $user = $this->repository->find(['email' => $data['email']]);
            if (empty($user)) return false;
            $dataUser = [
                'password' => Hash::make($data['password']),
            ];
            $this->repository->update($user->id, $dataUser);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }


    public function forgotPassUrl($user)
    {
        return URL::temporarySignedRoute(
            'user.register.updatePass',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
                'email' => $user->email,
            ]
        );
    }

}
