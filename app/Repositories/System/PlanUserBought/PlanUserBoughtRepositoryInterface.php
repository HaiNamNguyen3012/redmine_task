<?php

namespace App\Repositories\System\PlanUserBought;

interface PlanUserBoughtRepositoryInterface
{
    public function get($_data);

    public function getLastPlanBought($_data);

    public function getLastPlanBoughtByTime($_data);

    public function getSecondLastBought($_data);

    public function findById($_id, $_data);

    public function update($_id, $_data);

    public function store($_data);

    public function destroy($_id, $_data);

}
