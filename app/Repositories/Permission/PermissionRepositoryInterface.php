<?php
namespace App\Repositories\Permission;

interface PermissionRepositoryInterface
{
    public function get($_data);

    public function pluckData();

    public function pluckDataAll();

    public function findById($_id);

    public function find($data);

    public function update($_id, $_data);

    public function create($_data);

}
