<?php

namespace Modules\User\Http\Controllers;

use App\Helpers\Helpers;
use App\Services\User\KanbanService;
use App\Services\User\ProjectService;
use App\Services\User\TaskService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\User\Http\Requests\TaskCreateRequest;

class KanbanController extends Controller
{
    private $task_service;
    private $project_service;
    private $kanban_service;

    public function __construct(TaskService $task_service, ProjectService $project_service, KanbanService $kanban_service)
    {
        $this->task_service = $task_service;
        $this->project_service = $project_service;
        $this->kanban_service = $kanban_service;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function board()
    {
        try {
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()]]);
            $data["project_status"] = $this->kanban_service->getList(\request()->all());
            return view('user::Kanban.board', compact('data'));
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

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(TaskCreateRequest $request)
    {

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(TaskCreateRequest $request, $id)
    {

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
