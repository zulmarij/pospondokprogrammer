<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KasirController extends BaseController
{
    public function index()
    {
        $user = User::role('kasir')->get();
        $user->load('roles');
        if (empty($user)) {
            return $this->responseError('Kasir Kosong', 403);
        }
        return $this->responseOk($user);
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
            'foto' => 'file|image',
            'umur' => 'required|integer',
            'alamat' => 'required|string',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Kasir gagal ditambahkan', 422, $validator->errors());
        }

        if ($request->foto) {
            $image = base64_encode(file_get_contents(request('foto')));
            $client = new Client();
            $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $image,
                    'format' => 'json'
                ]
            ]);

            $get = $res->getBody()->getContents();
            $data  = json_decode($get);
            $foto = $data->image->display_url;
        }

        $params = [
            'nama' => $request->nama,
            'email' => $request->email,
            'umur' => $request->umur,
            'alamat' => $request->alamat,
            'password' => bcrypt($request->password),
        ];
        $params['foto'] = $foto ?? 'https://i.ibb.co/cFZfrYC/administrator.png';

        $user = User::create($params);
        $user->assignRole('kasir');

        return $this->responseOk($user, 201, 'Kasir berhasil ditambahkan');
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
        if ($user->hasRole('kasir')) {
            return $this->responseOk($user);
        } else {
            return $this->responseError('Tidak ada kasir dengan ID ini');
        }
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
            'foto' => 'file|image',
            'umur' => 'integer',
            'alamat' => 'string',
            'password' => 'confirmed',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Kasir gagal diupdate', 422, $validator->errors());
        }

        if ($request->foto) {
            $image = base64_encode(file_get_contents(request('foto')));
            $client = new Client();
            $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $image,
                    'format' => 'json'
                ]
            ]);

            $get = $res->getBody()->getContents();
            $data  = json_decode($get);
            $foto = $data->image->display_url;
        }

        $user = User::find($id);

        $params = [
            'nama' => $request->nama ?? $user->nama,
            'email' => $request->email ?? $user->email,
            'password' => bcrypt($request->password) ?? $user->password,
            'foto' => $foto ?? $user->foto,
            'umur' => $request->umur ?? $user->umur,
            'alamat' => $request->alamat ?? $user->alamat,
        ];
        $params['foto'] = $foto ?? $user->foto;

        if ($user->hasRole('kasir')) {
            $user->update($params);
            return $this->responseOk($user, 200, 'Kasir berhasil diupdate');
        } else {
            return $this->responseError('Ini bukan akun kasir');
        }
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
        if ($user == []) {
            return $this->responseError('Tidak ada akun dengan ID ini');
        } elseif ($user->hasRole('kasir')) {
            $user->delete();
            return $this->responseOk(null, 200, 'Kasir berhasil dihapus');
        } else {
            return $this->responseError('Ini bukan akun kasir');
        }
    }
}
