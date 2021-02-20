<?php

namespace App\Http\Controllers\Api;

use App\Absent;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\User;
use Carbon\Carbon;

class AbsentController extends BaseController
{
    public function absent()
    {
        $start = Carbon::now()->subDays(30);
        $end = Carbon::now();

        $absent = Absent::select("*")
            ->whereBetween('created_at', [$start, $end])
            ->get();

        foreach ($absent as $a) {
            $response = [
                'user_id' =>$a->user->id,
                'nama' => $a->user->nama,
                'hadir' => $a->created_at,
            ];
        }

        return $this->responseOk($response, 200, 'Data absent harian perbulan berhasil ditampilkan');
    }
}
