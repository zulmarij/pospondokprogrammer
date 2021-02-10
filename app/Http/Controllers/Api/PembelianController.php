<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembelian = Pembelian::get();

        if (empty($pembelian)) {
            return $this->responseError('Pembelian Kosong', 403);
        }
        return $this->responseOk($pembelian, 200, 'Sukses Liat Data Pembelian');
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
            'supplier_id' => 'required|integer',
            'barang' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Buat Pembelian', 422, $validator->errors());
        }

        $params = [
            'supplier_id' => $request->supplier_id,
            'barang' => $request->barang,
        ];

        $pembelian = Pembelian::create($params);
        return $this->responseOk($pembelian, 200, 'Sukses Buat Pembelian');
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
            'supplier_id' => 'string',
            'barang' => 'string',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Ubah Pembelian', 422, $validator->errors());
        }

        $pembelian = Pembelian::find($id);

        $params = [
            'supplier_id' => $request->supplier_id ?? $pembelian->supplier_id,
            'barang' => $request->barang ?? $pembelian->barang,
        ];

        $pembelian->update($params);
        return $this->responseOk($pembelian, 200, 'Sukses Ubah Pembelian');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);
        $pembelian->delete();

        return $this->responseOk(null, 200, 'Sukses Hapus Pembelian');
    }
}
