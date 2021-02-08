<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        if (Auth::attempt([
            'email' => request('email'),
            'password' => request('password')
        ])) {
            $user = Auth::user();
            $user->getRoleName();
            $user->createToken('pos')->accessToken;

            return response()->json($user, 'berhasil login', 200);
        }else {
            return response()->json('gagal login', 401);
        }
    }
}
