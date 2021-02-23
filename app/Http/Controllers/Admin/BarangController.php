<?php

namespace App\Http\Controllers\Admin;

use App\Barang;
use App\Http\Controllers\Controller;
use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::get();
        $kategoris = Kategori::get();

        $total_barang = Barang::count();
        $total_stok = Barang::sum('stok');
        $total_harga_jual = Barang::sum('harga_jual');
        $total_harga_beli = Barang::sum('harga_beli');
        $data = [
            'category_name' => 'barang',
            'page_name' => 'index_barang',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'alt_menu' => 0,

        ];
        return view('admin.barang.index', compact('barangs', 'kategoris', 'total_barang', 'total_stok', 'total_harga_jual', 'total_harga_beli'))->with($data);
    }

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
            return back()->withToastError($validator->messages()->all()[0])->withInput();
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

         return back()->withToastSuccess('Barang Berhasil tambah');
    }

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
            return back()->withToastError($validator->messages()->all()[0])->withInput();
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

         return back()->withToastSuccess('Barang Berhasil diubah');

    }

    public function destroy($id)
    {
        $barang = Barang::find($id);
        $barang->delete();

         return back()->withToastSuccess('Barang Berhasil diubah');
    }

}
