<?php

namespace App\Console\Commands;

use App\Helpers\Helpers;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Task;
use Illuminate\Console\Command;

class fixData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:fixData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//        foreach (Task::where("status", "0")->get() as $row){
//            Task::where("id", $row->id)->update(["status" => "unselected"]);
//        }

        $projects = Project::get();
        foreach ($projects as $row) {
            foreach (config("sys_common.status") as $k => $r) {
                $db = [
                    "project_id" => $row->id,
                    "key_status" => $k,
                    "key_status_name" => $r,
                    "key_status_order" => 0,
                    "is_active" => 1,
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                ];
                $status = ProjectStatus::create($db);
                Task::where("project_id", $row->id)->where("status", $k)->update(["status" => $status->id]);
            }
        }

        $projectStatus = ProjectStatus::get();
        foreach ($projectStatus as $k => $r) {
            if(empty($r->key_status)){
                ProjectStatus::where("id", $r->id)->update(["key_status" => Helpers::txtRandom()]);
            }
        }
    }
}
