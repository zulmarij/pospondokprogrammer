<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $pembelians = DB::table('pembelians')
        ->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_biaya) as total_biaya')

        )
        ->groupBy('year', 'month')
        ->whereYear('created_at', '=', Carbon::now()->year)
        ->groupBy('year', 'month')
        ->get();

        $penjualans = DB::table('penjualans')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(dibayar) as dibayar'),
                DB::raw('SUM(kembalian) as kembalian')

            )
            ->groupBy('year', 'month')
            ->whereYear('created_at', '=', Carbon::now()->year)
            ->groupBy('year', 'month')
            ->get();

            $pengeluarans = DB::table('pengeluarans')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(biaya) as biaya')

            )
            ->groupBy('year', 'month')
            ->whereYear('created_at', '=', Carbon::now()->year)
            ->groupBy('year', 'month')
            ->get();

            // dd(json_encode($pembelians));
            $profit1 = 0;
            $profit2 = 0;
            $profit3 = 0;

            foreach ($pembelians as $pembelian) {
                $total_biaya[] = $pembelian->total_biaya;
                $profit1 += $pembelian->total_biaya;
            }

            foreach ($penjualans as $penjualan) {
                $income[] = $penjualan->dibayar - $penjualan->kembalian;
                $profit2 += $penjualan->dibayar - $penjualan->kembalian;
            }

            foreach ($pengeluarans as $pengeluaran) {
                $biaya[] = $pengeluaran->biaya;
                $profit3 += $pengeluaran->biaya;
            }

            $profit = $profit2 - ($profit3 + $profit1);;

            $expenses[] = $total_biaya + $biaya;
            $array = [
                'biaya' => $biaya,
                'total_biaya' => $total_biaya,
                'expenses' => $expenses,
            ];

            dd($array);

        $data = [
            'category_name' => 'dashboard',
            'page_name' => 'admin',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'alt_menu' => 0,
        ];

        return view('dashboard2', compact('income','expenses', 'profit'))->with($data);
    }
}
