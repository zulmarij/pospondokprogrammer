<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use App\Http\Controllers\Api\BaseController;
use App\Member;
use App\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = Penjualan::get();

        if (empty($penjualan)) {
            return $this->responseError('Penjualan belum ada', 403);
        }
        return $this->responseOk($penjualan);
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
            'barang_id' => 'required|integer',
            'jumlah_barang' => 'required|integer',
            'dibayar' => 'required|integer',
            'member_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Buat Penjualan', 422, $validator->errors());
        }

        $user = Auth::user();
        $barang = Barang::find($request->barang_id);
        $member = Member::find($request->member_id);
        $params = [
            'barang_id' => $request->barang_id,
            'jumlah_barang' => $request->jumlah_barang,
            'total_harga' => $barang->harga_jual * $request->jumlah_barang,
            'dibayar' => $request->dibayar,
            'kembalian' => $barang->harga_jual * $request->jumlah_barang > $request->dibayar ? 0 : $barang->harga_jual * $request->jumlah_barang - $request->dibayar,
            'member_id' => $request->member_id ?? 0,
            'user_id' => $user->id
        ];

        if ($params['dibayar'] < $params['total_harga']) {
            return $this->responseError('Bayaran kurang');
        } elseif ($params['member_id'] == 0) {
            $penjualan = Penjualan::create($params);
            return $this->responseOk($penjualan->load('user_id'), 201, 'Penjualan berhasil dibuat');
        } else {
            $penjualan = Penjualan::create($params);
            return $this->responseOk($penjualan->load('user_id'), 201, 'Penjualan berhasil dibuat');
        }
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
            'barang_id' => 'integer',
            'jumlah_barang' => 'integer',
            'dibayar' => 'integer',
            'member_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Ubah Penjualan', 422, $validator->errors());
        }

        $penjualan = Penjualan::find($id);

        $params = [
            'barang_id' => $request->barang_id ?? $penjualan->barang_id,
            'jumlah_barang' => $request->jumlah_barang ?? $penjualan->jumlah_barang,
            'total_harga' => $request->total_harga ?? $penjualan->total_harga,
            'dibayar' => $request->dibayar ?? $penjualan->dibayar,
            'kembalian' => $request->kembalian ?? $penjualan->kembalian,
            'member_id' => $request->member_id ?? $penjualan->member_id,
        ];

        $penjualan->update($params);
        return $this->responseOk($penjualan, 200, 'Sukses Ubah Penjualan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        $penjualan->delete();

        return $this->responseOk(null, 200, 'Sukses Hapus Penjualan');
    }
}
