<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::get();
        $total_supplier = Supplier::count();
        $data = [
            'category_name' => 'supplier',
            'page_name' => 'index_supplier',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'alt_menu' => 0,

        ];
        return view('admin.supplier.index', compact('suppliers', 'total_supplier'))->with($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'alamat' => 'required',
            'no_hp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withToastError($validator->messages()->all()[0])->withInput();
        }

        $params = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ];

        Supplier::create($params);

        return back()->withToastSuccess('Supplier Berhasil ditambah');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'string',
            'no_hp' => 'string',
        ]);

        if ($validator->fails()) {
            return back()->withToastError($validator->messages()->all()[0])->withInput();
        }

        $supplier = Supplier::find($id);
        $params = [
            'nama' => $request->nama ?? $supplier->nama,
            'alamat' => $request->alamat ?? $supplier->alamat,
            'no_hp' => $request->no_hp ?? $supplier->no_hp,
        ];

        $supplier->update($params);
        return back()->withToastSuccess('Supplier Berhasil diubah');
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        return back()->withToastSuccess('Supplier Berhasil dihapus');
    }
}
