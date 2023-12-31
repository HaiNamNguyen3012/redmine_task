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
            ["id" => "1", "name" => "Người phụ trách", "permission_list" => '["user.task.index","user.task.create","user.task.create","user.task.show","user.task.edit","user.task.edit","user.project.index","user.project.create","user.project.create","user.project.show","user.project.edit","user.project.edit"]', 'created_at'=> \Carbon\Carbon::now()],
            ["id" => "2", "name" => "Biên tập viên", "permission_list" => '["user.task.index","user.task.create","user.task.create","user.task.show","user.task.edit","user.task.edit","user.project.index"]', 'created_at'=> \Carbon\Carbon::now()],
            ["id" => "3", "name" => "Người dùng", "permission_list" => '["user.task.index","user.task.show","user.project.index"]', 'created_at'=> \Carbon\Carbon::now()],
        ];
        DB::table("permissions")->truncate();
        DB::table("permissions")->insert($data);
    }
}
