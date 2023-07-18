<?php

namespace Modules\User\Http\Controllers;

use App\Helpers\Helpers;
use App\Services\User\AuthService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\ForgotPassRequest;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Http\Requests\UpdatePassRequest;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
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
            return view('user::Auth.login', ["data" => $data]);
        }catch (\Exception $exception){
            abort(500);
        }
    }

    public function postLogin(LoginRequest $request){
        try{
            $data = $request->all();
            $login = $this->authService->login($data);
            if (!$login) return redirect()->back()->withInput()->withErrors(['errors' => __("auth.login.failed")]);
            return redirect()->route('user.task.index');
        }catch (\Exception $exception){
            abort(500);
        }
    }


    public function register()
    {
        try{
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()]]);
            return view('user::Auth.register', ["data" => $data]);
        }catch (\Exception $exception){Helpers::pre($exception->getMessage());
            abort(500);
        }
    }

    public function postRegister(RegisterRequest $request){
        try{
            $data = $request->all();
            $register = $this->authService->registerUser($data);
            if ($register){
                return redirect()->route('user.register.success');
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
            return view('user::Auth.registerSuccess', ["data" => $data]);
        }catch (\Exception $exception){
            abort(500);
        }
    }



    public function verifyEmail(Request $request)
    {
        try {
            $result = $this->authService->verifyEmail($request->all());
            if ($result) return view('user::Auth.registerConfirm');
            else {
                return redirect()->route('user.auth.login');
            }
        } catch (\Exception $e) {
            abort("500");
        }
    }

    public function forgotPass(){
        try{
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()] ?? '']);
            return view('user::Auth.forgotPass', ["data" => $data]);
        }catch (\Exception $exception){
            abort(500);
        }
    }

    public function postForgotPass(ForgotPassRequest $request){
        try{
            $data = $request->all();
            $send = $this->authService->forgotPass($data);
            if ($send){
                return redirect(route('user.forgot.pass.success'));
            }
            abort(500);
        }catch (\Exception $exception){
            abort(500);
        }
    }

    public function forgotPassSuccess(){
        try{
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()] ?? '']);
            return view('user::Auth.forgotPassSuccess', ["data" => $data]);
        }catch (\Exception $exception){
            abort(500);
        }
    }

    public function getUpdatePass(){
        try{
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()] ?? '']);
            return view('user::Auth.updatePass', ["data" => $data]);
        }catch (\Exception $exception){
            abort(500);
        }
    }

    public function postUpdatePass(UpdatePassRequest $request){
        try{
            $data = $request->all();
            $update = $this->authService->updatePass($data);
            if ($update){
                return redirect(route('user.login.index'));
            }
            abort(500);
        }catch (\Exception $exception){
            abort(500);
        }
    }

    public function logOut()
    {
        try {
            auth('users')->logout();
            return redirect()->route('user.login.index');
        } catch (\Exception $e) {
            abort('500');
        }
    }





}
