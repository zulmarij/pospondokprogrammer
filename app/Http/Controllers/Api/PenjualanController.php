<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use App\Member;
use App\Penjualan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = Penjualan::latest()->get();
        if ($penjualan == []) {
            return $this->responseError('Penjualan belum ada', 403);
        }
        return $this->responseOk($penjualan);
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
            'barang_id' => 'required|integer',
            'jumlah_barang' => 'required|integer',
            'dibayar' => 'integer',
            'member_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Penjualan gagal ditambah', 422, $validator->errors());
        }

        $user = User::find(Auth::user()->id);
        $barang = Barang::find($request->barang_id);
        $member = Member::find($request->member_id);
        $params = [
            'barang_id' => $request->barang_id,
            'jumlah_barang' => $request->jumlah_barang,
            'total_harga' => $barang->harga_jual * $request->jumlah_barang,
            'dibayar' => $request->dibayar,
            'kembalian' => $request->dibayar - $barang->harga_jual * $request->jumlah_barang,
            'member_id' => $request->member_id,
            'user_id' => $user->id
        ];

        if ($request->has('dibayar') && $request->dibayar == null) {
            return $this->responseError('Bayaran tidak ada (Gunakan saldo member jika ada dan cukup)');
        } elseif ($request->jumlah_barang > $barang->stok) {
            return $this->responseError('Stok barang sisa ' . $barang->stok);
        } elseif ($request->has('dibayar') && $params['dibayar'] < $params['total_harga']) {
            return $this->responseError('Bayaran kurang ' . $params['kembalian']);
        } elseif ($request->has('member_id') && $member == null) {
            return $this->responseError('Member ID ' . $request->member_id . ' tidak ada');
        } elseif ($request->has('member_id') && $params['total_harga'] > $member->saldo) {
            return $this->responseError('Saldo member tidak cukup');
        } elseif ($request->has('member_id')) {
            $saldomember['saldo'] = $member->saldo - ($params['total_harga'] - $barang->diskon);
            $member->update($saldomember);
            $params['kembalian'] = 0;
            $params['dibayar'] = $params['total_harga'] - $barang->diskon;
            $penjualan = Penjualan::create($params);
            $data['stok'] = $barang->stok - $penjualan->jumlah_barang;
            $barang->update($data);
            return $this->responseOk($penjualan->load('member', 'user'), 201, 'Penjualan dengan diskon ' . $barang->diskon . ' berhasil ditambah');
        } else {
            $penjualan = Penjualan::create($params);
            $data['stok'] = $barang->stok - $penjualan->jumlah_barang;
            $barang->update($data);
            return $this->responseOk($penjualan->load('member', 'user'), 201, 'Penjualan berhasil ditambah');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penjualan = Penjualan::find($id);
        $penjualan->load('member', 'user');
        return $this->responseOk($penjualan);
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
            'barang_id' => 'integer',
            'jumlah_barang' => 'integer',
            'dibayar' => 'integer',
            'member_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Penjualan gagal ditambah', 422, $validator->errors());
        }

        $penjualanOld = Penjualan::find($id);
        $userOld = User::find($penjualanOld->user_id);
        $barangOld = Barang::find($penjualanOld->barang_id);
        $memberOld = Member::find($penjualanOld->member_id);

        $penjualan = new Penjualan;
        $barang = Barang::find($request->barang_id);
        $member = Member::find($request->member_id);

        $params = [
            'barang_id' => $request->barang_id ?? $penjualanOld->barang_id,
            'jumlah_barang' => $request->jumlah_barang ?? $penjualanOld->jumlah_barang,
            'dibayar' => $request->dibayar ?? $penjualanOld->dibayar,
            'kembalian' => $request->dibayar - $barang->harga_jual * $request->jumlah_barang,
            'member_id' => $request->member_id ?? $penjualanOld->member_id,
            'user_id' => $userOld->id
        ];
        $params['total_harga'] = $params['jumlah_barang'] * ($barang->harga_jual ?? $barangOld->harga_jual);
        if ($request->has('dibayar') && $request->dibayar == null) {
            return $this->responseError('Bayaran tidak ada (Gunakan saldo member jika ada dan cukup)');
            // } elseif ($params['dibayar'] ==  $penjualanOld->dibayar < ) {
            //     return $this->responseError('Bayaran tidak ada (Gunakan saldo member jika ada dan cukup)');
        } elseif ($params['jumlah_barang'] == $penjualanOld->barang_id > $barangOld->stok) {
            return $this->responseError('Stok barang sisa ' . $barangOld->stok);
        } elseif ($request->jumlah_barang > $barang->stok) {
            return $this->responseError('Stok barang sisa ' . $barang->stok);
        } elseif ($request->has('dibayar') && $params['dibayar'] < $params['total_harga'] || $params['dibayar'] == $penjualanOld->dibayar < $params['total_harga']) {
            return $this->responseError('Bayaran kurang ' . $params['kembalian']);
        } elseif ($request->has('member_id') && $member == null) {
            return $this->responseError('Member ID ' . $request->member_id . ' tidak ada');
        } elseif ($request->has('member_id') && $params['total_harga'] > $member->saldo || $params['member_id'] == $penjualanOld->member_id && $params['total_harga'] > $member->saldo) {
            return $this->responseError('Saldo member tidak cukup');
        } elseif ($request->has('member_id') !== $penjualanOld->member_id) {
            $saldomemberOld['saldo'] = $memberOld->saldo + $penjualanOld->dibayar;
            $memberOld->update($saldomemberOld);
            $stokOld['stok'] = $barangOld->stok + $penjualanOld->jumlah_barang;
            $barangOld->update($stokOld);

            $saldomember['saldo'] = $member->saldo - ($params['total_harga'] - $barang->diskon);
            $member->update($saldomember);
            $params['kembalian'] = 0;
            $params['dibayar'] = $params['total_harga'] - $barang->diskon;
            $penjualan->update($params);
            $data['stok'] = $barang->stok - $penjualan->jumlah_barang;
            $barang->update($data);
            return $this->responseOk($penjualan->load('member', 'user'), 200, 'Penjualan dengan diskon ' . $barang->diskon . ' berhasil diupdate');
        } else {
            $penjualan = Penjualan::create($params);
            $data['stok'] = $barang->stok - $penjualan->jumlah_barang;
            $barang->update($data);
            return $this->responseOk($penjualan->load('member', 'user'), 201, 'Penjualan berhasil ditambah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        $penjualan->delete();

        return $this->responseOk(null, 200, 'Sukses Hapus Penjualan');
    }
}
