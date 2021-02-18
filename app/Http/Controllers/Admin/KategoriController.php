<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::get();
        $data = [
            'category_name' => 'kategori',
            'page_name' => 'index_kategori',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'alt_menu' => 0,

        ];
        return view('admin.kategori.index', compact('kategoris'))->with($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $params = [
            'nama' => $request->nama,
        ];

        Kategori::create($params);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'string',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $kategori = Kategori::find($id);
        $params = [
            'nama' => $request->nama ?? $kategori->nama,
        ];

        $kategori->update($params);
        return redirect()->back();
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();

        return redirect()->back();
    }
}
