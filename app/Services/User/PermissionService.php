<?php

namespace App\Services\User;

use App\Helpers\Helpers;
use App\Mail\EmailVerify;
use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Repositories\User\Task\TaskRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\System\Mail\MailService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class PermissionService
{
    private $repository;
    private $mailService;
    public function __construct(PermissionRepositoryInterface $repository,MailService $mailService)
    {
        $this->repository = $repository;
        $this->mailService = $mailService;
    }

    public function get($data){
        return $this->repository->get($data);
    }

    public function pluckData(){
        return $this->repository->pluckData();
    }

    public function pluckDataAll(){
        return $this->repository->pluckDataAll();
    }

    public function store($data){
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['permission_list'] = json_encode($data['permission_list'],true);
        return $this->repository->create($data);
    }

    public function find($data){
        return $this->repository->find($data);
    }
    public function findById($id){
        return $this->repository->findById($id);
    }

    public function update($id, $data){
        if (!$this->repository->findById($id)) return false;
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->repository->update($id, $data);
    }

    public function formatRouter($data){
        $arr = [];
        foreach ($data as $k => $row) {
            $name = $row->getName();
            if(empty($name)) continue;
            $ex = explode(".", $name);
            if(!in_array(@$ex[0], ["user", "admin", "page", "manager"])) continue;
            if(in_array(@$ex[1], ["permission"])) continue;
            $arr['data'][] = [
                'action' => $row->uri,
                'method' => $row->methods()[0],
                'name' => $name
            ];
        }
        return $arr;
    }

}
