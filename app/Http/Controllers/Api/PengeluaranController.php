<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengeluaran = Pengeluaran::get();

        if (empty($pengeluaran)) {
            return $this->responseError('Pengeluaran Kosong', 403);
        }
        return $this->responseOk($pengeluaran, 200, 'Sukses Liat Data Pengeluaran');
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
            'jenis_pengeluaran' => 'required|string',
            'nominal' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Buat Pengeluaran', 422, $validator->errors());
        }

        $params = [
            'jenis_pengeluaran' => $request->jenis_pengeluaran,
            'nominal' => $request->nominal,
        ];

        $pengeluaran = Pengeluaran::create($params);
        return $this->responseOk($pengeluaran, 200, 'Sukses Buat Pengeluaran');
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
            'jenis_pengeluaran' => 'string',
            'nominal' => 'integer',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Ubah Pengeluaran', 422, $validator->errors());
        }

        $pengeluaran = Pengeluaran::find($id);

        $params = [
            'jenis_pengeluaran' => $request->jenis_pengeluaran ?? $pengeluaran->jenis_pengeluaran,
            'nominal' => $request->nominal ?? $pengeluaran->nominal,
        ];

        $pengeluaran->update($params);
        return $this->responseOk($pengeluaran, 200, 'Sukses Ubah Pengeluaran');
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

        return $this->responseOk(null, 200, 'Sukses Hapus Pengeluaran');
    }
}
