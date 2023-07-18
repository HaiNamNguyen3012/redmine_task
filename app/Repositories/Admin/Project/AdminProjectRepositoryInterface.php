<?php
namespace App\Repositories\Admin\Project;

interface AdminProjectRepositoryInterface
{
    public function get($_data);

    public function findById($_id);

    public function findList($data);

    public function find($data);

    public function update($_id, $_data);

    public function store($_data);

}
