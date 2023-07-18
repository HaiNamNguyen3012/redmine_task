<?php

namespace App\Console\Commands;

use App\Helpers\Helpers;
use App\Services\Admin\AdminUserService;
use Illuminate\Console\Command;

class UpdateColorUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateColorUser';

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

    public $user_service;
    public function __construct(AdminUserService $user_service)
    {
        parent::__construct();
        $this->user_service = $user_service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $listUser = $this->user_service->get([]);
        foreach ($listUser as $k => $v){
            $this->user_service->update($v->id,['color' => Helpers::colorRandom() ]);
        }
    }
}
