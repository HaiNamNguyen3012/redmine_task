<?php

namespace App\Http\Middleware;

use App\Helpers\Helpers;
use App\Services\User\ProjectService;
use App\Services\User\TaskService;
use App\Services\User\UserService;
use Closure;
use Illuminate\Support\Facades\Auth;


class ProjectActive
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */

    private $project_service;
    private $task_service;
    private $user_service;

    public function __construct(ProjectService $projectService, TaskService $task_service, UserService $user_service)
    {
        $this->project_service = $projectService;
        $this->task_service = $task_service;
        $this->user_service = $user_service;
    }

    public function handle($request, Closure $next)
    {
        $user = Auth::guard('users')->user();
        $project = $this->project_service->findById($user->project_actived);

        if (!empty($project)) {

            \View::share(['project_active' => $project]);
            $project_user_list = !empty($project->project_permission_list_user) ? $project->project_permission_list_user->toArray() : [];
            $project_user = [];
            $project_user_all = [];
            foreach ($project_user_list as $k => $v) {
                $project_user[$v['id']] = @$v['name'] ?? $v['email'];
                $project_user_all[$v['id']] = @$v['name'] ?? $v['email'];
            }
            \View::share(['project_user' => $project_user]);

            //user deleted
            $task_user_deleted = $this->task_service->listMemberDeleted(["project_id" => $project->id]);
            foreach ($task_user_deleted as $row) {
                if (!empty($row->userBackup)) {
                    $project_user_all[$row->userBackup->id] = !empty($row->userBackup->name) ? $row->userBackup->name : $row->userBackup->email;
                }
            }
            \View::share(['project_user_all' => $project_user_all]);

            //project status
            $arr_project_status = [];
            $project_status = $user->projectStatusActiveNotOrder;
            foreach ($project_status as $row) {
                $arr_project_status[$row->id] = [
                    "title" => $row->key_status_name,
                    "key" => in_array($row->key_status, Helpers::txtRandom(true)) ? "ct-" . $row->key_status : $row->key_status
                ];
            }
            \View::share(['arr_project_status' => $arr_project_status]);

        }
        return $next($request);
    }
}
