<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::get();

        if (empty($supplier)) {
            return $this->responseError('Supplier Kosong', 403);
        }
        return $this->responseOk($supplier, 200, 'Sukses Liat Data Supplier');
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
            'alamat' => 'required',
            'no_hp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Buat Supplier', 422, $validator->errors());
        }

        $params = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ];

        $supplier = Supplier::create($params);
        return $this->responseOk($supplier, 200, 'Sukses Buat Supplier');
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
            'no_hp' => 'string',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Ubah Supplier', 422, $validator->errors());
        }

        $supplier = Supplier::find($id);

        $params = [
            'nama' => $request->nama ?? $supplier->nama,
            'alamat' => $request->alamat ?? $supplier->alamat,
            'no_hp' => $request->no_hp ?? $supplier->no_hp,
        ];

        $supplier->update($params);
        return $this->responseOk($supplier, 200, 'Sukses Ubah Supplier');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        return $this->responseOk(null, 200, 'Sukses Hapus Supplier');
    }
}
