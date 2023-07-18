<?php
namespace App\Repositories\Admin\ProjectPermission;

interface AdminProjectPermissionRepositoryInterface
{
    public function get($_data);

    public function isAdmin($_data);

    public function isMember($_data);

    public function findProjectIDForUser($_data);

    public function findById($_id);

    public function find($data);

    public function update($_id, $_data);

    public function create($_data);

    public function deleteByProjectId($_id);

}
