<?php

namespace Modules\User\Http\Controllers;

use App\Helpers\Helpers;
use App\Helpers\ResponseHelpers;
use App\Repositories\System\Plan\PlanRepositoryInterface;
use App\Services\User\PlanService;
use App\Services\User\PlanUserBoughtService;
use App\Services\User\ProjectService;
use App\Services\User\TaskService;
use App\Services\User\UserService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\User\Http\Requests\TaskCreateRequest;

class PlanController extends Controller
{

    private $service;
    private $userService;
    private $planUserBoughtService;

    public function __construct(PlanService $service, UserService $userService, PlanUserBoughtService $planUserBoughtService)
    {
        $this->service = $service;
        $this->userService = $userService;
        $this->planUserBoughtService = $planUserBoughtService;
    }

    public function index()
    {
        try {
            $data["plan"] = $this->service->get([]);
            $data["plan_bought"] = Helpers::planShowExpired($this->planUserBoughtService->getLastPlanBought(["limit" => 2]));
            return view('user::Plan.index', compact("data"));
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function confirm($id)
    {
        try {
            $data["detail"] = $this->service->findById($id, []);
            if (empty($data["detail"]->id)) abort(404);
            if ($data["detail"]->price > 0) {
                $data["plan_price"] = Helpers::calPricePlan($data["detail"]->price, ["time" => time()]);
                return view('user::Plan.plan', compact("data"));
            } else {
                $data["plan_bought"] = Helpers::planShowExpired($this->planUserBoughtService->getLastPlanBought(["limit" => 2]));
                return view('user::Plan.planFree', compact("data"));
            }
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function pay($id)
    {
        try {
            if (empty(Auth::guard('users')->user()->customer_id)) return redirect(route("user.card.edit"));
            $data["detail"] = $this->service->findById($id, []);
            if (empty($data["detail"]->id)) abort(404);
            if ($data["detail"]->price > 0) {
                $this->service->payPlan(["plan" => $data["detail"]]);
                return ResponseHelpers::showResponse(["url" => route('user.plan.check.payment', ["id" => $id])]);
            } else {

            }
        } catch (\Exception $exception) {
            return ResponseHelpers::serverErrorResponse([]);
        }
    }

    public function planSuccess()
    {
        try {
            return view('user::Plan.planSuccess');
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function checkBought($id)
    {
        try {
            $data["detail"] = $this->service->findById($id, []);
            if (empty($data["detail"]->id)) return ResponseHelpers::serverErrorResponse([], "json", "Error");
            if (Auth::guard(config("sys_auth.user"))->user()->is_bought) {
                return ResponseHelpers::showResponse(["is_bought" => Auth::guard(config("sys_auth.user"))->user()->is_bought]);
            } else {
                return ResponseHelpers::showResponse(["is_bought" => 0]);
            }
        } catch (\Exception $exception) {
            return ResponseHelpers::serverErrorResponse([], "json", "Error");
        }
    }

    public function changePlanFree($id)
    {
        try {
            $data["detail"] = $this->service->findById($id, []);
            if (empty($data["detail"]->id)) return ResponseHelpers::serverErrorResponse([], "json", "Error");
            if ($data["detail"]->price > 0) return ResponseHelpers::serverErrorResponse([], "json", "Error");
            if($this->service->planCancelSub(["plan" => $data["detail"]])){
                return ResponseHelpers::showResponse([]);
            }else {
                return ResponseHelpers::serverErrorResponse([], "json", "Error");
            }
//            if ($this->userService->update(Auth::guard('users')->user()->id, ["plan_id" => $id])) {
//                return ResponseHelpers::showResponse([]);
//            } else {
//                return ResponseHelpers::serverErrorResponse([], "json", "Error");
//            }
        } catch (\Exception $exception) {
            return ResponseHelpers::serverErrorResponse([]);
        }
    }

}
