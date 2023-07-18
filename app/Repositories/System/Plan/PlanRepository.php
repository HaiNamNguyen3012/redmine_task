<?php

namespace App\Repositories\System\Plan;

use App\Helpers\Helpers;
use App\Models\CartItem;
use App\Models\Correction;
use App\Models\Coupon;
use App\Models\Document;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlanRepository implements PlanRepositoryInterface
{
    private $model;
    private $table = "plans";

    public function __construct(Plan $model)
    {
        $this->model = $model;
    }

    public function get($_data)
    {
        $query = $this->model;
        if (!empty($_data['type'])) $query = $query->whereIn("type", $_data['type']);
        if(!empty($_data['limit'])) return $query->paginate($_data['limit']); else return $query->get();
    }

    public function findById($_id, $_data)
    {
        return $this->model->where('id', $_id)->first();
    }

    public function findByCode($_code, $_data)
    {
        return $this->model->where('code', $_code)->first();
    }

    public function update($_id, $_data)
    {
        return $this->model->where('id', $_id)->update($_data);
    }

    public function store($_data)
    {
        return DB::table($this->table)->insertGetId($_data);
    }

    public function destroy($_id, $_data)
    {
        try {
            if ($this->model->where('id', $_id)->delete()) {
                return true;
            }
            return false;
        } catch (\Exception $ex) {
            return false;
        }
    }

}
