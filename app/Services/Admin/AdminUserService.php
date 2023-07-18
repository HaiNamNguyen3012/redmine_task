<?php

namespace App\Services\Admin;

use App\Helpers\Helpers;
use App\Mail\EmailVerify;
use App\Repositories\Admin\Task\AdminTaskRepositoryInterface;
use App\Repositories\Admin\AdminUserRepositoryInterface;
use App\Services\System\Mail\MailService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class AdminUserService
{
    private $repository;
    private $mailService;
    public function __construct(AdminUserRepositoryInterface $repository)
    {
        $this->repository = $repository;
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
