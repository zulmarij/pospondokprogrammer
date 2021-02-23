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
            'created_at' => $tanggal->subDay(3),
            'updated_at' => $tanggal->subDay(3)
        ]);

        Pembelian::create([
            'supplier_id' => 1,
            'barang_id' => 2,
            'jumlah' => 5,
            'total_biaya' => 95000,
            'created_at' => $tanggal->subDay(2),
            'updated_at' => $tanggal->subDay(2)
        ]);

        Pembelian::create([
            'supplier_id' => 1,
            'barang_id' => 1,
            'jumlah' => 5,
            'total_biaya' => 55000,
            'created_at' => $tanggal->subDay(1),
            'updated_at' => $tanggal->subDay(1)
        ]);
    }
}
