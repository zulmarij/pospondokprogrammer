<?php

use App\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::create([
            'nama' => 'Makanan Pokok'
        ]);

        Kategori::create([
            'nama' => 'Minuman'
        ]);

        Kategori::create([
            'nama' => 'Roti Kering dan Basah'
        ]);

        Kategori::create([
            'nama' => 'Snack'
        ]);

        Kategori::create([
            'nama' => 'Perawatan Tubuh'
        ]);

        Kategori::create([
            'nama' => 'Peralatan Cuci'
        ]);

        Kategori::create([
            'nama' => ' Bahan dan Peralatan Perawatan Rumah'
        ]);

        Kategori::create([
            'nama' => 'Alat Tulis dan Kantor'
        ]);
    }
}
