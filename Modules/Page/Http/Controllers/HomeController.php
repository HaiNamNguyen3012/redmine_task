<?php

namespace Modules\Page\Http\Controllers;

use App\Helpers\Helpers;
use App\Services\Page\ContactService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Http\Requests\ContactRequest;

class HomeController extends Controller
{
    private $contact_service;

    public function __construct(ContactService $contact_service)
    {
        $this->contact_service = $contact_service;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            return view('page::Home.index');
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function term()
    {
        try {
            return view('page::Other.term');
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function policy()
    {
        try {
            return view('page::Other.policy');
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function company()
    {
        try {
            return view('page::Other.company');
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function contact()
    {
        try {
            $data['contact'] = true;
            return view('page::Other.contact');
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function contactSuccess()
    {
        try {
            $data['contact'] = true;
            return view('page::Other.contact_success', compact('data'));
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function postContact(ContactRequest $request)
    {
        try {
            $data = $request->all();
            $send = $this->contact_service->sendMail($data);
            return redirect(route('page.contact.success'));
        } catch (\Exception $exception) {
            abort(500);
        }
    }


}
