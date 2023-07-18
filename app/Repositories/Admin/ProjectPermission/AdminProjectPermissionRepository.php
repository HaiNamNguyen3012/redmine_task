<?php

namespace App\Repositories\Admin\ProjectPermission;

use App\Helpers\Helpers;
use App\Models\Project;
use App\Models\ProjectPermission;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminProjectPermissionRepository implements AdminProjectPermissionRepositoryInterface
{
    private $model;
    private $modelProject;

    public function __construct(ProjectPermission $model, Project $modelProject)
    {
        $this->model = $model;
        $this->modelProject = $modelProject;
    }

    public function get($data = [])
    {
        $request = request();
        $query = $this->model;
        if (isset($data['id'])) $query = $query->where("user_id", $data['id']);
        if (isset($data['user_id'])) $query = $query->where("user_id", $request['user_id']);
        if (isset($data['project_id'])) $query = $query->where("project_id", $data['project_id']);
        if (isset($request['status']) && !empty($request['status'])) $query = $query->where("status", $request['status']);
        if (isset($data['priority'])) $query = $query->where("priority", $data['priority']);
        if (isset($request['category_name']) && !empty($request['category_name'])) $query = $query->where("category_name", $request['category_name']);
        if (isset($data['with'])) $query = $query->with($data['with']);
        $query = $query->orderBy('id', 'DESC');
        if (!empty($data['paginate'])) return $query->paginate($data['paginate']);
        if (!empty($data['limit'])) $query->limit($data['limit']);
        return $query->get();
    }

    public function isAdmin($_data)
    {
        $project_creator = $this->modelProject->where('creator', $_SESSION[config("sys_auth.session")["user_choose"]])->pluck("id");
        return $this->model->where('user_id', $_SESSION[config("sys_auth.session")["user_choose"]])
            ->whereIn("project_id", $project_creator)->pluck("project_id");
//        return $this->model->where('user_id', $_SESSION[config("sys_auth.session")["user_choose"]])
//            ->where("permission_id", config("sys_auth.auth_project")["admin"]["id"])->pluck("project_id");
    }

    public function isMember($_data)
    {
        $project_creator = $this->modelProject->where('creator', $_SESSION[config("sys_auth.session")["user_choose"]])->pluck("id");
        $owner_project_permission = $this->model->where('user_id', $_SESSION[config("sys_auth.session")["user_choose"]])
            ->whereIn("project_id", $project_creator)->pluck("id");

        return $this->model->where('user_id', $_SESSION[config("sys_auth.session")["user_choose"]])
            ->whereNotIn("id", $owner_project_permission)->pluck("project_id");
//        return $this->model->where('user_id', $_SESSION[config("sys_auth.session")["user_choose"]])
//            ->where("permission_id", "<>", config("sys_auth.auth_project")["admin"]["id"])->pluck("project_id");
    }

    public function findProjectIDForUser($_data)
    {
        return $this->model->where('user_id', $_data["user_id"])->groupBy("project_id")->pluck("project_id");
    }

    public function findById($_id)
    {
        return $this->model->where('id', $_id)->first();
    }

    public function find($data)
    {
        $query = $this->model;
        if (isset($data['id'])) $query = $query->where("user_idid", $data['id']);
        if (isset($data['user_id'])) $query = $query->where("user_id", $data['user_id']);
        if (isset($data['project_id'])) $query = $query->where("project_id", $data['project_id']);
        if (isset($data['status'])) $query = $query->where("status", $data['status']);
        if (isset($data['priority'])) $query = $query->where("priority", $data['priority']);
        if (isset($data['category_name'])) $query = $query->where("category_name", $data['category_name']);
        if (isset($data['with'])) $query = $query->with($data['with']);
        return $query->first();
    }

    public function update($_id, $_data)
    {
        $data = Arr::only($_data, $this->model->fillable);
        return $this->model->where("id", $_id)->update($data);
    }

    public function create($_data)
    {
        try {
            return DB::table($this->model->table)->insert($_data);
        } catch (\Exception $ex) {
        }
    }

    public function deleteByProjectId($_id)
    {
        try {
            return $this->model->where('project_id', $_id)->delete();
        } catch (\Exception $ex) {
        }
    }

}
