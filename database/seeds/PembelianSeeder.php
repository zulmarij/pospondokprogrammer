<?php

use App\Pembelian;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tanggal = Carbon::now('Asia/Jakarta');

        Pembelian::create([
            'supplier_id' => 1,
            'barang_id' => 3,
            'jumlah' => 5,
            'total_biaya' => 100000,
            'created_at' => $tanggal->subDay(30),
            'updated_at' => $tanggal->subDay(30)
        ]);

        Pembelian::create([
            'supplier_id' => 1,
            'barang_id' => 2,
            'jumlah' => 5,
            'total_biaya' => 95000,
            'created_at' => $tanggal->subDay(20),
            'updated_at' => $tanggal->subDay(20)
        ]);

        Pembelian::create([
            'supplier_id' => 1,
            'barang_id' => 1,
            'jumlah' => 5,
            'total_biaya' => 55000,
            'created_at' => $tanggal->subDay(10),
            'updated_at' => $tanggal->subDay(10)
        ]);
    }
}
