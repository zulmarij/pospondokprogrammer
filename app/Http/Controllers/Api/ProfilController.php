<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfilController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->getRoleNames();

        if (empty($user)) {
            return $this->responseError('LOGIN DULU', 403);
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
        //
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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'    => 'string',
            'email'   => 'string|email|unique:users',
            'foto' => 'file|image',
            'kode_member' => 'integer|unique:users',
            'no_hp' => 'string',
            'umur'   => 'integer',
            'alamat' => 'string'

        ]);

        if ($validator->fails()) {
            return $this->responseError('Profil gagal diupdate', 422, $validator->errors());
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

        $user = User::find(Auth::user()->id);
        $params = [
            'nama' => $request->nama ?? $user->nama,
            'email' => $request->email ?? $user->email,
            'foto' => $foto ?? $user->foto,
            'kode_member' => $request->kode_member ?? $user->kode_member,
            'no_hp' => $request->no_hp ?? $user->no_hp,
            'umur' => $request->umur ?? $user->umur,
            'alamat' => $request->alamat ?? $user->alamat,
        ];
        $params['foto'] = $foto ?? $user->foto;
        $user->update($params);

        return $this->responseOk($user, 200, 'Profil berhasil diupdate');
    }

    public function change(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return $this->responseError('Password gagal diupdate', 422, $validator->errors());
        }
        $user = User::find(Auth::user()->id);
        $params['password'] = bcrypt($request->password);
        $user->update($params);

        return $this->responseOk($user, 200, 'Password berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        User::find(Auth::user()->id)->delete();
        return $this->responseOk('Profil berhasil dihapus');
    }
}
