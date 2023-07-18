<?php
namespace App\Repositories\Admin;

interface AdminUserRepositoryInterface
{
    public function get($_data);

    public function findById($_id);

    public function findByEmail($_id);

    public function find($data);

    public function update($_id, $_data);

    public function create($_data);

}
