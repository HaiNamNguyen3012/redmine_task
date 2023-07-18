<?php
namespace App\Services\Admin;

use App\Helpers\Helpers;
use Illuminate\Support\Facades\Auth;

class AdminKanbanService
{

    private $task_service;
    private $project_service;
    private $userService;
    private $userId;

    public function __construct(AdminTaskService $task_service, AdminProjectService $project_service, AdminUserService $userService)
    {
        $this->task_service = $task_service;
        $this->project_service = $project_service;
        $this->userService = $userService;
        $this->userId = $_SESSION[config("sys_auth.session")["user_choose"]];
    }

    public function getList($data)
    {
        //define
        $arr_task = [];

        //merge
        $user = $this->userService->findById($this->userId);
        $project_status = $user->projectStatusActiveAdmin;
        $arr_key = $this->keyStatus($project_status);
        $data["project_id"] = $user->project_admin_actived;
        $tasks = $this->task_service->getTaskForKanban($data);
        foreach ($project_status as $row) {
            $arr_task[] = [
                "id" => $row->id,
                "title" => $row->key_status_name,
                "order" => $row->key_status_order,
                "key" => $row->key_status,
                "project_id" => $row->project_id,
                "is_active" => $row->is_active,
                "is_data" => (count($tasks) > 0) ? true : false,
                "task_list" => $this->taskList($row, $arr_key, $tasks)
            ];
        }
        return $arr_task;
    }

    private function taskList($status, $status_active, $tasks)
    {
        $arr = [];
        foreach ($tasks as $row) {
            $r = $row->toArray();
            $r["user"] = !empty($row->user) ? $row->user->toArray() : (!empty($row->userBackup) ? $row->userBackup->toArray() : "");
            if ($status->key_status == "unselected" && $status->id == $row->status) {
                $arr[] = $r;
            } elseif (!in_array($row->status, $status_active) && $status->key_status == "unselected") {
                $arr[] = $r;
            } elseif ($status->id == $row->status) {
                $arr[] = $r;
            }
        }
        return $arr;
    }

    public function keyStatus($project_status)
    {
        $arr = [];
        foreach ($project_status as $row) {
            $arr[$row->id] = $row->id;
        }
        return $arr;
    }

}
