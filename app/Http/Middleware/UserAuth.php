<?php

namespace App\Http\Middleware;

use App\Helpers\Helpers;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('users')->check()) {
            if (empty(Auth::guard('users')->user()->plan_id)) {
                DB::table("users")->where("id", Auth::guard('users')->user()->id)->update(["plan_id" => 1]);
            }
            return $next($request);
        }
        return redirect()->route('user.login.index');
    }
}
