<?php

namespace Modules\User\Http\Controllers;

use App\Helpers\Helpers;
use App\Services\User\UserService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public $user_service;

    public function  __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function index()
    {
        return view('user::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show()
    {
        try{
            $data = Auth::guard('users')->user();
            $data["common"] = Helpers::metaHead(["title" => $data->name]);
            return view('user::User.show',compact('data'));
        }catch (\Exception $exception){
            abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit()
    {
        try{
            $data = Auth::guard('users')->user();
            $data["common"] = Helpers::metaHead(["title" => $data->name]);
            return view('user::User.edit',compact('data'));
        }catch (\Exception $exception){
            abort(500);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UserUpdateRequest $request)
    {
        try{
            $user = Auth::guard('users')->user();
            $detail = $this->user_service->findById($user->id);
            if (empty($detail)) abort(500);
            $data = $request->all();
            $update = $this->user_service->update($user->id,$data);
            if ($update) return redirect()->route('user.mypage.show');

            return redirect()->back()->withInput()->withErrors(['errors' => __("auth.login.failed")]);
        }catch (\Exception $exception){
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
