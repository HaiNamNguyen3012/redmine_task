<?php

namespace App\Repositories\Admin\Project;

use App\Helpers\Helpers;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class AdminProjectRepository implements AdminProjectRepositoryInterface
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

    public function findList($data)
    {
        $query = $this->model;
        if (isset($data['id'])) $query = $query->where("id", $data['id']);
        if (isset($data['id_list'])) $query = $query->whereIn("id", $data['id_list']);
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
