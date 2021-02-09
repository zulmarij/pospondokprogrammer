<?php

use App\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Member::create([
            'user_id' => 5,
            'no_hp' => '080808080808',
            'kode_member' => rand(999999999,999999999999),
            'saldo' => 100000
        ]);
    }
}
