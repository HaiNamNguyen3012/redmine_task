<?php

namespace Modules\Admin\Http\Controllers;

use App\Helpers\Helpers;
use App\Services\User\PermissionService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
//use Symfony\Component\Routing\Router;
use Illuminate\Support\Facades\Route;


class PermissionController extends Controller
{

    public $permission_service;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct(PermissionService $permission_service)
    {
        $this->permission_service = $permission_service;
    }


    public function index()
    {
        try{
            $data['list'] = $this->permission_service->get(['paginate'=> 10]);
            return view('admin::permission.index',compact('data'));
        }catch (\Exception $exception){Helpers::pre($exception->getMessage());
            abort(500);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        try{
            $data['list'] = Route::getRoutes();
            $data['route'] = $this->permission_service->formatRouter($data['list']);
            //dd($data['route']['data']);
            return view('admin::permission.create',compact('data'));
        }catch (\Exception $exception){Helpers::pre($exception->getMessage());
            abort(500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try{
            $data = $request->all();
            $store = $this->permission_service->store($data);
            if ($store) return redirect()->route('user.permission.index');

            return redirect()->back()->withInput()->withErrors(['errors' => __("auth.login.failed")]);
        }catch (\Exception $exception){
            abort(500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try{
            $data['list'] = Route::getRoutes();
            $data['route'] = $this->permission_service->formatRouter($data['list']);
            $data['detail'] = $this->permission_service->findById($id);
            if (empty($data['detail'])) abort(500);
            return view('admin::permission.edit',compact('data'));
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
    public function update(Request $request, $id)
    {
        try{
            $detail = $this->permission_service->findById($id);
            if (empty($detail)) abort(500);
            $data = $request->all();
            $update = $this->permission_service->update($id,$data);
            if ($update) return redirect()->route('user.permission.index');

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
