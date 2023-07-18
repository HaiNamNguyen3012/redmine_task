<?php

namespace App\Repositories\User\Project;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectRepository implements ProjectRepositoryInterface
{
    private $model;
    private $table = "projects";

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    public function get($_data)
    {
        return $this->model->whereIn('id', $_data['id'])->get();
    }

    public function findById($_id)
    {
        return $this->model->where('id', $_id)->first();
    }

    public function findListId($_id)
    {
        return $this->model->whereIn('id', $_id)->get();
    }

    public function findListPluckId($_id)
    {
        return $this->model->whereIn('id', $_id)->pluck("id");
    }

    public function deleteById($_id)
    {
        return $this->model->where('id', $_id)->delete();
    }

    public function findList($data)
    {
        $query = $this->model;
        if (isset($data['id'])) $query = $query->where("id", $data['id']);
        if (isset($data['id_list'])) $query = $query->whereIn("id", $data['id_list']);
        return $query->get();
    }

    public function findListByUser($data)
    {
        $query = $this->model;
        $query = $query->where("creator", $data['user_id']);
        return $query->get();
    }

    public function find($data)
    {
        $query = $this->model;
        if (isset($data['id'])) $query = $query->where("id", $data['id']);
        if (isset($data['email'])) $query = $query->where("email", $data['email']);
        if (isset($data['with'])) $query = $query->with($data['with']);
        return $query->first();
    }

    public function update($_id, $_data)
    {
        return $this->model->where('id', $_id)->update($_data);
    }

    public function store($_data)
    {
        return DB::table($this->table)->insertGetId($_data);
    }
}
