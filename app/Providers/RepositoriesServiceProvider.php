<?php

namespace App\Providers;

use App\Repositories\Admin\Admin\AdminRepository;
use App\Repositories\Admin\Admin\AdminRepositoryInterface;
use App\Repositories\Admin\AdminUserRepository;
use App\Repositories\Admin\AdminUserRepositoryInterface;
use App\Repositories\Admin\Project\AdminProjectRepository;
use App\Repositories\Admin\Project\AdminProjectRepositoryInterface;
use App\Repositories\Admin\ProjectPermission\AdminProjectPermissionRepository;
use App\Repositories\Admin\ProjectPermission\AdminProjectPermissionRepositoryInterface;
use App\Repositories\Admin\ProjectStatus\AdminProjectStatusRepository;
use App\Repositories\Admin\ProjectStatus\AdminProjectStatusRepositoryInterface;
use App\Repositories\Admin\Task\AdminTaskRepository;
use App\Repositories\Admin\Task\AdminTaskRepositoryInterface;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Repositories\System\Plan\PlanRepository;
use App\Repositories\System\Plan\PlanRepositoryInterface;
use App\Repositories\System\PlanUserBought\PlanUserBoughtRepository;
use App\Repositories\System\PlanUserBought\PlanUserBoughtRepositoryInterface;
use App\Repositories\User\ProjectStatus\ProjectStatusRepository;
use App\Repositories\User\ProjectStatus\ProjectStatusRepositoryInterface;
use App\Repositories\User\Task\TaskRepository;
use App\Repositories\User\Task\TaskRepositoryInterface;
use App\Repositories\User\Project\ProjectRepository;
use App\Repositories\User\Project\ProjectRepositoryInterface;
use App\Repositories\User\ProjectPermission\ProjectPermissionRepository;
use App\Repositories\User\ProjectPermission\ProjectPermissionRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\System\Mail\AwsMailer;
use App\Services\System\Mail\MailerInterface;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //Admin
        $this->app->bind(AdminUserRepositoryInterface::class, AdminUserRepository::class);
        $this->app->bind(AdminTaskRepositoryInterface::class, AdminTaskRepository::class);
        $this->app->bind(AdminProjectRepositoryInterface::class, AdminProjectRepository::class);
        $this->app->bind(AdminProjectPermissionRepositoryInterface::class, AdminProjectPermissionRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(AdminProjectStatusRepositoryInterface::class, AdminProjectStatusRepository::class);

        //Manager

        //User
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(MailerInterface::class, AwsMailer::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(ProjectPermissionRepositoryInterface::class, ProjectPermissionRepository::class);
        $this->app->bind(ProjectStatusRepositoryInterface::class, ProjectStatusRepository::class);

        //Page

        //system
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(PlanUserBoughtRepositoryInterface::class, PlanUserBoughtRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
