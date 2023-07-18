<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["id" => "1", "name" => "管理者", "permission_list" => '["user.task.index","user.task.create","user.task.create","user.task.show","user.task.edit","user.task.edit","user.project.index","user.project.create","user.project.create","user.project.show","user.project.edit","user.project.edit"]', 'created_at'=> \Carbon\Carbon::now()],
            ["id" => "2", "name" => "編集者", "permission_list" => '["user.task.index","user.task.create","user.task.create","user.task.show","user.task.edit","user.task.edit","user.project.index"]', 'created_at'=> \Carbon\Carbon::now()],
            ["id" => "3", "name" => "観覧者", "permission_list" => '["user.task.index","user.task.show","user.project.index"]', 'created_at'=> \Carbon\Carbon::now()],
        ];
        DB::table("permissions")->truncate();
        DB::table("permissions")->insert($data);
    }
}
