<?php

namespace App\Repositories\System\Plan;

interface PlanRepositoryInterface
{
    public function get($_data);

    public function findById($_id, $_data);

    public function update($_id, $_data);

    public function store($_data);

    public function destroy($_id, $_data);

}
