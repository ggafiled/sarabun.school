<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Log::info(Auth::user());
        return view('home',["user" => Auth::user(),
        "sending" => Document::where('document_type_id','1')->count(),
        "receiving" => Document::where('document_type_id','2')->count(),
        "command" => Document::where('document_type_id','3')->count(), 
        "memorandum" => Document::where('document_type_id','4')->count()]);
    }
}