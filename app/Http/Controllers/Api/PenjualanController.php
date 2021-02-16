<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use App\DetailPenjualan;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use App\Member;
use App\Penjualan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dibayar()
    {
        $penjualan = Penjualan::where('dibayar', '>', 0)->latest()->get();
        $penjualan->load('barang', 'member', 'user');
        if ($penjualan == []) {
            return $this->responseError('Data penjualan yang sudah dibayar tidak ada', 403);
        }
        return $this->responseOk($penjualan);
    }

    public function belumbayar()
    {
        $penjualan = Penjualan::where('dibayar', '=', 0)->latest()->get();
        $penjualan->load('barang');
        if ($penjualan == []) {
            return $this->responseError('Data Penjualan yang belum dibayar tidak ada', 403);
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
        ]);

        if ($validator->fails()) {
            return $this->responseError('Barang gagal ditambah ke keranjang', 422, $validator->errors());
        }

        $barang = Barang::find($request->barang_id);
        $params = [
            'barang_id' => $request->barang_id,
            'jumlah_barang' => $request->jumlah_barang,
            'total_harga' => $barang->harga_jual * $request->jumlah_barang,
            'dibayar' => 0,
            'kembalian' => 0,
            'member_id' => null,
            'user_id' => 0
        ];

        if ($request->jumlah_barang > $barang->stok) {
            return $this->responseError('Stok barang sisa ' . $barang->stok);
        }
        $penjualan = Penjualan::create($params);
        $data['penjualan_id'] = $penjualan->id;
        DetailPenjualan::create($data);
        return $this->responseOk($penjualan->load('user'), 201, 'Barang berhasil ditambah ke keranjang');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penjualan = Penjualan::find($id);
        $penjualan->load('barang', 'member', 'user');
        return $this->responseOk($penjualan);
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
        ]);

        if ($validator->fails()) {
            return $this->responseError('Barang di keranjang gagal diupdate', 422, $validator->errors());
        }
        $penjualan = Penjualan::find($id);

        if ($penjualan->dibayar > 0) {
            return $this->responseError('Barang yang sudah dibayar tidak bisa di update atau ditukar');
        }
        $barang = Barang::find($request->barang_id ?? $penjualan->barang_id);
        $params = [
            'barang_id' => $request->barang_id ?? $penjualan->barang_id,
            'jumlah_barang' => $request->jumlah_barang ?? $penjualan->jumlah_barang,
            'dibayar' => 0,
            'kembalian' => 0,
            'member_id' => null,
            'user_id' => 0
        ];
        $params['total_harga'] = $barang->harga_jual * $params['jumlah_barang'];

        if ($params['jumlah_barang'] > $barang->stok) {
            return $this->responseError('Stok barang sisa ' . $barang->stok);
        }
        $penjualan->update($params);
        return $this->responseOk($penjualan, 200, 'Barang di keranjang berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan =  Penjualan::find($id);
        $detailpenjualan = DetailPenjualan::where('penjualan_id', $penjualan->id);

        if ($penjualan->dibayar > 0) {
            return $this->responseError('Barang yang sudah dibayar tidak bisa di hapus atau dikembalikan');
        }

        $detailpenjualan->delete();
        $penjualan->delete();

        return $this->responseOk($penjualan, 200, 'Barang di keranjang berhasil di hapus');
    }
}
