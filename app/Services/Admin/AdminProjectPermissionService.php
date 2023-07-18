<?php

namespace App\Services\Admin;

use App\Mail\EmailVerify;
use App\Repositories\User\Task\TaskRepositoryInterface;
use App\Repositories\Admin\ProjectPermission\AdminProjectPermissionRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\System\Mail\MailService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class AdminProjectPermissionService
{
    private $repository;

    public function __construct(AdminProjectPermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function get($data){
        return $this->repository->get($data);
    }

    public function isAdmin(){
        return $this->repository->isAdmin([]);
    }

    public function isMember(){
        return $this->repository->isMember([]);
    }

    public function store($data){
        return $this->repository->create($data);
    }

    public function find($data){
        return $this->repository->find($data);
    }

    public function findProjectIDForUser($data){
        return $this->repository->findProjectIDForUser($data);
    }

    public function findById($id){
        return $this->repository->findById($id);
    }

    public function update($id, $data){
        if (!$this->repository->findById($id)) return false;
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->repository->update($id, $data);
    }

    public function deleteByProjectId($id){
        return $this->repository->deleteByProjectId($id);
    }
}
