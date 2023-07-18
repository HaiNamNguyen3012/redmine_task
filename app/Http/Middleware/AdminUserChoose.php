<?php

namespace App\Http\Middleware;

use App\Services\Admin\AdminUserService;
use Closure;
use Illuminate\Support\Facades\View;

class AdminUserChoose
{
    private $userService;

    public function __construct(AdminUserService $userService)
    {
        $this->userService = $userService;
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
        if (empty($_SESSION[config("sys_auth.session")["user_choose"]])) return redirect(route("admin.user.list"));
        $user = $this->userService->findById($_SESSION[config("sys_auth.session")["user_choose"]]);
        if (empty($user->id)) return redirect(route("admin.user.list"));

        View::share("user_choose", $user);

        return $next($request);
    }
}
