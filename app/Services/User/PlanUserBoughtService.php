<?php

namespace App\Services\User;

use App\Helpers\Helpers;
use App\Repositories\System\PlanUserBought\PlanUserBoughtRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlanUserBoughtService
{
    private $repository;
    private $projectService;

    public function __construct(PlanUserBoughtRepositoryInterface $repository, ProjectService $projectService)
    {
        $this->repository = $repository;
        $this->projectService = $projectService;
    }

    public function get($data)
    {
        return $this->repository->get($data);
    }

    public function getLastPlanBought($data)
    {
        $data["user_id"] = Auth::guard(config("sys_auth.user"))->user()->id;
        return [
            "plan_bought" => $this->repository->getLastPlanBought($data),
            "plan_bought_by_time" => $this->repository->getLastPlanBoughtByTime($data),
            "project_count" => count($this->projectService->findListByUser(["user_id" => $data["user_id"]])),
        ];
    }

    public function getSecondLastBought($data)
    {
        return $this->repository->getSecondLastBought($data);
    }

    public function findById($id, $data)
    {
        return $this->repository->findById($id, $data);
    }

    public function store($data)
    {
        try {
            //data
            $_db = $data;
            $_db['created_at'] = date('Y-m-d H:i:s');
            $_db['updated_at'] = date('Y-m-d H:i:s');

            //save
            if (!$this->repository->store($_db)) {
                return false;
            }

            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function update($id, $data)
    {
        try {
            $data['updated_at'] = date('Y-m-d H:i:s');
            if (!$this->repository->update($id, $data)) {
                return false;
            }

            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

}
