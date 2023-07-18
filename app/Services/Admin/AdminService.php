<?php

namespace App\Services\Admin;

use App\Repositories\Admin\Admin\AdminRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AdminService
{
    private $repository;
    private $mailService;

    public function __construct(AdminRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function get($data)
    {
        return $this->repository->get($data);
    }

    public function store($data)
    {
        $data['creator'] = Auth::guard('users')->user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->repository->create($data);
    }

    public function find($data)
    {
        return $this->repository->find($data);
    }

    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    public function findByEmail($id)
    {
        return $this->repository->findByEmail($id);
    }

    public function update($id, $data)
    {
        if (!$this->repository->findById($id)) return false;
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->repository->update($id, $data);
    }
}
