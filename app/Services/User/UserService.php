<?php

namespace App\Services\User;

use App\Helpers\Helpers;
use App\Helpers\ResponseHelpers;
use App\Mail\EmailVerify;
use App\Repositories\User\Task\TaskRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\System\Mail\MailService;
use App\Services\System\Stripe\StripeService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class UserService
{
    private $repository;
    private $stripe;
    private $mailService;
    public function __construct(UserRepositoryInterface $repository, StripeService $stripe)
    {
        $this->repository = $repository;
        $this->stripe = $stripe;
    }

    public function createStripeCustomerID($data){
        $data["is_account"] = "user";
        $result = $this->stripe->registerCustomerID($data, Auth::guard(config("sys_auth.user"))->user());
        if($result["meta"]["status"] == 200){
            if($this->update(Auth::guard('users')->user()->id, ["customer_id" => $result["response"], "card_number" => substr($data['card_number'], -4)])){
                return ResponseHelpers::showResponse($result["response"], '');
            }
        }

        return $result;
    }

    public function get($data){
        return $this->repository->get($data);
    }

    public function store($data){
        $data['creator'] = Auth::guard('users')->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->repository->create($data);
    }

    public function find($data){
        return $this->repository->find($data);
    }

    public function findById($id){
        return $this->repository->findById($id);
    }

    public function findByEmail($id){
        return $this->repository->findByEmail($id);
    }

    public function update($id, $data){
        if (!$this->repository->findById($id)) return false;
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->repository->update($id, $data);
    }
}
