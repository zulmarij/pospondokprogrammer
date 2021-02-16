<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Pembelian;
use App\Pengeluaran;
use App\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends BaseController
{
    public function dailyReport()
    {
        $penjualanTanggal = Penjualan::whereDay('updated_at', date('d'))->get()->first();
        $penjualanTotalHarga = Penjualan::whereDay('updated_at', date('d'))->sum('total_harga');
        $pengeluaranBiaya = Pengeluaran::whereDay('updated_at', date('d'))->sum('biaya');
        $pembelianTotalBiaya = Pembelian::whereDay('updated_at', date('d'))->sum('total_biaya');

        $response = [
            'pemasukan' => $penjualanTotalHarga,
            'pengeluaran' => $pengeluaranBiaya + $pembelianTotalBiaya,
            'report' => [
                'date' => $penjualanTanggal->created_at,
                'penjualan' => $penjualanTotalHarga,
                'pembelian' => $pembelianTotalBiaya,
                'alokasi' => $pengeluaranBiaya,
            ]
        ];
        $response['saldo'] = $response['pemasukan'] - $response['pengeluaran'];
        return $this->responseOk($response, 200,'Data harian berhasil ditampilkan');
    }

    public function monthlyReport()
    {
        $penjualanTanggal = Penjualan::whereMonth('updated_at', date('m'))->get()->first();
        $penjualanTotalHarga = Penjualan::whereMonth('updated_at', date('m'))->sum('total_harga');
        $pengeluaranBiaya = Pengeluaran::whereMonth('updated_at', date('m'))->sum('biaya');
        $pembelianTotalBiaya = Pembelian::whereMonth('updated_at', date('m'))->sum('total_biaya');

        $response = [
            'pemasukan' => $penjualanTotalHarga,
            'pengeluaran' => $pengeluaranBiaya + $pembelianTotalBiaya,
            'report' => [
                'penjualan' => $penjualanTotalHarga,
                'pembelian' => $pembelianTotalBiaya,
                'alokasi' => $pengeluaranBiaya,
            ]
        ];
        $response['saldo'] = $response['pemasukan'] - $response['pengeluaran'];
        return $this->responseOk($response, 200,'Data bulanan berhasil ditampilkan');
    }
}
