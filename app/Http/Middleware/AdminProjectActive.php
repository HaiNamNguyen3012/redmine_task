<?php

namespace App\Http\Middleware;

use App\Helpers\Helpers;
use App\Services\Admin\AdminProjectService;
use App\Services\Admin\AdminTaskService;
use App\Services\Admin\AdminUserService;
use Closure;
use Illuminate\Support\Facades\View;

class AdminProjectActive
{
    private $project_service;
    private $user_service;
    private $task_service;

    public function __construct(AdminProjectService $projectService, AdminUserService $user_service,AdminTaskService $task_service)
    {
        $this->project_service = $projectService;
        $this->user_service = $user_service;
        $this->task_service = $task_service;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $user = $this->user_service->findById($_SESSION[config("sys_auth.session")["user_choose"]]);
        $project = $this->project_service->findById($user->project_admin_actived);

        if (!empty($project)) {
            View::share(['project_active' => $project]);
            $project_user_list = !empty($project->project_permission_list_user) ? $project->project_permission_list_user->toArray() : [];
            $project_user = [];
            foreach ($project_user_list as $k => $v) {
                $project_user[$v['id']] = @$v['name'] ?? $v['email'];
            }
            View::share(['project_user' => $project_user]);

            //project status
            $arr_project_status = [];
            $project_status = $user->projectStatusActiveNotOrderAdmin;
            foreach ($project_status as $row) {
                $arr_project_status[$row->id] = [
                    "title" => $row->key_status_name,
                    "key" => in_array($row->key_status, Helpers::txtRandom(true)) ? "ct-".$row->key_status : $row->key_status
                ];
            }
            \View::share(['arr_project_status' => $arr_project_status]);

            //user deleted
            $project_user_all = [];
            $task_user_deleted = $this->task_service->listMemberDeleted(["project_id" => $project->id]);
            foreach ($task_user_deleted as $row) {
                if (!empty($row->userBackup)) {
                    $project_user_all[$row->userBackup->id] = !empty($row->userBackup->name) ? $row->userBackup->name : $row->userBackup->email;
                }
            }
            \View::share(['project_user_all' => $project_user_all]);
        }

        return $next($request);
    }
}
