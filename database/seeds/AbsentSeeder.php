<?php

use App\Absent;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AbsentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tanggal = Carbon::today('Asia/Jakarta');

        Absent::create([
            'user_id' => 3,
            'created_at' => $tanggal->subDay(4),
            'updated_at' => $tanggal->subDay(4)
        ]);
        Absent::create([
            'user_id' => 3,
            'created_at' => $tanggal->subDay(4),
            'updated_at' => $tanggal->subDay(4)
        ]);

        Absent::create([
            'user_id' => 3,
            'created_at' => $tanggal->subDay(3),
            'updated_at' => $tanggal->subDay(3)
        ]);

        Absent::create([
            'user_id' => 3,
            'created_at' => $tanggal->subDay(2),
            'updated_at' => $tanggal->subDay(2)
        ]);

        Absent::create([
            'user_id' => 3,
            'created_at' => $tanggal->subDay(2),
            'updated_at' => $tanggal->subDay(2)
        ]);

        Absent::create([
            'user_id' => 3,
            'created_at' => $tanggal->subDay(1),
            'updated_at' => $tanggal->subDay(1)
        ]);
    }
}
