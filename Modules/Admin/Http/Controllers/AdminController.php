<?php

namespace Modules\Admin\Http\Controllers;

use App\Helpers\Helpers;
use App\Services\Admin\AdminService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Http\Requests\AdminRequest;

class AdminController extends Controller
{

    public $admin_service;

    public function __construct(AdminService $admin_service)
    {
        $this->admin_service = $admin_service;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('admin::index');
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
            $data = Auth::guard(config("sys_auth.admin"))->user();
            $data["common"] = Helpers::metaHead(["title" => $data->name]);
            return view('admin::admin.show', compact('data'));
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
            $data = Auth::guard(config("sys_auth.admin"))->user();
            $data["common"] = Helpers::metaHead(["title" => $data->name]);
            return view('admin::admin.edit', compact('data'));
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
    public function update(AdminRequest $request)
    {
        try {
            $user = Auth::guard(config("sys_auth.admin"))->user();
            $detail = $this->admin_service->findById($user->id);
            if (empty($detail)) abort(500);
            $data = $request->all();
            $update = $this->admin_service->update($user->id, $data);
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
