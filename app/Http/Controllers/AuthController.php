<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['login', 'register']);
    }

    public function login(Request $request)
    {

    }

    public function register(Request $request)
    {

    }

    public function rfresh()
    {
        
    }
}
