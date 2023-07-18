<?php

namespace App\Repositories\Admin\Admin;

use App\Models\Admin;
use Illuminate\Support\Arr;

class AdminRepository implements AdminRepositoryInterface
{
    private $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    public function get($data = [])
    {
        $query = $this->model;
        $query = $query->orderBy('id', 'DESC');
        if (!empty($data['limit'])) $query->limit($data['limit']);
        return $query->get();
    }

    public function findById($_id)
    {
        return $this->model->where('id', $_id)->first();
    }

    public function findByEmail($_id)
    {
        return $this->model->where('email', $_id)->first();
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
        $data = Arr::only($_data, $this->model->fillable);
        return $this->model->where('id', $_id)->update($data);
    }

    public function create($_data)
    {
        return $this->model->updateOrCreate([
            'email' => $_data['email']
        ], [
            'password' => $_data['password'],
            //'verify_token' => $_data['verify_token'],
            'created_at' => $_data['created_at'],
            'updated_at' => date('Y-m-d H:i:s')
        ]);

    }

}
