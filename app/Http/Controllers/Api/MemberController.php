<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Member;
use Illuminate\Http\Request;
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
        $member = Member::get();
        $member->load('users');

        if (empty($member)) {
            return $this->responseError('Member Kosong', 403);
        }
        return $this->responseOk($member, 200, 'Sukses Liat Data Member');
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
            'user_id' => 'required|integer',
            'no_hp' => 'required|string',
            'kode_member' => 'integer',
            'saldo' => 'required|integer'

        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Buat Member', 422, $validator->errors());
        }

        $params = [
            'user_id' => $request->user_id,
            'no_hp' => $request->no_hp,
            'kode_member' => $request->kode_member ?? rand(999999999,999999999999),
            'saldo' => $request->saldo,
        ];

        $member = Member::create($params);
        return $this->responseOk($member, 200, 'Sukses Buat Member');
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
            'user_id' => 'integer',
            'no_hp' => 'string',
            'kode_member' => 'integer',
            'saldo' => 'integer'
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Buat Member', 422, $validator->errors());
        }

        $member = Member::find($id);

        $params = [
            'user_id' => $request->user_id ?? $member->user_id,
            'no_hp' => $request->no_hp ?? $member->no_hp,
            'kode_member' => $request->kode_member ?? $member->kode_member,
            'saldo' => $request->saldo ?? $member->saldo,
        ];

        $member->update($params);
        return $this->responseOk($member, 200, 'Sukses Buat Member');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();

        return $this->responseOk(null, 200, 'Sukses Hapus Member');
    }
}
