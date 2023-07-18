<?php

namespace App\Http\Middleware;

use App\Services\Admin\AdminProjectService;
use App\Services\Admin\AdminUserService;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminProjectCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $project_service;
    private $user_service;

    public function __construct(AdminProjectService $projectService, AdminUserService $user_service)
    {
        $this->project_service = $projectService;
        $this->user_service = $user_service;
    }

    public function handle($request, Closure $next)
    {
        $user = $this->user_service->findById($_SESSION[config("sys_auth.session")["user_choose"]]);
        if (empty($user->project_admin_actived)) return redirect()->route('admin.project.index');
        return $next($request);
    }
}
