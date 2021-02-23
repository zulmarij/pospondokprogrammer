<?php

use App\Penjualan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tanggal = Carbon::now('Asia/Jakarta');

        Penjualan::create([
            'barang_id' => 1,
            'jumlah_barang' => 5,
            'total_harga' => 75000,
            'dibayar' => 100000,
            'kembalian' => 25000,
            'member_id' => null,
            'user_id' => 3,
            'created_at' => $tanggal->subDay(3),
            'updated_at' => $tanggal->subDay(3)
        ]);

        Penjualan::create([
            'barang_id' => 2,
            'jumlah_barang' => 5,
            'total_harga' => 120000,
            'dibayar' => 150000,
            'kembalian' => 30000,
            'member_id' => 1,
            'user_id' => 3,
            'created_at' => $tanggal->subDay(2),
            'updated_at' => $tanggal->subDay(2)
        ]);

        Penjualan::create([
            'barang_id' => 3,
            'jumlah_barang' => 5,
            'total_harga' => 115000,
            'dibayar' => 0,
            'kembalian' => 0,
            'member_id' => null,
            'user_id' => 0,
            'created_at' => $tanggal->subDay(1),
            'updated_at' => $tanggal->subDay(1)
        ]);
    }
}
