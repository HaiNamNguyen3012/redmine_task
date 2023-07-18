<?php

namespace App\Services\User;

use App\Mail\EmailVerify;
use App\Repositories\User\ProjectStatus\ProjectStatusRepositoryInterface;

class ProjectStatusService
{
    private $repository;

    public function __construct(ProjectStatusRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function get($data){
        return $this->repository->get($data);
    }

    public function store($data){
        return $this->repository->create($data);
    }

    public function findById($id){
        return $this->repository->findById($id);
    }

    public function listPluckIdStatusForProjectId($id){
        return $this->repository->listPluckIdStatusForProjectId($id);
    }

    public function deleteById($id){
        return $this->repository->deleteById($id);
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
