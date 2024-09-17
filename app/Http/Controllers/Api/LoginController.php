<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (Auth::attempt($request->only('email','password'))){
            return response()->json(Auth::user());
        };

        return response()->json([
            'message' => 'username / password salah'
        ]);
    }
}
