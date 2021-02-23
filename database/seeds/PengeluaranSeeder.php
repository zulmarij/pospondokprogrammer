<?php

use App\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tanggal = Carbon::now('Asia/Jakarta');

        Pengeluaran::create([
            'tipe' => 'Beli Lampu',
            'biaya' => 25000,
            'created_at' => $tanggal->subDay(3),
            'updated_at' => $tanggal->subDay(3)
        ]);

        Pengeluaran::create([
            'tipe' => 'Beli Nota dll',
            'biaya' => 25000,
            'created_at' => $tanggal->subDay(2),
            'updated_at' => $tanggal->subDay(2)
        ]);

        Pengeluaran::create([
            'tipe' => 'Bayar Tagihan Air',
            'biaya' => 50000,
            'created_at' => $tanggal->subDay(1),
            'updated_at' => $tanggal->subDay(1)
        ]);
    }
}
