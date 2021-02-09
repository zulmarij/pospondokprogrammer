<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'nama' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);
        $admin->assignRole('admin');

        $pimpinan = User::create([
            'nama' => 'pimpinan',
            'email' => 'pimpinan@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);
        $pimpinan->assignRole('pimpinan');

        $kasir = User::create([
            'nama' => 'kasir',
            'email' => 'kasir@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'umur' => 22,
            'alamat' => 'Pondok Programmer Kec. Kretek Bantul Yogyakarta'
        ]);
        $kasir->assignRole('kasir');

        $staff = User::create([
            'nama' => 'staff',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);
        $staff->assignRole('staff');

        $member = User::create([
            'nama' => 'member',
            'email' => 'member@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);
        $member->assignRole('member');
    }
}
