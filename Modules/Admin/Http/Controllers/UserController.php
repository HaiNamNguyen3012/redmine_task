<?php

namespace Modules\Admin\Http\Controllers;

use App\Helpers\Helpers;
use App\Services\Admin\AdminUserService;
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
    private $userId;

    public function __construct(AdminUserService $user_service)
    {
        $this->user_service = $user_service;
        $this->userId = $_SESSION[config("sys_auth.session")["user_choose"]];
    }

    public function index()
    {
        return view('admin::index');
    }

    public function listChoose()
    {
        try {
            $data["common"] = Helpers::metaHead(["title" => config("sys_common.page_title")[\request()->route()->getName()]]);
            $data["list"] = $this->user_service->get(["limit" => 1000]);
            $_SESSION["admin_choose_user_id"] = "";
            return view('admin::User.listChoose', ['data' => $data]);
        } catch (\Exception $ex) {
            abort(500);
        }
    }

    public function choose($id)
    {
        try {
            $data["detail"] = $this->user_service->findById($id);
            if (empty($data["detail"]->id)) abort(404);
            $_SESSION["admin_choose_user_id"] = $id;
            return redirect(route("admin.user.active"));
        } catch (\Exception $ex) {
            abort(500);
        }
    }

    public function active()
    {
        try {
            return redirect(route("admin.task.index"));
        } catch (\Exception $ex) {
            abort(500);
        }
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::create');
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
        try {
            $data = $this->user_service->findById($this->userId);
            if (empty($data)) abort(404);
            $data["common"] = Helpers::metaHead(["title" => $data->name]);
            return view('admin::User.show', compact('data'));
        } catch (\Exception $exception) {
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
        try {
            $data = $this->user_service->findById($this->userId);
            if (empty($data)) abort(404);
            $data["common"] = Helpers::metaHead(["title" => $data->name]);
            return view('admin::User.edit', compact('data'));
        } catch (\Exception $exception) {
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
        try {
            $detail = $this->user_service->findById($this->userId);
            if (empty($detail)) abort(404);
            $data = $request->all();
            $update = $this->user_service->update($detail->id, $data);
            if ($update) return redirect()->route('admin.mypage.show');

            return redirect()->back()->withInput()->withErrors(['errors' => __("auth.login.failed")]);
        } catch (\Exception $exception) {
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
