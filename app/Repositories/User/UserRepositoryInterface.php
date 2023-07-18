<?php
namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function findById($_id);

    public function findByEmail($_id);

    public function find($data);

    public function update($_id, $_data);

    public function create($_data);

}
