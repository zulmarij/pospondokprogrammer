<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'foto' => 'https://i.ibb.co/cFZfrYC/administrator.png',
            'no_hp' => '081350887602',
            'umur' => 25,
            'alamat' => 'Pondok Programmer Kec. Kretek Bantul Yogyakarta'
        ]);
        $admin->assignRole('admin');

        $pimpinan = User::create([
            'nama' => 'pimpinan',
            'email' => 'pimpinan@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'foto' => 'https://i.ibb.co/cFZfrYC/administrator.png',
            'no_hp' => '081350887602',
            'umur' => 25,
            'alamat' => 'Pondok Programmer Kec. Kretek Bantul Yogyakarta'
        ]);
        $pimpinan->assignRole('pimpinan');

        $kasir = User::create([
            'nama' => 'kasir',
            'email' => 'kasir@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'foto' => 'https://i.ibb.co/cFZfrYC/administrator.png',
            'no_hp' => '081350887602',
            'umur' => 25,
            'alamat' => 'Pondok Programmer Kec. Kretek Bantul Yogyakarta',
        ]);
        $kasir->assignRole('kasir');

        $staff = User::create([
            'nama' => 'staff',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'foto' => 'https://i.ibb.co/cFZfrYC/administrator.png',
            'no_hp' => '081350887602',
            'umur' => 25,
            'alamat' => 'Pondok Programmer Kec. Kretek Bantul Yogyakarta'
        ]);
        $staff->assignRole('staff');

        $member = User::create([
            'nama' => 'member',
            'email' => 'member@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'foto' => 'https://i.ibb.co/cFZfrYC/administrator.png',
            'kode_member' => rand(999999999,999999999999),
            'no_hp' => '081350887602',
            'umur' => 25,
            'alamat' => 'Pondok Programmer Kec. Kretek Bantul Yogyakarta'
        ]);
        $member->assignRole('member');
    }
}
