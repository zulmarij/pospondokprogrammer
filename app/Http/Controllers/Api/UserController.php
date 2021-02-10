<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseError(422, $validator->errors());
        }

        if (Auth::attempt([
            'email' => request('email'),
            'password' => request('password'),
        ], $request->has('remember_me') ? true : false)) {
            $user = Auth::user();
            $user->getRoleNames();
            $response = [
                'token' => $user->createToken('pos')->accessToken,
                'user' => $user,
            ];

            return $this->responseOk(200, $response);
        } else {
            return $this->responseError(401, 'Email atau Password Salah');
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'kode_member' => 'integer',
            'no_hp' => 'required|string',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Daftar', 422, $validator->errors());
        }

        $params = [
            'nama' => $request->nama,
            'email' => $request->email,
            'kode_member' => $request->kode_member ?? rand(999999999,999999999999),
            'no_hp' => $request->no_hp,
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

    public function index()
    {
        $user = User::get();

        if (empty($user)) {
            return $this->responseError('User Kosong', 403);
        }
        return $this->responseOk($user, 200, 'Sukses Liat Data User');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'umur' => 'integer',
            'alamat' => 'string',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Buat User', 422, $validator->errors());
        }

        $params = [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'umur' => $request->umur,
            'alamat' => $request->alamat,
        ];

        $user = User::create($params);
        $user->assignRole(request('role'));

        return $this->responseOk($user, 200, 'Sukses Buat User');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'string',
            'email' => 'email|unique:users',
            'password' => 'string',
            'umur' => 'integer',
            'alamat' => 'string',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Ubah User', 422, $validator->errors());
        }

        $user = User::find($id);
        $role = Role::pluck('name', 'name')->all();

        $params = [
            'nama' => $request->nama ?? $user->nama,
            'email' => $request->email ?? $user->email,
            'password' => bcrypt($request->password) ?? $user->password,
            'umur' => $request->umur ?? $user->umur,
            'alamat' => $request->alamat ?? $user->alamat,
        ];

        $user->update($params);
        $user->assignRole(request('role') ?? $user->role);

        return $this->responseOk($user, 200, 'Sukses Ubah User');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return $this->responseOk(null, 200, 'Sukses Hapus User');
    }
}
