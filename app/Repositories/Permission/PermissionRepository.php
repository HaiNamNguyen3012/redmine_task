<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use App\Models\Task;
use App\Models\User;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Support\Arr;

class PermissionRepository implements PermissionRepositoryInterface
{
    private $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function get($data = []){
        $query = $this->model;
        if (isset($data['name'])) $query = $query->where("name", $data['name']);
        if (isset($data['with'])) $query = $query->with($data['with']);
        $query = $query->orderBy('id','DESC');
        if (!empty($data['paginate'])) return $query->paginate($data['paginate']);
        if (!empty($data['limit'])) $query->limit($data['limit']);
        return $query->get();
    }


    public function pluckData()
    {
//        return $this->model->where('id', "<>", 1)->pluck("name", "id");
        return $this->model->pluck("name", "id");
    }

    public function pluckDataAll()
    {
        return $this->model->pluck("name", "id");
    }

    public function findById($_id)
    {
        return $this->model->where('id', $_id)->first();
    }

    public function find($data)
    {
        $query = $this->model;
        if (isset($data['name'])) $query = $query->where("name", $data['name']);
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

}
