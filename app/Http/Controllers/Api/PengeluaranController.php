<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengeluaran = Pengeluaran::get();

        if ($pengeluaran == []) {
            return $this->responseError('Pengeluaran belum ada');
        }else {
            return $this->responseOk($pengeluaran);
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
            'tipe' => 'required|string',
            'biaya' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Pengeluaran gagal ditambah', 422, $validator->errors());
        }

        $params = [
            'tipe' => $request->tipe,
            'biaya' => $request->biaya,
        ];

        $pengeluaran = Pengeluaran::create($params);
        return $this->responseOk($pengeluaran, 201, 'Pengeluaran berhasil ditambah');
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
            return $this->responseError('Pengeluaran gagal diupdate', 422, $validator->errors());
        }

        $pengeluaran = Pengeluaran::find($id);

        $params = [
            'tipe' => $request->tipe ?? $pengeluaran->tipe,
            'biaya' => $request->biaya ?? $pengeluaran->biaya,
        ];

        $pengeluaran->update($params);
        return $this->responseOk($pengeluaran, 200, 'Pengeluaran berhasil diupdate');
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

        return $this->responseOk(null, 200, 'Pengeluaran berhasil dihapus');
    }
}
