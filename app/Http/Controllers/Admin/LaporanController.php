<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Laporan;
use App\Pembelian;
use App\Pengeluaran;
use App\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $awal = Carbon::today('Asia/Jakarta')->subMonth(1)->format('Y-m-d');
        $akhir = Carbon::today('Asia/Jakarta')->format('Y-m-d');

        if (request('awal') && request('akhir')) {
            $awal = request('awal');
            $akhir = request('akhir');
        }

        $no = 0;
        $array = array();
        $pendapatan = 0;
        $total_pembelian = 0;
        $total_penjualan = 0;
        $total_pengeluaran = 0;
        $total_pendapatan = 0;
        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $pembelian  = Pembelian::where('created_at', 'LIKE', "$tanggal%")->sum('total_biaya');
            $dibayar = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('dibayar');
            $kembalian = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('kembalian');
            $pengeluaran = Pengeluaran::where('created_at', 'LIKE', "$tanggal%")->sum('biaya');
            $penjualan = $dibayar - $kembalian;
            $pendapatan = $penjualan - $pembelian  - $pengeluaran;

            $total_pembelian += $pembelian;
            $total_penjualan += $penjualan;
            $total_pengeluaran += $pengeluaran;
            $total_pendapatan += $pendapatan;

            $no ++;
            $array[] = [
                'no' => $no,
                'tanggal' =>  $tanggal,
                'penjualan' => $penjualan,
                'pembelian' =>$pembelian ,
                'pengeluaran' => $pengeluaran,
                'pendapatan' => $pendapatan
            ];
        }

        $data = [
            'category_name' => 'laporan',
            'page_name' => 'index_laporan',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'alt_menu' => 0,

        ];
        // dd($array);

        return view('admin.laporan.index', compact('array', 'total_pembelian', 'total_penjualan', 'total_pengeluaran', 'total_pendapatan'))->with($data);
    }

}
