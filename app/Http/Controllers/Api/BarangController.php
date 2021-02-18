<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends BaseController
{
    public function search($data)
    {

        $barang = Barang::with(['kategori'])
        ->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($data) . '%'])
        ->orWhereRaw('LOWER(merk) LIKE ?', ['%' . strtolower($data) . '%'])
        ->get();
        // $barang = Barang::where('nama', 'like', "%{$data}%")
            // ->orWhere('uid', 'like', "%{$data}%")
            // ->orWhere('harga_beli', 'like', "%{$data}%")
            // ->orWhere('harga_jual', 'like', "%{$data}%")
            // ->orWhere('kategori_id', 'like', "%{$data}%")
            // ->orWhere('merk', 'like', "%{$data}%")
            // ->orWhere('stok', 'like', "%{$data}%")
            // ->orWhere('diskon', 'like', "%{$data}%")
            // ->get();

        return $this->responseOk($barang);
    }
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
            return $this->responseError('Barang gagal ditambahkan', 422, $validator->errors());
        }

        $params = [
            'nama' => $request->nama,
            'uid' => $request->uid ?? rand(0, 9999999999),
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id,
            'merk' => $request->merk,
            'stok' => $request->stok,
            'diskon' => $request->diskon ?? 0,
        ];

        $barang = Barang::create($params);
        return $this->responseOk($barang, 201, 'Barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barang = Barang::find($id);

        return $this->responseOk($barang);
    }

    public function uid($uid)
    {
        $barang = Barang::where('uid', $uid)->get();

        return $this->responseOk($barang);
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
            'uid' => 'integer',
            'harga_beli' => 'integer',
            'harga_jual' => 'integer',
            'kategori_id' => 'integer',
            'merk' => 'string',
            'stok' => 'integer',
            'diskon' => 'integer'
        ]);

        if ($validator->fails()) {
            return $this->responseError('Barang gagal diupdate', 422, $validator->errors());
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
        return $this->responseOk($barang, 200, 'Barang berhasil diupdate');
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

        return $this->responseOk(null, 200, 'Barang berhasil dihapus');
    }
}
