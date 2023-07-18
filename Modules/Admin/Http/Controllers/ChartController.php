<?php

namespace Modules\Admin\Http\Controllers;

use App\Helpers\Helpers;
use App\Services\Admin\AdminProjectService;
use App\Services\Admin\AdminTaskService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\User\Http\Requests\TaskCreateRequest;

class ChartController extends Controller
{
    private $task_service;
    private $project_service;

    public function __construct(AdminTaskService $task_service, AdminProjectService $project_service)
    {
        $this->task_service = $task_service;
        $this->project_service = $project_service;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function gantt()
    {
        try {
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()]]);
            $data['listDay'] = \request()->has("start_date") ? date('t', strtotime(\request()->get("start_date") . "/01")) : date('t');
            $data['month'] = \request()->has("start_date") ? date('m', strtotime(\request()->get("start_date") . "/01")) : date('m');
            $data['year'] = \request()->has("start_date") ? date('Y', strtotime(\request()->get("start_date") . "/01")) : date('Y');
            $data["member_task"] = $this->project_service->listMemberForProject([]);
            $display = \request()->has("display") ? \request()->get("display") : "person";
            if ($display == "person") {
                $data["task_for_project"] = $this->task_service->listTaskForMember($data);
                $data["person"] = true;
                $data["task_empty"] = $this->task_service->listTaskEmpty($data);
                return view('admin::Chart.gantt', compact('data'));
            } else {
                $data["task_for_category"] = $this->task_service->listTaskForCategory($data);
                //Helpers::pre($data["task_for_category"]);
                $data["category"] = true;
                $data["task_empty"] = $this->task_service->listTaskEmpty($data);

                return view('admin::Chart.gantt_category', compact('data'));
            }
        } catch (\Exception $exception) {
            Helpers::pre($exception->getMessage());
            abort(500);
        }
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        try {
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()]]);
            return view('user::Task.create', ["data" => $data]);
        } catch (\Exception $exception) {
            Helpers::pre($exception->getMessage());
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
        try {
            $data = $request->all();
            $store = $this->task_service->store($data);
            if ($store) return redirect()->route('user.task.index');

            return redirect()->back()->withInput()->withErrors(['errors' => __("auth.login.failed")]);
        } catch (\Exception $exception) {
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
        try {
            $data['detail'] = $this->task_service->findById($id);
            if (empty($data['detail'])) abort(500);
            $data["common"] = Helpers::metaHead(["title" => $data["detail"]->name]);
            return view('user::Task.show', compact('data'));
        } catch (\Exception $exception) {
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
        try {
            $data['detail'] = $this->task_service->findById($id);
            if (empty($data['detail'])) abort(500);
            $data["common"] = Helpers::metaHead(["title" => $data["detail"]->name]);
            return view('user::Task.edit', compact('data'));
        } catch (\Exception $exception) {
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
        try {
            $detail = $this->task_service->findById($id);
            if (empty($detail)) abort(500);
            $data = $request->all();
            $update = $this->task_service->update($id, $data);
            if ($update) return redirect()->route('user.task.index');

            return redirect()->back()->withInput()->withErrors(['errors' => __("auth.login.failed")]);
        } catch (\Exception $exception) {
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
}
