<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Masuk', 422, $validator->errors());
        }

        if (Auth::attempt([
            'email' => request('email'),
            'password' => request('password')
        ])) {
            $user = Auth::user();
            $user->getRoleNames();
            $response = [
                'token' => $user->createToken('pos')->accessToken,
                'user' => $user,
            ];

            return $this->responseOk($response, 200, 'Berhasil Login');
        }else {
            return $this->responseError('Password atau Email Salah', 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Daftar', 422, $validator->errors());
        }

        $params = [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        if ($user = User::create($params)) {
            $user->assignRole('member');
            $token = $user->createToken('pos')->accessToken;

            $response = [
                'token' => $token,
                'user' => $user,
            ];
            return $this->responseOk($response);
        } else {
            return $this->responseError('Gagal Daftar', 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->responseOk(null, 200, 'Berhasil Keluar');
    }
}
