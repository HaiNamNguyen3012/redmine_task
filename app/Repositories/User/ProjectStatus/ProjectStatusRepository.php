<?php

namespace App\Repositories\User\ProjectStatus;

use App\Helpers\Helpers;
use App\Models\ProjectStatus;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProjectStatusRepository implements ProjectStatusRepositoryInterface
{
    private $model;

    public function __construct(ProjectStatus $model)
    {
        $this->model = $model;
    }

    public function get($data = [])
    {
        $request = request();
        $query = $this->model;
        if (isset($data['id'])) $query = $query->where("user_idid", $data['id']);
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

    public function findById($_id)
    {
        return $this->model->where('id', $_id)->first();
    }

    public function listPluckIdStatusForProjectId($_id)
    {
        return $this->model->where('project_id', $_id)->pluck("id");
    }

    public function deleteById($_id)
    {
        return $this->model->where('id', $_id)->delete();
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
