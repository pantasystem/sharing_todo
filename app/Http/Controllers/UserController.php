<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getMe()
    {
        return Auth::user()->load('groups');
    }
}
