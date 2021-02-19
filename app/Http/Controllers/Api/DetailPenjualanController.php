<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use App\DetailPenjualan;
use App\Http\Controllers\Api\BaseController;
use App\Member;
use App\Penjualan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailPenjualanController extends BaseController
{
    public function request()
    {
        $detailPenjualan = DetailPenjualan::with('penjualan')->where('status', 0)->get();
        $array = array();
        foreach ($detailPenjualan as $data) {
            $array[] = [
                'id' => $data->id,
                'uid' => $data->penjualan->barang->uid,
                'nama' => $data->penjualan->barang->nama,
                'jumlah_barang' => $data->penjualan->jumlah_barang,
                'total_harga' => $data->penjualan->total_harga

            ];
        }

        if ($array == []) {
            return $this->responseError('Data request barang kosong');
        }
        return $this->responseOk($array, 200, 'Barang yang di request');
    }

    public function dibeli()
    {
        $detailPenjualan = DetailPenjualan::with('penjualan')->where('status', 1)->get();
        $array = array();
        foreach ($detailPenjualan as $data) {
            $array[] = [
                'id' => $data->id,
                'uid' => $data->penjualan->barang->uid,
                'nama' => $data->penjualan->barang->nama,
                'jumlah_barang' => $data->penjualan->jumlah_barang,
                'total_harga' => $data->penjualan->total_harga

            ];
        }

        if ($array == []) {
            return $this->responseError('Data barang yang sudah dibeli atau dikonfirmasi kosong');
        }
        return $this->responseOk($array, 200, 'Data barang sudah yang dibeli atau dikonfirmasi');
    }

    public function confirm(Request $request)
    {
        $getdetailPenjualan = DetailPenjualan::where('status', 0)->get()->load('penjualan');

        $total_item = 0;
        $total_barang = 0;
        $total_harga = 0;
        $total_diskon = 0;
        $dibayar = request('dibayar');
        $array = array();
        foreach ($getdetailPenjualan as $data) {
            $total_item += 1;
            $total_barang += $data->penjualan->jumlah_barang;
            $total_harga += $data->penjualan->total_harga;
            $total_diskon += $data->penjualan->barang->diskon;

            $array[] = [
                'id' => $data->id,
                'uid' => $data->penjualan->barang->uid,
                'nama' => $data->penjualan->barang->nama,
                'jumlah' => $data->penjualan->jumlah_barang,
                'harga' => $data->penjualan->total_harga,
                // 'diskon' => $data->penjualan->barang->diskon,
                'tanggal' => $data->penjualan->created_at,

            ];
        }
        // dd($array);
        $user = User::find(Auth::user()->id);
        $member = Member::where('user_id', request('member_id'))->first();

        if ($array == []) {
            return $this->responseError('Data request barang kosong');
        } elseif ($request->has('member_id') && $request->has('dibayar')) {
            return $this->responseError('Pilih salah satu!! mau bayar langsung atau memnggunakan saldo member jika ada');
        } elseif (request('member_id') == null && request('dibayar') == null) {
            return $this->responseError('Tidak ada pembayaran!!');
        } elseif ($request->has('dibayar') && request('dibayar') < $total_harga) {
            $kurang = $total_harga - request('dibayar');
            return $this->responseError('Bayaran kurang ' . $kurang);
        } elseif ($request->has('member_id') && $member == null) {
            return $this->responseError('Member dengan id ' . request('member_id') . ' tidak ditemukan');
        } elseif ($request->has('member_id') && $member->saldo < ($total_harga - $total_diskon)) {
            $kurang = ($total_harga - $total_diskon) - $member->saldo;
            return $this->responseError('Bayaran kurang ' . $kurang);
        } elseif ($request->has('member_id')) {
            foreach ($getdetailPenjualan as $data) {
                $detailpenjualan = DetailPenjualan::find($data->id);
                $penjualan = Penjualan::find($data->penjualan_id);
                $barang = Barang::find($penjualan->barang_id);
                $member = Member::where('user_id', request('member_id'))->first();

                $bayarpenjualan['dibayar'] = $penjualan->total_harga - ($barang->diskon * $penjualan->jumlah_barang);
                $bayarpenjualan['member_id'] = request('member_id');
                $bayarpenjualan['user_id'] = $user->id;
                $penjualan->update($bayarpenjualan);

                $saldomember['saldo'] = $member->saldo - $bayarpenjualan['dibayar'];
                $member->update($saldomember);

                $stokbarang['stok'] = $barang->stok - $penjualan->jumlah_barang;
                $barang->update($stokbarang);

                $statusdetailpenjualan['status'] = 1;
                $detailpenjualan->update($statusdetailpenjualan);

                $response = [
                    'total_item' => $total_item,
                    'total_barang' => $total_barang,
                    'total_harga' => $total_harga,
                    'total_diskon' => $total_diskon,
                    'dibayar' => $total_harga - $total_diskon,
                    'kembalian' => 0,
                    'member' => $member->user->nama,
                    'kasir' => $user->nama,
                    'data' => $array,
                ];
                // return $this->responseOk($response, 200, 'Barang berhasil dibeli');
            }
        } else {
            foreach ($getdetailPenjualan as $data) {
                $detailpenjualan = DetailPenjualan::find($data->id);
                $penjualan = Penjualan::find($data->penjualan_id);
                $barang = Barang::find($penjualan->barang_id);


                $bayarpenjualan['dibayar'] = $dibayar;
                $bayarpenjualan['kembalian'] = $bayarpenjualan['dibayar'] - $data->penjualan->total_harga;
                $bayarpenjualan['user_id'] = $user->id;
                $penjualan->update($bayarpenjualan);


                $stokbarang['stok'] = $barang->stok - $penjualan->jumlah_barang;
                $barang->update($stokbarang);

                $statusdetailpenjualan['status'] = 1;
                $detailpenjualan->update($statusdetailpenjualan);

                $response = [
                    'total_item' => $total_item,
                    'total_barang' => $total_barang,
                    'total_harga' => $total_harga,
                    'total_diskon' => 0,
                    'dibayar' => request('dibayar'),
                    'kembalian' => request('dibayar') - $total_harga,
                    'member' => null,
                    'kasir' => $user->nama,
                    'data' => $array,
                ];
                // return $this->responseOk($response, 200, 'Barang berhasil dibeli');
            }
        }

        // $response = [
        //     'total_item' => $total_item,
        //     'total_barang' => $total_barang,
        //     'total_harga' => $total_harga,
        //     'total_diskon' => $total_diskon,
        //     'data' => $array,
        // ];
        return $this->responseOk($response, 200, 'Barang berhasil dibeli');
    }
}
