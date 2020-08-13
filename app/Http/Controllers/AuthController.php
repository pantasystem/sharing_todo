<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['login']);
    }

    public function login(Request $request)
    {
        $emailAndPassword = $request->only(['email', 'password']);

        if( ! $token = auth()->attempt($emailAndPassword) ){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->responseToken($token);
    }

   

    public function rfresh()
    {

    }

    private function responseToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
