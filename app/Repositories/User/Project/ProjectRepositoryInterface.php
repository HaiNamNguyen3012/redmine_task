<?php
namespace App\Repositories\User\Project;

interface ProjectRepositoryInterface
{
    public function get($_data);

    public function findById($_id);

    public function deleteById($_id);

    public function findListId($data);

    public function findListPluckId($data);

    public function findList($data);

    public function findListByUser($data);

    public function find($data);

    public function update($_id, $_data);

    public function store($_data);

}
