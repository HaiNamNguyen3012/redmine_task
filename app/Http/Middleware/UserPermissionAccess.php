<?php

namespace App\Http\Middleware;

use App\Helpers\Helpers;
use App\Services\User\PermissionService;
use App\Services\User\ProjectService;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class UserPermissionAccess
{
    private $projectService;
    private $permissionService;

    public function __construct(ProjectService $projectService, PermissionService $permissionService)
    {
        $this->projectService = $projectService;
        $this->permissionService = $permissionService;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route_current = request()->route()->getName();
        if (!in_array($route_current, config("sys_auth.allow_permission"))) {
            if(in_array($route_current, ["user.project.show", "user.project.edit"]) && !empty(request()->route()->parameters()["id"])){
                $project_id = request()->route()->parameters()["id"];
            }else{
                $project_id = Auth::guard(config("sys_auth.user"))->user()->project_actived;
            }
            $project = $this->projectService->findById($project_id);
            if(!Helpers::checkPermissionUser(@$project->project_permission_list_for_user, $route_current)) {
                if(in_array($route_current, ["user.project.show"])){
                    return redirect()->route('user.project.index');
                }else{
                    return Helpers::redirectPer();
                }
            }
        }
        return $next($request);
    }
}
