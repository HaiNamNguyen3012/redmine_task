<?php
namespace App\Repositories\User\ProjectStatus;

interface ProjectStatusRepositoryInterface
{
    public function get($_data);

    public function findById($_id);

    public function listPluckIdStatusForProjectId($id);

    public function deleteById($id);

    public function update($_id, $_data);

    public function create($_data);

    public function deleteByProjectId($_id);

}
