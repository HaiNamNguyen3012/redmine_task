<?php

namespace App\Services\Admin;

use App\Helpers\Helpers;
use App\Models\Project;
use App\Repositories\Admin\Project\AdminProjectRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminProjectService
{
    private $model;
    private $repository;
    private $userService;
    private $projectPermissionService;
    private $taskService;
    private $projectStatusService;
    private $userId;

    public function __construct(AdminProjectRepositoryInterface $repository,
                                Project $model,
                                AdminUserService $userService,
                                AdminProjectPermissionService $projectPermissionService,
                                AdminTaskService $taskService,
                                AdminProjectStatusService $projectStatusService)
    {
        $this->repository = $repository;
        $this->model = $model;
        $this->userService = $userService;
        $this->projectPermissionService = $projectPermissionService;
        $this->taskService = $taskService;
        $this->projectStatusService = $projectStatusService;
        $this->userId = $_SESSION[config("sys_auth.session")["user_choose"]];
    }

    public function get($data)
    {
        $data['is_admin'] = $this->projectPermissionService->isAdmin();
        $data['is_member'] = $this->projectPermissionService->isMember();

        return [
            "admin" => $this->repository->get(['id' => $data['is_admin']]),
            "member" => $this->repository->get(['id' => $data['is_member']])
        ];
    }

    public function find($data)
    {
        return $this->repository->find($data);
    }

    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            //project data
            $project = Arr::only($data, $this->model->fillable);
            $project['is_active'] = 1;
            $project['creator'] = $this->userId;
            $project['admin_id'] = Auth::guard(config("sys_auth.admin"))->user()->id;
            $project['created_at'] = date('Y-m-d H:i:s');
            $project['updated_at'] = date('Y-m-d H:i:s');

            foreach (config("sys_common.task_category") as $key => $value) {
                if(empty($project[$key])) {
                    $project[$key] = 0;
                }
            }

            $project_id = $this->repository->store($project);
            if (empty($project_id)) {
                DB::rollBack();
                return false;
            }

            //permisstion project
            $per = [];
            if (!empty($data["ip_per_email"]) && !empty($data["ip_per"])) {
                if (count($data["ip_per_email"]) == count($data["ip_per"])) {
                    foreach ($data["ip_per_email"] as $k => $row) {
                        $user = $this->userService->findByEmail($row);
                        if (!empty($user->id) && !empty($data["ip_per"][$k])) {
                            $per[] = [
                                "project_id" => $project_id,
                                "user_id" => $user->id,
                                "permission_id" => $data["ip_per"][$k],
                                "created_at" => date('Y-m-d H:i:s'),
                                "updated_at" => date('Y-m-d H:i:s'),
                            ];
                        }

                    }
                } else {
                    DB::rollBack();
                    return false;
                }
            }

            //project status
            if (!empty($data["project_status"])) {
                $arr_project_status = [];
                foreach ($data["project_status"] as $k => $row) {
                    $arr_project_status[] = [
                        "project_id" => $project_id,
                        "key_status" => isset($data["project_status_key"][$k]) ? $data["project_status_key"][$k] : Helpers::txtRandom(),
                        "key_status_name" => $row,
                        "key_status_order" => isset($data["project_status_order"][$k]) ? $data["project_status_order"][$k] : 0,
                        "is_active" => !empty($data["project_active"]) ? (in_array($k, $data["project_active"]) ? true : false) : false,
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s')
                    ];
                }
            }

            //save project [permission, status]
            $flag = true;
            if (!empty($per)) {
                if (!$this->projectPermissionService->store($per)) {
                    $flag = false;
                }
            }

            if (!empty($arr_project_status)) {
                if (!$this->projectStatusService->store($arr_project_status)) {
                    $flag = false;
                }
            }

            if ($flag) {
                DB::commit();
                return true;
            }

            DB::rollBack();
            return false;
        } catch (\Exception $ex) {
            DB::rollBack();
            return false;
        }
    }

    public function update($data, $id)
    {
        DB::beginTransaction();
        try {
            //project data
            $project = Arr::only($data, $this->model->fillable);
            $project['is_active'] = 1;
            //$project['creator'] = $this->userId;
            $project['admin_id'] = Auth::guard(config("sys_auth.admin"))->user()->id;
            //$project['created_at'] = date('Y-m-d H:i:s');
            $project['updated_at'] = date('Y-m-d H:i:s');

            foreach (config("sys_common.task_category") as $key => $value) {
                if (empty($project[$key])) {
                    $project[$key] = 0;
                }
            }

            if (!$this->repository->update($id, $project)) {
                DB::rollBack();
                return false;
            }

            //permisstion project
            $per = [];
            $arr_user_id = [];
            if (!empty($data["ip_per_email"]) && !empty($data["ip_per"])) {
                if (count($data["ip_per_email"]) == count($data["ip_per"])) {
                    foreach ($data["ip_per_email"] as $k => $row) {
                        $user = $this->userService->findByEmail($row);
                        if (!empty($user->id) && !empty($data["ip_per"][$k])) {
                            $per[] = [
                                "project_id" => $id,
                                "user_id" => $user->id,
                                "permission_id" => $data["ip_per"][$k],
                                "created_at" => date('Y-m-d H:i:s'),
                                "updated_at" => date('Y-m-d H:i:s'),
                            ];
                            $arr_user_id[] = $user->id;
                        }

                    }
                } else {
                    DB::rollBack();
                    return false;
                }
            }

            $fl = true;
            if (!empty($per)) {
                //backup user_id when project delete user
                $tasks = $this->taskService->findListTaskForUserID($id, $arr_user_id);
                $flag = true;
                foreach ($tasks as $row) {
                    $check = $this->taskService->update($row->id, ["user_id" => null, "user_id_backup" => $row->user_id]);
                    if (!$check) {
                        $flag = false;
                        break;
                    }
                }
                if (!$flag) {
                    DB::rollBack();
                    return false;
                }

                //back task
                $tasks = $this->taskService->findListTaskForUserIDBackup($id, $arr_user_id);
                $flag = true;
                foreach ($tasks as $row) {
                    if (empty($row->user_id)) {
                        $check = $this->taskService->update($row->id, ["user_id" => $row->user_id_backup, "user_id_backup" => null]);
                        if (!$check) {
                            $flag = false;
                            break;
                        }
                    }
                }
                if (!$flag) {
                    DB::rollBack();
                    return false;
                }

                //save user for project
                $this->projectPermissionService->deleteByProjectId($id);
                $store = $this->projectPermissionService->store($per);
                if (!$store) {
                    $fl = false;
                }
            }

            //project status edit
            if (!empty($data["project_ids"]) && !empty($data["project_status_id"]) && !empty($data["project_active_id"]) && !empty($data["project_status_order_id"])) {
                $project_ids = $this->projectStatusService->listPluckIdStatusForProjectId($id);
                $project_ids = (count($project_ids) > 0) ? $project_ids->toArray() : [];
                foreach ($project_ids as $row) {
                    if ($fl) {
                        if (!in_array($row, $data["project_ids"])) {
                            if (!$this->projectStatusService->deleteById($row)) {
                                $fl = false;
                                break;
                            }
                        } else {
                            $update = [
                                "key_status_name" => !empty($data["project_status_id"][$row]) ? $data["project_status_id"][$row] : "",
                                "key_status_order" => !empty($data["project_status_order_id"][$row]) ? $data["project_status_order_id"][$row] : 0,
                                "is_active" => isset($data["project_active_id"][$row]) ? true : false,
                            ];
                            if (!$this->projectStatusService->update($row, $update)) {
                                $fl = false;
                                break;
                            }
                        }
                    }
                }
            }

            //project status new
            if (!empty($data["project_status"])) {
                $arr_project_status = [];
                foreach ($data["project_status"] as $k => $row) {
                    $arr_project_status[] = [
                        "project_id" => $id,
                        "key_status" => Helpers::txtRandom(),
                        "key_status_name" => $row,
                        "key_status_order" => isset($data["project_status_order"][$k]) ? $data["project_status_order"][$k] : 0,
                        "is_active" => !empty($data["project_active"]) ? (in_array($k, $data["project_active"]) ? true : false) : false,
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s')
                    ];
                }
            }

            if (!empty($arr_project_status)) {
                if (!$this->projectStatusService->store($arr_project_status)) {
                    $fl = false;
                }
            }


            //check active
            $user = $this->userService->findById($this->userId);

            if($user->project_admin_actived == $id){
                $project = $this->findById($user->project_admin_actived);
                $arr = [];
                foreach ($project->project_permission_list as $row) {
                    $arr[] = $row->user_id;
                }
                if(!in_array($user->id, $arr)) {
                    $this->userService->update($user->id, ["project_admin_actived" => 0]);
                }
            }

            //commit
            if ($fl) {
                DB::commit();
                return true;
            }

            DB::rollBack();
            return false;
        } catch (\Exception $ex) {Helpers::pre($ex->getMessage());
            DB::rollBack();
            return false;
        }
    }

    public function update1($id, $data)
    {
        if (!$this->repository->findById($id)) return false;
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->repository->update($id, $data);
    }

    public function findList($data)
    {
        return $this->repository->findList($data);
    }
    public function listMemberForProject($data = [])
    {
        $user = $this->userService->findById($this->userId);
        if (!empty($user->project_admin_actived)) {
            $projects = $this->findList(["id" => $user->project_admin_actived]);
        } else {
            $projectId = $this->projectPermissionService->findProjectIDForUser(["user_id" => $this->userId]);
            $projects = $this->findList(["id_list" => $projectId]);
            $projects = []; // hiep fix nếu không chọn project thì ko show data
        }

        //find task for project
        $arr_user = [];
        foreach ($projects as $project) {
            foreach ($project->project_permission_list as $row) {
                $arr_user["id"][$row->user_id][] = $row->project_id;
                $arr_user["user"][$row->user_id][] = $row->user;
                $arr_user["project"][$project->id] = $project->id;
            }
        }

        return $arr_user;
    }
}
