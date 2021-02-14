<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use App\Http\Controllers\Api\BaseController;
use App\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembelianController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembelian = Pembelian::latest()->get();
        $pembelian->load('barang:id,nama','supplier:id,nama');
        if ($pembelian == []) {
            return $this->responseError('Pengeluaran belum ada');
        } else {
            return $this->responseOk($pembelian);
        }
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
            'barang_id' => 'required|integer',
            'jumlah' => 'required|integer',
            'total_biaya' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Pembelian gagal ditambah', 422, $validator->errors());
        }

        $params = [
            'supplier_id' => $request->supplier_id,
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'total_biaya' => $request->total_biaya,
        ];

        $pembelian = Pembelian::create($params);
        $barang = Barang::find($pembelian->barang_id);
        $data['stok'] = $barang->stok + $pembelian->jumlah;
        $data['harga_beli'] = $pembelian->total_biaya / $pembelian->jumlah;
        $barang->update($data);

        return $this->responseOk($pembelian->load('supplier', 'barang'), 201, 'Pembelian berhasil ditambah');
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
            'supplier_id' => 'integer',
            'barang_id' => 'integer',
            'jumlah' => 'integer',
            'total_biaya' => 'integer',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Pembelian gagal diubah', 422, $validator->errors());
        }

        $pembelian = Pembelian::find($id);
        $jumlahOld = $pembelian->jumlah;
        $barang_idOld = $pembelian->barang_id;
        $barangOld = Barang::find($barang_idOld);
        $stokOld = $barangOld->stok;

        $params = [
            'supplier_id' => $request->supplier_id ?? $pembelian->supplier_id,
            'barang_id' => $request->barang_id ?? $pembelian->barang_id,
            'jumlah' => $request->jumlah ?? $pembelian->jumlah,
            'total_biaya' => $request->total_biaya ?? $pembelian->total_biaya,
        ];

        if ($request->jumlah > $stokOld) {
            return $this->responseError('Pembelian gagal diubah karena barang sudah terjual');
        }

        $pembelian->update($params);
        $barang = Barang::find($pembelian->barang_id);

        if ($barang_idOld !== $pembelian->barang_id) {
            $dataOld['stok'] = $barangOld->stok - $jumlahOld;
            $barangOld->update($dataOld);

            $data['stok'] =  $barang->stok + $pembelian->jumlah;
            $data['harga_beli'] = $pembelian->total_biaya / $pembelian->jumlah;
            $barang->update($data);
        } else {
            $data['stok'] = $barang->stok - $jumlahOld + $pembelian->jumlah;
            $data['harga_beli'] = $pembelian->total_biaya / $pembelian->jumlah;
            $barang->update($data);
        }

        return $this->responseOk($pembelian->load('supplier', 'barang'), 200, 'Pembelian berhasil diubah');
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
        $barang = Barang::find($pembelian->barang_id);
        if ($barang->stok < $pembelian->jumlah) {
            return $this->responseError('Pembelian gagal dihapus karena barang sudah terjual');
        } else {
            $data['stok'] = $barang->stok - $pembelian->jumlah;
            $barang->update($data);
            $pembelian->delete();
        }

        return $this->responseOk(null, 200, 'Pembelian berhasil dihapus');
    }
}
