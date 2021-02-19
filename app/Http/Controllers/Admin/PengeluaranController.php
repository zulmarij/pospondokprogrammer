<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluarans = Pengeluaran::get();

        $data = [
            'category_name' => 'pengeluaran',
            'page_name' => 'index_pengeluaran',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'alt_menu' => 0,
        ];

        if ($pengeluarans == []) {
            return back()->withToastError('Pengeluaran belum ada');
        }
        return view('admin.pengeluaran.index', compact('pengeluarans'))->with($data);
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
            'tipe' => 'required|string',
            'biaya' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return back()->withToastError($validator->messages()->all()[0])->withInput();
        }

        $params = [
            'tipe' => $request->tipe,
            'biaya' => $request->biaya,
        ];

        $pengeluaran = Pengeluaran::create($params);
        return back()->withToastSuccess('Pengeluaran Berhasil ditambah');
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
            'tipe' => 'string',
            'biaya' => 'integer',
        ]);

        if ($validator->fails()) {
            return back()->withToastError($validator->messages()->all()[0])->withInput();
        }

        $pengeluaran = Pengeluaran::find($id);

        $params = [
            'tipe' => $request->tipe ?? $pengeluaran->tipe,
            'biaya' => $request->biaya ?? $pengeluaran->biaya,
        ];

        $pengeluaran->update($params);
        return back()->withToastSuccess('Pengeluaran Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->delete();

        return back()->withToastSuccess('Pengeluaran Berhasil dihapus');
    }
}
