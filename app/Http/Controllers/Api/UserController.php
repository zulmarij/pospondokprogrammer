<?php

namespace App\Http\Controllers\Api;

use App\Absent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\User;
use GuzzleHttp\Client;
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
            return $this->responseError($validator->errors());
        }

        if (Auth::attempt([
            'email' => request('email'),
            'password' => request('password'),
        ], $request->has('remember_me') ? true : false)) {
            $user = Auth::user();
            $user->load('roles');
            $response = [
                'token' => $user->createToken('pos')->accessToken,
                'user' => $user,
            ];

            $data['user_id'] = $user->id;
            Absent::create($data);

            return $this->responseOk($response);
        } else {
            return $this->responseError('Email atau Password Salah');
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
            return $this->responseError($validator->errors());
        }

        $params = [
            'nama' => $request->nama,
            'email' => $request->email,
            'kode_member' => $request->kode_member ?? rand(999999999, 999999999999),
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
            return $this->responseOk($response, 201, 'Berhasil mendaftar');
        } else {
            return $this->responseError('Gagal Daftar');
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->responseOk('Berhasil Keluar');
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
            'foto' => 'file|image',
            'kode_member' => 'integer',
            'no_hp' => 'string',
            'umur' => 'integer',
            'alamat' => 'string',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseError('User gagal ditambahkan', 422, $validator->errors());
        }

        $image = base64_encode(file_get_contents(request('foto')));
        $client = new Client();
        $res = $client->request('POST', 'https://api.imgbb.com/1/upload', [
            'form_params' => [
                'key' => 'b07a227db8a98165791eda2376549b1c',
                'action' => 'upload',
                'source' => $image,
                'format' => 'json'
            ]
        ]);

        $get = $res->getBody()->getContents();
        $data  = json_decode($get);
        $foto = $data->image->display_url ?? null;

        $params = [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'foto' => $foto,
            'kode_member' => $request->kode_member ?? rand(999999999, 999999999999),
            'no_hp' => $request->no_hp,
            'umur' => $request->umur,
            'alamat' => $request->alamat,
        ];

        $user = User::create($params);
        $user->assignRole(request('role'));

        return $this->responseOk($user, 201, 'User berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return $this->responseOk($user);
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
            'foto' => 'file|image',
            'kode_member' => 'integer',
            'no_hp' => 'string',
            'umur' => 'integer',
            'alamat' => 'string',
            'role' => 'string'
        ]);

        if ($validator->fails()) {
            return $this->responseError('User gagal diupdate', 422, $validator->errors());
        }

        $image = base64_encode(file_get_contents(request('foto')));
        $client = new Client();
        $res = $client->request('POST', 'https://api.imgbb.com/1/upload', [
            'form_params' => [
                'key' => 'b07a227db8a98165791eda2376549b1c',
                'action' => 'upload',
                'source' => $image,
                'format' => 'json'
            ]
        ]);

        $get = $res->getBody()->getContents();
        $data  = json_decode($get);

        $user = User::find($id);
        $role = Role::pluck('name', 'name')->all();

        $foto = $data->image->display_url ?? $user->foto;

        $params = [
            'nama' => $request->nama ?? $user->nama,
            'email' => $request->email ?? $user->email,
            'password' => bcrypt($request->password) ?? $user->password,
            'foto' => $foto ?? $user->foto,
            'kode_member' => $request->kode_member ?? $user->kode_member,
            'no_hp' => $request->no_hp ?? $user->no_hp,
            'umur' => $request->umur ?? $user->umur,
            'alamat' => $request->alamat ?? $user->alamat,
        ];

        $user->update($params);
        $user->assignRole(request('role') ?? $user->role);

        return $this->responseOk($user, 200, 'User berhasil diupdate');
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

        return $this->responseOk(null, 200, 'User gagal dihapus');
    }
}
