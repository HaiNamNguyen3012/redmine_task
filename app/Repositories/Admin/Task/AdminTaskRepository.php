<?php

namespace App\Repositories\Admin\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Arr;

class AdminTaskRepository implements AdminTaskRepositoryInterface
{
    private $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function get($data = []){
        $request = request();
        $query = $this->model;

        if (isset($data['id'])) $query = $query->where("user_idid", $data['id']);
        if (isset($data['user_id']) && $data['user_id'] > 0) $query = $query->where("user_id", $data['user_id']);
        if (isset($request['user_id']) && $request['user_id'] > 0) $query = $query->where("user_id", $request['user_id']);
        if (isset($data['project_id'])) $query = $query->where("project_id", $data['project_id']);
        if (isset($request['status']) && !empty($request['status']) ) $query = $query->where("status", $request['status']);
        if (isset($data['priority'])) $query = $query->where("priority", $data['priority']);
        if (isset($request['category_name']) && !empty($request['category_name'])) $query = $query->where("category_name", $request['category_name']);
        if (isset($data['with'])) $query = $query->with($data['with']);
        $query = $query->orderBy('id','DESC');

        if (!empty($data['paginate'])) return $query->paginate($data['paginate']);
        if (!empty($data['limit'])) $query->limit($data['limit']);
        return $query->get();
    }

    public function getListUserBackupForTask($data = [])
    {
        $query =  $this->model->select("id", "user_id", "user_id_backup", "project_id", "name", "details", "category_name", "priority", "status", "start_date", "end_date", "deadline", "created_at")
            ->whereIn("project_id", $data["project_ids"])
            ->whereNotNull("user_id_backup");
        $query = $query->with(['statusProject']);
        if (!empty(request()->get("status"))) $query = $query->where("status", request()->get("status"));
        $query =   $query->get();
        return $query;
    }

    public function getListTaskForProjectUser($data = [])
    {
        $query = $this->model;
        $query = $query->select("id", "user_id", "user_id_backup", "project_id", "name", "details", "category_name", "priority", "status", "start_date", "end_date", "deadline", "created_at");
        $query = $query->where("project_id", $data['project_id']);
        $query = $query->where("user_id", $data['user_id']);
        $query = $query->with(['statusProject']);
        if (!empty(request()->get("status"))) $query = $query->where("status", request()->get("status"));
        return $query->get();
    }

    public function getListTaskForCategory($data = [])
    {
        $query = $this->model;
        $query = $query->select("id", "user_id", "user_id_backup", "project_id", "name", "details", "category_name", "priority", "status", "start_date", "end_date", "deadline", "created_at");
        $query = $query->where("category_name", $data['category_name']);
        $query = $query->where("project_id", $data['project_id']);
        $query = $query->with(['statusProject']);
        if (!empty(request()->get("status"))) $query = $query->where("status", request()->get("status"));
        return $query->get();
    }

    public function findById($_id)
    {
        return $this->model->where('id', $_id)->first();
    }

    public function findListTaskForUserID($project_id, $_data = [])
    {
        return $this->model->where('project_id', $project_id)->whereNotIn("user_id", $_data)->get();
    }

    public function findListTaskForUserIDBackup($project_id, $_data = [])
    {
        return $this->model->where('project_id', $project_id)->whereIn("user_id_backup", $_data)->get();
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
        $data = Arr::only($_data, $this->model->fillable);
        return $this->model->create($data);

    }

    public function listTaskEmpty($_data)
    {
        $query = $this->model;
        $query = $query->whereIn("project_id", $_data["member_task"]["project"]);
        $query = $query->with(['statusProject']);
        if (!empty($_data['person']) && $_data['person']) {
            $query = $query->whereNull("user_id");
            $query = $query->whereNull("user_id_backup");
        }
        if (!empty($_data['category']) && $_data['category']) $query = $query->whereNull("category_name");
        if (!empty(request()->get("status"))) $query = $query->where("status", request()->get("status"));
        return $query->get();
    }

    public function getTaskForKanban($data = [])
    {
        $query = $this->model;
        if (isset($data['project_id'])) $query = $query->where("project_id", $data['project_id']);
        if (!empty($data['category_name'])) $query = $query->where("category_name", $data['category_name']);
        if (!empty($data['user_id'])) {
            $ids = $this->model->where("user_id", $data['user_id'])->orWhere("user_id_backup", $data['user_id'])->pluck("id");
            $query = $query->whereIn("id", $ids);
        }
        $query = $query->orderBy('id', 'DESC');
        return $query->get();
    }

    public function listMemberDeleted($data = [])
    {
        $query = $this->model->select("id", "user_id_backup")
            ->where("project_id", $data["project_id"])
            ->whereNotNull("user_id_backup");
        $query = $query->get();
        return $query;
    }


}
