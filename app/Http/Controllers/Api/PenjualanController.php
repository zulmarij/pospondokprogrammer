<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
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
            return $this->responseError('Penjualan Kosong', 403);
        }
        return $this->responseOk($penjualan, 200, 'Sukses Liat Data Penjualan');
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
            'harga_total' => 'required|integer',
            'dibayar' => 'required|integer',
            'kembalian' => 'required|integer',
            'kode_member' => 'integer',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Buat Penjualan', 422, $validator->errors());
        }

        $params = [
            'barang_id' => $request->barang_id,
            'jumlah_barang' => $request->jumlah_barang,
            'harga_total' => $request->harga_total,
            'dibayar' => $request->dibayar,
            'kembalian' => $request->kembalian,
            'kode_member' => $request->kode_member ?? 0,
        ];

        $penjualan = Penjualan::create($params);
        return $this->responseOk($penjualan, 200, 'Sukses Buat Penjualan');
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
            'harga_total' => 'integer',
            'dibayar' => 'integer',
            'kembalian' => 'integer',
            'kode_member' => 'integer',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Ubah Penjualan', 422, $validator->errors());
        }

        $penjualan = Penjualan::find($id);

        $params = [
            'barang_id' => $request->barang_id ?? $penjualan->barang_id,
            'jumlah_barang' => $request->jumlah_barang ?? $penjualan->jumlah_barang,
            'harga_total' => $request->harga_total ?? $penjualan->harga_total,
            'dibayar' => $request->dibayar ?? $penjualan->dibayar,
            'kembalian' => $request->kembalian ?? $penjualan->kembalian,
            'kode_member' => $request->kode_member ?? $penjualan->kode_member,
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
