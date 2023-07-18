<?php

namespace Modules\User\Http\Controllers;

use App\Helpers\Helpers;
use App\Helpers\ResponseHelpers;
use App\Services\User\PermissionService;
use App\Services\User\PlanUserBoughtService;
use App\Services\User\ProjectService;
use App\Services\User\UserService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\Http\Requests\ProjectCreateRequest;

class ProjectController extends Controller
{

    private $service;
    private $permissionService;
    private $userService;
    private $planUserBoughtService;

    public function __construct(ProjectService $service, PermissionService $permissionService, UserService $userService, PlanUserBoughtService $planUserBoughtService)
    {
        $this->service = $service;
        $this->permissionService = $permissionService;
        $this->userService = $userService;
        $this->planUserBoughtService = $planUserBoughtService;
    }

    /**
     * Index
     * @method GET
     */
    public function index()
    {
        try {
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()]]);
            $data["list"] = $this->service->get([]);
            $data["is_header"] = false;
            $data["plan_bought"] = Helpers::planShowExpired($this->planUserBoughtService->getLastPlanBought(["limit" => 2]));
            return view('user::project.index', ["data" => $data]);
        } catch (\Exception $ex) {
            abort(500);
        }

    }

    /**
     * Create
     * @method GET
     */
    public function create()
    {
        try {
            $data["plan_bought"] = Helpers::planShowExpired($this->planUserBoughtService->getLastPlanBought(["limit" => 2]));
            if (!$data["plan_bought"]['is_create_project']) return redirect(route('user.project.index'));
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()]]);
            $data["permisstion_pluck"] = $this->permissionService->pluckData();
            return view('user::project.create', ["data" => $data]);
        } catch (\Exception $ex) {
            abort(500);
        }
    }

    /**
     * Store
     * @method POST
     */
    public function store(ProjectCreateRequest $request)
    {
        try {
            $data["plan_bought"] = Helpers::planShowExpired($this->planUserBoughtService->getLastPlanBought(["limit" => 2]));
            if (!$data["plan_bought"]['is_create_project']) return redirect(route('user.project.index'));
            if ($this->service->store($request->all())) return redirect()->route('user.project.index');
            return redirect()->back()->withInput()->withErrors(['errors' => config("sys_common.error")["an_error_has_occurred"]]);
        } catch (\Exception $ex) {
            abort(500);
        }
    }

    /**
     * Show
     * @method GET
     */
    public function show($id)
    {
        try {
            $data["detail"] = $this->service->findById($id);
            if (empty($data["detail"]->id)) abort(404);
            if (!Helpers::checkProjectIsUser((!empty($data["detail"]->project_permission_list) ? $data["detail"]->project_permission_list : []), Auth::guard(config("sys_auth.user"))->user()->id)) return redirect()->route('user.project.index');
            $data["common"] = Helpers::metaHead(["title" => $data["detail"]->name]);
            $data["permisstion_pluck"] = $this->permissionService->pluckData();
            $data["permisstion_pluck_all"] = $this->permissionService->pluckDataAll();
            return view('user::project.show', ["data" => $data]);
        } catch (\Exception $ex) {
            abort(500);
        }
    }

    /**
     * Edit
     * @method GET
     */
    public function edit($id)
    {
        try {
            $data["detail"] = $this->service->findById($id);
            if (empty($data["detail"]->id)) abort(404);
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()]]);
            $data["permisstion_pluck"] = $this->permissionService->pluckData();
            $data["permisstion_pluck_all"] = $this->permissionService->pluckDataAll();
            return view('user::project.edit', ["data" => $data]);
        } catch (\Exception $ex) {
            Helpers::pre($ex->getMessage());
            abort(500);
        }
    }

    /**
     * Update
     * @method POST
     */
    public function update(ProjectCreateRequest $request, $id)
    {
        try {
            $data["detail"] = $this->service->findById($id);
            if (empty($data["detail"]->id)) abort(404);
            $get = $request->all();
            $get["user_service"] = $this->userService;
            if ($this->service->update($get, $id)) return redirect()->route('user.project.show', ["id" => $id]);
            return redirect()->back()->withInput()->withErrors(['errors' => config("sys_common.error")["an_error_has_occurred"]]);
        } catch (\Exception $ex) {
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    /**
     * checkEmail
     * @method Post
     */
    public function checkEmail()
    {
        try {
            $data = request()->all();
            if (!empty($data["email"])) {
                $check = $this->userService->findByEmail($data["email"]);
                if (!empty($check->id)) {
                    return ResponseHelpers::showResponse($check->id, "json", "Done");
                }
            }
            return ResponseHelpers::serverErrorResponse([], "json", config("sys_common.validation")["permission_email_not_register"]);
        } catch (\Exception $e) {
            return ResponseHelpers::serverErrorResponse([], "json", $e->getMessage());
        }
    }

    /**
     * checkStatus
     * @method Post
     */
    public function checkStatus()
    {
        try {
            $data = request()->all();
            if (!empty($data["email"])) {
                $check = $this->userService->findByEmail($data["email"]);
                if (!empty($check->id)) {
                    return ResponseHelpers::showResponse($check->id, "json", "Done");
                }
            }
            return ResponseHelpers::serverErrorResponse([], "json", config("sys_common.validation")["permission_email_not_register"]);
        } catch (\Exception $e) {
            return ResponseHelpers::serverErrorResponse([], "json", $e->getMessage());
        }
    }

    /**
     * activeUser
     * @method Post
     */
    public function activeUser()
    {
        try {
            $data = request()->all();
            if (!empty($data["project_id"])) {
                if (Auth::guard(config("sys_auth.user"))->user()->project_actived == $data["project_id"]) $data["project_id"] = 0;
                $check = $this->userService->update(Auth::guard(config("sys_auth.user"))->user()->id, ["project_actived" => $data["project_id"]]);
                if ($check) {
                    return ResponseHelpers::showResponse("", "json", "Done");
                }
            }
            return ResponseHelpers::serverErrorResponse([], "json", "Error");
        } catch (\Exception $e) {
            return ResponseHelpers::serverErrorResponse([], "json", $e->getMessage());
        }
    }
}
