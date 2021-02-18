<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Member;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MemberController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::role('member')->get();
        $user->load('member', 'roles');
        if (empty($user)) {
            return $this->responseError('Member Kosong', 403);
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
            'kode_member' => 'integer|unique:users',
            'no_hp' => 'required|string',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Member gagal ditambahkan', 422, $validator->errors());
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
            'kode_member' => $request->kode_member ?? rand(999999999, 999999999999),
            'no_hp' => $request->no_hp,
            'password' => bcrypt($request->password),
        ];
        $params['foto'] = $foto ?? 'https://i.ibb.co/cFZfrYC/administrator.png';

        $user = User::create($params);
        $user->assignRole('member');

        return $this->responseOk($user, 201, 'Member berhasil ditambahkan');
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
        $user->load('member');
        if ($user->hasRole('member')) {
            return $this->responseOk($user);
        } else {
            return $this->responseError('Tidak ada member dengan ID ini');
        }
    }

    public function kodeMember($kode_member)
    {
        $user = User::role('member')->where('kode_member', $kode_member)->get();
        if ($user == []) {
            return $this->responseError('Tidak ada member dengan Kode Member ini');
        } else {
            return $this->responseOk($user);
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
            'kode_member' => 'integer|unique:users',
            'no_hp' => 'string',
            'password' => 'confirmed',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Member gagal diupdate', 422, $validator->errors());
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
            'kode_member' => $request->kode_member ?? $user->kode_member,
            'no_hp' => $request->no_hp ?? $user->no_hp,
        ];
        $params['foto'] = $foto ?? $user->foto;

        if ($user->hasRole('member')) {
            $user->update($params);
            return $this->responseOk($user, 200, 'Member berhasil diupdate');
        } else {
            return $this->responseError('Ini bukan akun member');
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
        } elseif ($user->hasRole('member')) {
            $user->delete();
            return $this->responseOk(null, 200, 'Member berhasil dihapus');
        } else {
            return $this->responseError('Ini bukan akun member');
        }
    }

    public function saldo(Request $request)
    {
        $member = Member::where('user_id', request('user_id'))->get();
        return $this->responseOk($member);
    }
    public function topup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'saldo' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Saldo gagal ditambah', 422, $validator->errors());
        }
        $user = User::with('member')->find(Auth::user()->id);
        $member = Member::where('user_id', Auth::user()->id);

        $params['saldo'] = $request->saldo + $user->member->saldo;
        if ($user->hasRole('member')) {
            $member->update($params);
            return $this->responseOk($member->get(), 200, 'Member berhasil topup');
        } else {
            return $this->responseError('Ini bukan akun member');
        }
    }
}
