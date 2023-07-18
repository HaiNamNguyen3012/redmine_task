<?php

namespace Modules\User\Http\Controllers;

use App\Helpers\Helpers;
use App\Services\User\UserService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;
use Modules\User\Http\Requests\Card\CardRequest;

class CardController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
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
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit()
    {
        try {
            return view('user::Card.edit');
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
    public function update(CardRequest $request)
    {
        try {
            $result = $this->userService->createStripeCustomerID($request->validated());
            if($result["meta"]["status"] == 200){
                return redirect()->route("user.mypage.show");
            }else{
                $errors = new MessageBag(['error' => $result["meta"]["message"]]);
                return back()->withInput([])->withErrors($errors);
            }
        } catch (\Exception $exception) {Helpers::pre($exception->getMessage());
            $errors = new MessageBag(['error' => __('layer.stripe.message.ex')]);
            return back()->withInput([])->withErrors($errors);
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
