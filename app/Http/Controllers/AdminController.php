<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function usermanagementForm()
    {
        return view('admin.usermanagement');
    }
}