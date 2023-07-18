<?php
namespace App\Repositories\User\Task;

interface TaskRepositoryInterface
{
    public function get($_data);

    public function getTaskForKanban($_data);

    public function getListUserBackupForTask($_data);

    public function getListTaskForProjectUser($_data);

    public function getListTaskForCategory($_data);

    public function findListTaskForUserID($project_id, $_data);

    public function findListTaskForUserIDBackup($project_id, $_data);

    public function findById($_id);

    public function find($data);

    public function update($_id, $_data);

    public function create($_data);

    public function listTaskEmpty($_data);

    public function listMemberDeleted($_data);

}
