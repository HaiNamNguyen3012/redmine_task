<?php
namespace Modules\Admin\Http\Controllers;

use App\Helpers\Helpers;
use App\Services\Admin\AdminAuthService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\LoginRequest;
use Modules\Admin\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AdminAuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function login()
    {
        try{
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()]]);
            return view('admin::Auth.login', ["data" => $data]);
        }catch (\Exception $exception){
            abort(500);
        }
    }

    public function postLogin(LoginRequest $request){
        try{
            $data = $request->all();
            $login = $this->authService->login($data);
            if (!$login) return redirect()->back()->withInput()->withErrors(['errors' => __("auth.login.failed")]);
            return redirect()->route('admin.user.list');
        }catch (\Exception $exception){
            abort(500);
        }
    }


    public function register()
    {
        try{
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()]]);
            return view('admin::Auth.register', ["data" => $data]);
        }catch (\Exception $exception){
            abort(500);
        }
    }

    public function postRegister(RegisterRequest $request){
        try{
            $data = $request->all();
            $register = $this->authService->registerUser($data);
            if ($register){
                return redirect()->route('admin.register.success');
            }
            return redirect()->back()->withInput()->withErrors(['errors' => __("auth.login.failed")]);
        }catch (\Exception $exception){
            abort(500);
        }
    }

    public function registerSuccess()
    {
        try{
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()]]);
            return view('admin::Auth.registerSuccess', ["data" => $data]);
        }catch (\Exception $exception){
            abort(500);
        }
    }



    public function verifyEmail(Request $request)
    {
        try {
            $result = $this->authService->verifyEmail($request->all());
            if ($result) return view('admin::Auth.registerSuccess');
            else {
                return redirect()->route('admin.auth.login');
            }
        } catch (\Exception $e) {
            abort("500");
        }
    }


    public function logOut()
    {
        try {
            auth('admins')->logout();
            return redirect()->route('admin.login.index');
        } catch (\Exception $e) {
            abort('500');
        }
    }





}
