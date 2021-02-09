<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::get();
        $barang->load('kategori');

        if (empty($barang)) {
            return $this->responseError('Barang Kosong', 403);
        }
        return $this->responseOk($barang, 200, 'Sukses Liat Data Barang');
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
            'uid' => 'integer|unique:barangs',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'kategori_id' => 'required|integer',
            'merk' => 'required|string',
            'stok' => 'required|integer',
            'diskon' => 'integer'
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Buat Barang', 422, $validator->errors());
        }

        $params = [
            'nama' => $request->nama,
            'uid' => $request->uid ?? rand(0,9999999999),
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id,
            'merk' => $request->merk,
            'stok' => $request->stok,
            'diskon' => $request->diskon ?? 0,
        ];

        $barang = Barang::create($params);
        return $this->responseOk($barang, 200, 'Sukses Buat Barang');
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
            'uid' => 'integer|unique:barangs',
            'harga_beli' => 'integer',
            'harga_jual' => 'integer',
            'kategori_id' => 'integer',
            'merk' => 'string',
            'stok' => 'integer',
            'diskon' => 'integer'
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Buat Barang', 422, $validator->errors());
        }

        $barang = Barang::find($id);

        $params = [
            'nama' => $request->nama ?? $barang->nama,
            'uid' => $request->uid ?? $barang->uid,
            'harga_beli' => $request->harga_beli ?? $barang->harga_beli,
            'harga_jual' => $request->harga_jual ?? $barang->harga_jual,
            'kategori_id' => $request->kategori_id ?? $barang->kategori_id,
            'merk' => $request->merk ?? $barang->merk,
            'stok' => $request->stok ?? $barang->stok,
            'diskon' => $request->diskon ?? $barang->diskon,
        ];

        $barang->update($params);
        return $this->responseOk($barang, 200, 'Sukses Buat Barang');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::find($id);
        $barang->delete();

        return $this->responseOk(null, 200, 'Sukses Hapus Barang');
    }
}
