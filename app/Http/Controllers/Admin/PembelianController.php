<?php

namespace App\Http\Controllers\Admin;

use App\Barang;
use App\Http\Controllers\Controller;
use App\Pembelian;
use App\Supplier;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::get();
        $suppliers = Supplier::get();
        $barangs = Barang::get();

        $total_pembelian = Pembelian::count();
        $total_barang = Pembelian::sum('jumlah');
        $total_biaya = Pembelian::sum('total_biaya');
        $data = [
            'category_name' => 'pembelian',
            'page_name' => 'index_pembelian',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'alt_menu' => 0,
        ];
        // $pembelian->load('barang','supplier');
        // if ($pembelian == []) {
        //     return back()->withToastError('Pembelian belum ada');
        // } else {
            return view('admin.pembelian.index', compact('pembelians','suppliers','barangs', 'total_pembelian', 'total_barang', 'total_biaya'))->with($data);
        // }
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
            return back()->withToastError($validator->messages()->all()[0])->withInput();
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
        $data['harga_jual'] = $data['harga_beli'] + ($data['harga_beli'] * 20 / 100);
        $barang->update($data);

        return back()->withToastSuccess('Pembelian Berhasil ditambah');
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
            return back()->withToastError($validator->messages()->all()[0])->withInput();
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
            return back()->withToastError('Pembelian gagal diubah karena barang sudah terjual');
        }

        $pembelian->update($params);
        $barang = Barang::find($pembelian->barang_id);

        if ($barang_idOld !== $pembelian->barang_id) {
            $dataOld['stok'] = $barangOld->stok - $jumlahOld;
            $barangOld->update($dataOld);

            $data['stok'] =  $barang->stok + $pembelian->jumlah;
            $data['harga_beli'] = $pembelian->total_biaya / $pembelian->jumlah;
            $data['harga_jual'] = $data['harga_beli'] + ($data['harga_beli'] * 20 / 100);
            $barang->update($data);
        } else {
            $data['stok'] = $barang->stok - $jumlahOld + $pembelian->jumlah;
            $data['harga_beli'] = $pembelian->total_biaya / $pembelian->jumlah;
            $data['harga_jual'] = $data['harga_beli'] + ($data['harga_beli'] * 20 / 100);
            $barang->update($data);
        }

        return back()->withToastSuccess('Pembelian Berhasil diubah');
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
            return back()->withToastError('Pembelian gagal dihapus karena barang sudah terjual');
        } else {
            $data['stok'] = $barang->stok - $pembelian->jumlah;
            $barang->update($data);
            $pembelian->delete();
        }

        return back()->withToastSuccess('Pembelian Berhasil dihapus');
    }
}
