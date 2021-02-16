<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use App\DetailPenjualan;
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
        $penjualan->load('barang', 'member');
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
            // 'dibayar' => 'integer',
            // 'member_id' => 'integer',
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
            'dibayar' => 0,
            'kembalian' => 0,
            'member_id' => null,
            'user_id' => 0
        ];

        // if ($params['dibayar'] && $params['member_id'] !== null) {
        //     return $this->responseError('Pilih salah satu!! mau bayar langsung atau memnggunakan saldo member jika ada');
        // } elseif ($request->has('dibayar') && $request->dibayar == null) {
        //     return $this->responseError('Bayaran tidak ada (Gunakan saldo member jika ada dan cukup)');
        // } elseif ($request->jumlah_barang > $barang->stok) {
        //     return $this->responseError('Stok barang sisa ' . $barang->stok);
        // } elseif ($request->has('dibayar') && $params['dibayar'] < $params['total_harga']) {
        //     return $this->responseError('Bayaran kurang ' . $params['kembalian']);
        // } elseif ($request->has('member_id') && $member == null) {
        //     return $this->responseError('Member ID ' . $request->member_id . ' tidak ada');
        // } elseif ($request->has('member_id') && $params['total_harga'] > $member->saldo) {
        //     return $this->responseError('Saldo member ' . $member->saldo . ' tidak cukup');
        // } elseif ($request->has('member_id')) {
        //     $saldomember['saldo'] = $member->saldo - ($params['total_harga'] - $barang->diskon);
        //     $member->update($saldomember);
        // $params['kembalian'] = 0;
        // $params['dibayar'] = $params['total_harga'] - ($barang->diskon * $params['jumlah_barang']);
        // $penjualan = Penjualan::create($params);
        //     $data['stok'] = $barang->stok - $penjualan->jumlah_barang;
        //     //     $barang->update($data);
        //     $data['penjualan_id'] = $penjualan->id;
        //     DetailPenjualan::create($data);
        //     return $this->responseOk($penjualan->load('member', 'user'), 201, 'Penjualan dengan diskon ' . $barang->diskon * $params['jumlah_barang'] . ' berhasil ditambah');
        // } else {
        // $data['stok'] = $barang->stok - $penjualan->jumlah_barang;
        // $barang->update($data);

        if ($request->jumlah_barang > $barang->stok) {
            return $this->responseError('Stok barang sisa ' . $barang->stok);
        }
        $penjualan = Penjualan::create($params);
        $data['penjualan_id'] = $penjualan->id;
        DetailPenjualan::create($data);
        return $this->responseOk($penjualan->load('user'), 201, 'Penjualan berhasil ditambah ke detail penjualan');
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
            return $this->responseError('Penjualan gagal diupdate', 422, $validator->errors());
        }

        $penjualan = Penjualan::find($id);
        $user = User::find(Auth::user()->id);
        $barangOld = Barang::find($penjualan->barang_id);
        $memberOld = Member::find($penjualan->member_id);

        $params = [
            'barang_id' => $request->barang_id ?? $penjualan->barang_id,
            'jumlah_barang' => $request->jumlah_barang ?? $penjualan->jumlah_barang,
            'dibayar' => $request->dibayar ?? $penjualan->dibayar,
            'member_id' => $request->member_id ?? $penjualan->member_id,
            'user_id' => $user->id
        ];
        $barang = Barang::find($params['barang_id']);
        $member = Member::find($params['member_id']);

        $params['total_harga'] = $params['jumlah_barang'] * $barang->harga_jual;
        $params['kembalian'] = $params['dibayar'] - ($barang->harga_jual * $params['jumlah_barang']);

        if ($request->has('dibayar') && $request->has('member_id') != null) {
            return $this->responseError('Pilih salah satu!! mau bayar langsung atau memnggunakan saldo member jika ada');
        } elseif ($request->has('dibayar') && $params['dibayar'] == null) {
            return $this->responseError('Bayaran tidak ada (Gunakan saldo member jika ada dan cukup)');
        } elseif ($params['jumlah_barang'] > $barang->stok) {
            return $this->responseError('Stok barang sisa ' . $barang->stok);
        } elseif ($request->has('dibayar') && $params['dibayar'] < $params['total_harga']) {
            return $this->responseError('Bayaran kurang ' . $params['kembalian']);
        } elseif ($request->has('member_id') && $member == null) {
            return $this->responseError('Member ID ' . $params['member_id'] . ' tidak ada');
        } elseif ($request->has('member_id') && $params['total_harga'] > $member->saldo) {
            return $this->responseError('Saldo member ' . $member->saldo . ' tidak cukup');
        } elseif ($request->has('member_id') || $params['member_id'] !== null) {
            $saldomemberOld['saldo'] = $memberOld->saldo + $penjualan->dibayar;
            $member->update($saldomemberOld);
            $stokOld['stok'] = $barangOld->stok + $penjualan->jumlah_barang;
            $barang->update($stokOld);

            $saldomember['saldo'] = $member->saldo - ($params['total_harga'] - $barang->diskon);
            $member->update($saldomember);
            $params['kembalian'] = 0;
            $params['dibayar'] = $params['total_harga'] - $barang->diskon;
            $penjualan->update($params);
            $data['stok'] = $barang->stok - $penjualan->jumlah_barang;
            $barang->update($data);
            return $this->responseOk($penjualan->load('member', 'user'), 200, 'Penjualan dengan diskon ' . $barang->diskon . ' berhasil diupdate');
        } else {
            $stokOld['stok'] = $barangOld->stok + $penjualan->jumlah_barang;
            $barang->update($stokOld);

            $penjualan->update($params);
            $data['stok'] = $barang->stok - $penjualan->jumlah_barang;
            $barang->update($data);
            return $this->responseOk($penjualan->load('member', 'user'), 200, 'Penjualan berhasil di update');
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
        $penjualan =  Penjualan::find($id);
        $user = User::find(Auth::user()->id);
        $barang = Barang::find($penjualan->barang_id);
        $member = Member::find($penjualan->member_id);

        if ($penjualan->member_id == null) {
            $stok['stok'] = $barang->stok + $penjualan->jumlah_barang;
            $barang->update($stok);
            $penjualan->delete();
            return $this->responseOk(null, 200, 'Penjualan berhasil dihapus. stok barang ' . $stok['stok'] . ' dikembalikan');
        } else {
            $saldomember['saldo'] = $member->saldo + $penjualan->dibayar;
            $member->update($saldomember);
            $stok['stok'] = $barang->stok + $penjualan->jumlah_barang;
            $barang->update($stok);
            $penjualan->delete();
            return $this->responseOk(null, 200, 'Penjualan berhasil dihapus. stok barang ' . $stok['stok'] . ' dan ' . 'saldo member ' . $saldomember['saldo'] . ' dikembalikan');
        }

        $penjualan->delete();
    }
}
