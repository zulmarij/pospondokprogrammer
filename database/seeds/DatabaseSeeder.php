<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(BarangSeeder::class);
        $this->call(PembelianSeeder::class);
        $this->call(PenjualanSeeder::class);
        $this->call(PengeluaranSeeder::class);
        $this->call(AbsentSeeder::class);
    }
}
