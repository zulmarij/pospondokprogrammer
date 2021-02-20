<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pembelian;
use App\Pengeluaran;
use App\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $start = Carbon::now()->subDays(30);
        $end = Carbon::now();
        $penjualans = Penjualan::select("*")
        ->whereBetween('created_at', [$start, $end])
        ->get();
        $pengeluarans = Pengeluaran::select("*")
        ->whereBetween('created_at', [$start, $end])
        ->get();
        $pembelians = Pembelian::select("*")
        ->whereBetween('created_at', [$start, $end])
        ->get();
        // $absents = Absent::select("*")
        //     ->whereBetween('created_at', [$start, $end])
        //     ->get();

        $data = [
            'category_name' => 'absent',
            'page_name' => 'index_absent',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'alt_menu' => 0,

        ];
        return view('admin.absent.index', compact('absents'))->with($data);
    }
}
