<?php

namespace Modules\Admin\Http\Controllers;

use App\Helpers\Helpers;
use App\Helpers\ResponseHelpers;
use App\Services\Admin\AdminProjectService;
use App\Services\Admin\AdminTaskService;
use App\Services\Admin\AdminUserService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\User\Http\Requests\TaskCreateRequest;

class TaskController extends Controller
{
    private $task_service;
    private $project_service;
    private $user_service;

    public function __construct(AdminTaskService $task_service, AdminProjectService $project_service, AdminUserService $user_service)
    {
        $this->task_service = $task_service;
        $this->project_service = $project_service;
        $this->user_service = $user_service;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try{
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()]]);
            $user = $this->user_service->findById($_SESSION[config("sys_auth.session")["user_choose"]]);
            $request = \request();
            $paginate = isset($request->paginate) ? $request->paginate : 30;
            $params = ['paginate' => $paginate,'with' => ['getCreator'],'project_id'=> $user->project_admin_actived ];
            $data['list'] = $this->task_service->get($params);
            //dd($data['list']);
            return view('admin::Task.index',compact('data'));
        }catch (\Exception $exception){
            abort(500);
        }
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        try{
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()]]);
            return view('admin::Task.create', ["data" => $data]);
        }catch (\Exception $exception){
            abort(500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(TaskCreateRequest $request)
    {
        try{
            $data = $request->all();
            $store = $this->task_service->store($data);
            if ($store) return redirect()->route('admin.task.index');

            return redirect()->back()->withInput()->withErrors(['errors' => __("auth.login.failed")]);
        }catch (\Exception $exception){
            abort(500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        try{
            $data['detail'] = $this->task_service->findById($id);
            if (empty($data['detail'])) abort(500);
            $data["common"] = Helpers::metaHead(["title" => $data["detail"]->name]);
            return view('admin::Task.show',compact('data'));
        }catch (\Exception $exception){
            abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try{
            $data['detail'] = $this->task_service->findById($id);
            if (empty($data['detail'])) abort(500);
            $data["common"] = Helpers::metaHead(["title" => $data["detail"]->name]);
            return view('admin::Task.edit',compact('data'));
        }catch (\Exception $exception){
            abort(500);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(TaskCreateRequest $request, $id)
    {
        try{
            $detail = $this->task_service->findById($id);
            if (empty($detail)) abort(500);
            $data = $request->all();
            $update = $this->task_service->update($id,$data);
            if ($update) return redirect()->route('admin.task.index');

            return redirect()->back()->withInput()->withErrors(['errors' => __("auth.login.failed")]);
        }catch (\Exception $exception){
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
     * updateStatus
     * @params int status_id, int task_id
     */
    public function updateStatus()
    {
        try {
            $data = \request()->all();
            if (empty($data["task_id"])) return ResponseHelpers::serverErrorResponse([], "json", "Fail");
            if (empty($this->task_service->findById($data["task_id"]))) return ResponseHelpers::serverErrorResponse([], "json", "Fail");
            if ($this->task_service->updateStatus($data["task_id"], ["status" => $data["status_id"]])) {
                return ResponseHelpers::showResponse($data, "json", "Done");
            } else {
                return ResponseHelpers::serverErrorResponse([], "json", "Fail");
            }
        } catch (\Exception $e) {
            return ResponseHelpers::serverErrorResponse([], "json", $e->getMessage());
        }
    }
}
