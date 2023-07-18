<?php

namespace App\Services\User;

use App\Helpers\Helpers;
use App\Mail\EmailVerify;
use App\Repositories\User\Task\TaskRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\System\Mail\MailService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class TaskService
{
    private $repository;
    private $mailService;

    public function __construct(TaskRepositoryInterface $repository, MailService $mailService)
    {
        $this->repository = $repository;
        $this->mailService = $mailService;
    }

    public function get($data)
    {
        return $this->repository->get($data);
    }

    public function getTaskForKanban($data)
    {
        return $this->repository->getTaskForKanban($data);
    }

    public function getListUserBackupForTask($data)
    {
        $tasks = $this->repository->getListUserBackupForTask($data);
        $tasks = $this->formatTask($tasks, $data);
        return $tasks;
    }

    public function getListTaskForProjectUser($data)
    {
        $tasks = $this->repository->getListTaskForProjectUser($data);
        $tasks = $this->formatTask($tasks, $data);
        return (count($tasks) > 0) ? $tasks->toArray() : [];
    }

    public function getListTaskForCategory($data)
    {
        $tasks = $this->formatTask($this->repository->getListTaskForCategory($data), $data);
        return (count($tasks) > 0) ? $tasks->toArray() : [];
    }

    public function findListTaskForUserID($project_id, $data)
    {
        return $this->repository->findListTaskForUserID($project_id, $data);
    }

    public function findListTaskForUserIDBackup($project_id, $data)
    {
        return $this->repository->findListTaskForUserIDBackup($project_id, $data);
    }

    public function store($data)
    {
        $user = Auth::guard('users')->user();
        $data['creator'] = Auth::guard('users')->user()->id;
        $data['project_id'] = $user->project_actived;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->repository->create($data);
    }

    public function find($data)
    {
        return $this->repository->find($data);
    }

    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    public function update($id, $data)
    {
        $detail = $this->repository->findById($id);
        if (!$detail) return false;
        if (!empty($data['user_id']) && !empty($detail->user_id_backup)) {
            $data['user_id_backup'] = null;
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->repository->update($id, $data);
    }

    public function updateStatus($id, $data)
    {
        $detail = $this->repository->findById($id);
        if (!$detail) return false;
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->repository->update($id, $data);
    }

    public function listMemberDeleted($data)
    {
        return $this->repository->listMemberDeleted($data);
    }

    public function listTaskEmpty($data = [])
    {
        if (empty($data["member_task"]["project"])) return [];
        $tasks = $this->repository->listTaskEmpty($data);
        $tasks = $this->formatTask($tasks, $data);
        $tasks = (count($tasks) > 0) ? $tasks->toArray() : [];

        //define
        $arr_task = [];
        $arr_task_first = [];
        $arr_task_second = [];
        $k = "empty";

        foreach ($tasks as $task) {
            $task["point_start"] = Helpers::taskPoint($task, $data, "point_start");
            $task["point_end"] = Helpers::taskPoint($task, $data, "point_end");

            if (!empty($task["start_date"])) {
                $arr_task_first[$k][strtotime($task["start_date"] . " 23:59:59")][] = $task;
            } else {
                $arr_task_second[$k][$task["id"]] = $task;
            }
        }

        //order
        if (!empty($arr_task_first[$k])) {
            ksort($arr_task_first[$k]);

            $arr_task_first_f = [];
            foreach ($arr_task_first[$k] as $values) {
                if (is_array($values)) {
                    foreach ($values as $row) {
                        $arr_task_first_f[] = $row;
                    }
                }
            }
            $arr_task_first[$k] = $arr_task_first_f;
        }
        if (!empty($arr_task_second[$k])) ksort($arr_task_second[$k]);

        //merge
        if (!empty($arr_task_first[$k]) && !empty($arr_task_second[$k])) {
            $arr_task[$k] = array_merge($arr_task_first[$k], $arr_task_second[$k]);
        } elseif (!empty($arr_task_first[$k])) {
            $arr_task[$k] = !empty($arr_task_first[$k]) ? $arr_task_first[$k] : [];
        } elseif (!empty($arr_task_second[$k])) {
            $arr_task[$k] = !empty($arr_task_second[$k]) ? $arr_task_second[$k] : [];
        } else {
            //$arr_task[$k] = [];
        }

        return $arr_task;
    }

    public function listTaskForMember($data = [])
    {
        if (empty($data["member_task"])) return [];
        $arr_task = [];
        $arr_task_first = [];
        $arr_task_second = [];
        $arr_project_id = [];
        $data["month"] = (int)$data["month"];

        foreach ($data["member_task"]["id"] as $user_id => $projects) {
            foreach ($projects as $project_id) {
                $arr_project_id[$project_id] = $project_id;
                $tasks = $this->getListTaskForProjectUser(["user_id" => $user_id, "project_id" => $project_id, "month" => $data["month"], "year" => $data["year"]]);
                foreach ($tasks as $task) {
                    $task["point_start"] = Helpers::taskPoint($task, $data, "point_start");
                    $task["point_end"] = Helpers::taskPoint($task, $data, "point_end");

                    if (!empty($task["start_date"])) {
                        $arr_task_first[$user_id][strtotime($task["start_date"] . " 23:59:59")][] = $task;
                    } else {
                        $arr_task_second[$user_id][$task["id"]] = $task;
                    }
                }

                //order
                if (!empty($arr_task_first[$user_id])) {
                    ksort($arr_task_first[$user_id]);
                    $arr_task_first_f = [];
                    foreach ($arr_task_first[$user_id] as $values) {
                        if (is_array($values)) {
                            foreach ($values as $row) {
                                $arr_task_first_f[] = $row;
                            }
                        }
                    }
                    $arr_task_first[$user_id] = $arr_task_first_f;
                }
            }

            //merge
            if (!empty($arr_task_first[$user_id]) && !empty($arr_task_second[$user_id])) {
                $arr_task[$user_id] = array_merge($arr_task_first[$user_id], $arr_task_second[$user_id]);
            } elseif (!empty($arr_task_first[$user_id])) {
                $arr_task[$user_id] = !empty($arr_task_first[$user_id]) ? $arr_task_first[$user_id] : [];
            } elseif (!empty($arr_task_second[$user_id])) {
                $arr_task[$user_id] = !empty($arr_task_second[$user_id]) ? $arr_task_second[$user_id] : [];
            } else {
                $arr_task[$user_id] = [];
            }
        }

        //get task user deleted
        $userDeleted = $this->getListUserBackupForTask(["project_ids" => $arr_project_id, "month" => $data["month"], "year" => $data["year"]]);
        $arr_user_id = [];
        $arr_task_first = [];
        $arr_task_second = [];
        foreach ($userDeleted as $task) {
            $user = $task->userBackup;
            $task = $task->toArray();
            $task["user"] = $user->toArray();
            $user_id = $task["user_id_backup"];
            $arr_user_id[$user_id] = $user_id;

            $task["point_start"] = Helpers::taskPoint($task, $data, "point_start");
            $task["point_end"] = Helpers::taskPoint($task, $data, "point_end");

            if (!empty($task["start_date"])) {
                $arr_task_first[$user_id][strtotime($task["start_date"] . " 23:59:59")][] = $task;
            } else {
                $arr_task_second[$user_id][$task["id"]] = $task;
            }
        }

        foreach ($arr_user_id as $user_id) {
            //order
            if (!empty($arr_task_first[$user_id])) {
                ksort($arr_task_first[$user_id]);

                $arr_task_first_f = [];
                foreach ($arr_task_first[$user_id] as $values) {
                    if (is_array($values)) {
                        foreach ($values as $row) {
                            $arr_task_first_f[] = $row;
                        }
                    }
                }
                $arr_task_first[$user_id] = $arr_task_first_f;
            }

            //merge
            if (!empty($arr_task_first[$user_id]) && !empty($arr_task_second[$user_id])) {
                $arr_task[$user_id] = array_merge($arr_task_first[$user_id], $arr_task_second[$user_id]);
            } elseif (!empty($arr_task_first[$user_id])) {
                $arr_task[$user_id] = !empty($arr_task_first[$user_id]) ? $arr_task_first[$user_id] : [];
            } elseif (!empty($arr_task_second[$user_id])) {
                $arr_task[$user_id] = !empty($arr_task_second[$user_id]) ? $arr_task_second[$user_id] : [];
            } else {
                $arr_task[$user_id] = [];
            }
        }

        return $arr_task;
    }

    public function listTaskForCategory($data = [])
    {
        $user = Auth::guard(config("sys_auth.user"))->user();

        //define
        $arr_category = [];
        $arr_task = [];
        $arr_task_first = [];
        $arr_task_second = [];
        if (!empty($user->project)) {
            $project_active = $user->project;
            foreach (config("sys_common.task_category") as $k => $v) {
                if (!empty($project_active) && $project_active->$k) {
                    $arr_category[$k] = $v;
                }
            }
        } else {
            $arr_category = config("sys_common.task_category");
        }

        foreach ($arr_category as $k => $category) {
            $tasks = $this->getListTaskForCategory(["category_name" => $k, "project_id" => (!empty($user->project_actived) ? $user->project_actived : ""), "month" => (int)$data["month"], "year" => $data["year"]]);
            foreach ($tasks as $task) {
                $task["point_start"] = Helpers::taskPoint($task, $data, "point_start");
                $task["point_end"] = Helpers::taskPoint($task, $data, "point_end");

                if (!empty($task["start_date"])) {
                    $arr_task_first[$k][strtotime($task["start_date"] . " 23:59:59")][] = $task;
                } else {
                    $arr_task_second[$k][$task["id"]] = $task;
                }
            }

            //order
            if (!empty($arr_task_first[$k])) {
                ksort($arr_task_first[$k]);
                $arr_task_first_f = [];
                foreach ($arr_task_first[$k] as $values) {
                    if (is_array($values)) {
                        foreach ($values as $row) {
                            $arr_task_first_f[] = $row;
                        }
                    }
                }
                $arr_task_first[$k] = $arr_task_first_f;
            }

            //merge
            if (!empty($arr_task_first[$k]) && !empty($arr_task_second[$k])) {
                $arr_task[$k] = array_merge($arr_task_first[$k], $arr_task_second[$k]);
            } elseif (!empty($arr_task_first[$k])) {
                $arr_task[$k] = !empty($arr_task_first[$k]) ? $arr_task_first[$k] : [];
            } elseif (!empty($arr_task_second[$k])) {
                $arr_task[$k] = !empty($arr_task_second[$k]) ? $arr_task_second[$k] : [];
            } else {
                $arr_task[$k] = [];
            }
        }

        return $arr_task;
    }

    public function formatTask($tasks, $data)
    {
        $data["month"] = (int)$data["month"];
        $data["year"] = (int)$data["year"];
        $date_fil = strtotime("1-" . $data["month"] . "-" . $data["year"]);

        foreach ($tasks as $k => $row) {
            //define
            $row = $row->toArray();
            $start_date_y = !empty($row["start_date"]) ? (int)date("Y", strtotime($row["start_date"] . " 23:59:59")) : "";
            $start_date_m = !empty($row["start_date"]) ? (int)date("m", strtotime($row["start_date"] . " 23:59:59")) : "";
            $end_date_y = !empty($row["end_date"]) ? (int)date("Y", strtotime($row["end_date"] . " 23:59:59")) : "";
            $end_date_m = !empty($row["end_date"]) ? (int)date("m", strtotime($row["end_date"] . " 23:59:59")) : "";
            $date_s = "";
            $date_e = "";

            if (!empty($row["start_date"])) $date_s = strtotime("1-" . $start_date_m . "-" . $start_date_y);
            if (!empty($row["end_date"])) $date_e = strtotime("1-" . $end_date_m . "-" . $end_date_y);

            //check
            if (!empty($row["start_date"]) && !empty($row["end_date"])) {
                if (($date_fil >= $date_s) && ($date_fil <= $date_e)) {

                } else {
                    unset($tasks{$k});
                }
            } elseif (!empty($row["start_date"]) && empty($row["end_date"])) {
                if ($date_fil >= $date_s) {

                } else {
                    unset($tasks{$k});
                }
            } elseif (empty($row["start_date"]) && !empty($row["end_date"])) {
                if ($date_fil <= $date_e) {

                } else {
                    unset($tasks{$k});
                }
            }
        }
        return $tasks;
    }

//    public function formatTaskEmpty($tasks, $data)
//    {
//        $data["month"] = (int)$data["month"];
//        $data["year"] = (int)$data["year"];
//        $date_fil = strtotime("1-" . $data["month"] . "-" . $data["year"]);
//
//        foreach ($tasks as $k => $row) {
//            //define
//            $row = $row->toArray();
//            $start_date_y = !empty($row["start_date"]) ? (int)date("Y", strtotime($row["start_date"] . " 23:59:59")) : "";
//            $start_date_m = !empty($row["start_date"]) ? (int)date("m", strtotime($row["start_date"] . " 23:59:59")) : "";
//            $end_date_y = !empty($row["end_date"]) ? (int)date("Y", strtotime($row["end_date"] . " 23:59:59")) : "";
//            $end_date_m = !empty($row["end_date"]) ? (int)date("m", strtotime($row["end_date"] . " 23:59:59")) : "";
//            $date_s = "";
//            $date_e = "";
//
//            if (!empty($row["start_date"])) $date_s = strtotime("1-" . $start_date_m . "-" . $start_date_y);
//            if (!empty($row["end_date"])) $date_e = strtotime("1-" . $end_date_m . "-" . $end_date_y);
//
//            //check
//            if (!empty($row["start_date"]) && !empty($row["end_date"])) {
//                if (($date_fil >= $date_s) && ($date_fil <= $date_e)) {
//
//                } else {
//                    unset($tasks{$k});
//                }
//            } elseif (!empty($row["start_date"]) && empty($row["end_date"])) {
//                if ($date_fil >= $date_s) {
//
//                } else {
//                    unset($tasks{$k});
//                }
//            } elseif (empty($row["start_date"]) && !empty($row["end_date"])) {
//                if ($date_fil <= $date_e) {
//
//                } else {
//                    unset($tasks{$k});
//                }
//            }
//        }
//        return $tasks;
//    }
}
