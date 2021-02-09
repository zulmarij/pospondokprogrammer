<?php

use App\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Barang::create([
            'nama' => 'Beras Curah 1kg',
            'uid' => rand(0,9999999999),
            'harga_beli' => 11000,
            'harga_jual' => 15000,
            'kategori_id' => 1,
            'merk' => 'Curah',
            'stok' => 25,
            'diskon' => 5
        ]);

        Barang::create([
            'nama' => 'Aqua Air Mineral 220ml',
            'uid' => rand(0,9999999999),
            'harga_beli' => 20000,
            'harga_jual' => 24000,
            'kategori_id' => 2,
            'merk' => 'Aqua',
            'stok' => 30,
            'diskon' => 10,
        ]);

        Barang::create([
            'nama' => 'Roma Biskuit Kelapa',
            'uid' => rand(0,9999999999),
            'harga_beli' => 19000,
            'harga_jual' => 23000,
            'kategori_id' => 3,
            'merk' => 'Roma',
            'stok' => 30,
            'diskon' => 10,
        ]);

        Barang::create([
            'nama' => 'Momogi Cokelat Snack 200g',
            'uid' => rand(0,9999999999),
            'harga_beli' => 14000,
            'harga_jual' => 17000,
            'kategori_id' => 4,
            'merk' => 'Juara Snack',
            'stok' => 25,
            'diskon' => 5,
        ]);

        Barang::create([
            'nama' => 'Lifebuoy Cool Fresh Sabun batang 75Gr',
            'uid' => rand(0,9999999999),
            'harga_beli' => 1000,
            'harga_jual' => 3000,
            'kategori_id' => 5,
            'merk' => 'Lifebuoy',
            'stok' => 15,
            'diskon' => 0,
        ]);

        Barang::create([
            'nama' => 'Rinso Matic Deterjen Bubuk',
            'uid' => rand(0,9999999999),
            'harga_beli' => 15000,
            'harga_jual' => 18000,
            'kategori_id' => 6,
            'merk' => 'Rinso',
            'stok' => 20,
            'diskon' => 5,
        ]);

        Barang::create([
            'nama' => 'Stella Air Freshener Refill Green 225ml',
            'uid' => rand(0,9999999999),
            'harga_beli' => 27000,
            'harga_jual' => 32000,
            'kategori_id' => 7,
            'merk' => 'Stella',
            'stok' => 30,
            'diskon' => 15,
        ]);

        Barang::create([
            'nama' => 'Buku Tulis Sinar Dunia 38 Lembar',
            'uid' => rand(0,9999999999),
            'harga_beli' => 21000,
            'harga_jual' => 25000,
            'kategori_id' => 8,
            'merk' => 'Sinar Dunia',
            'stok' => 25,
            'diskon' => 10,
        ]);
    }
}
