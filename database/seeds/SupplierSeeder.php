<?php

use App\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::create([
            'nama' => 'Supplier',
            'alamat' => 'Pondok Programmer Kec. Kretek Bantul Yogyakarta',
            'no_hp' => '080808080808'
        ]);
    }
}
