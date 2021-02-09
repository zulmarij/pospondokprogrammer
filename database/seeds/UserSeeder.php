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
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);
        $admin->assignRole('admin');

        $pimpinan = User::create([
            'name' => 'pimpinan',
            'email' => 'pimpinan@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);
        $pimpinan->assignRole('pimpinan');

        $kasir = User::create([
            'name' => 'kasir',
            'email' => 'kasir@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);
        $kasir->assignRole('kasir');

        $staff = User::create([
            'name' => 'staff',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);
        $staff->assignRole('staff');
    }
}
