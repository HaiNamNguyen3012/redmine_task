<?php

namespace App\Http\Middleware;

use App\Services\User\ProjectService;
use Closure;
use Illuminate\Support\Facades\Auth;


class ProjectCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    private $project_service;

    public function __construct(ProjectService $projectService)
    {
        $this->project_service = $projectService;
    }

    public function handle($request, Closure $next)
    {
        $user = Auth::guard('users')->user();
        if (empty($user->project_actived)) return redirect()->route('user.project.index');
        return $next($request);
    }
}
