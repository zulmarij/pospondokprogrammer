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
        $awal = Carbon::today('Asia/Jakarta')->subMonth(1)->format('Y-m-d');
        $akhir = Carbon::today('Asia/Jakarta')->format('Y-m-d');

        $absents = Absent::whereDate('created_at', '>=', $awal)
            ->whereDate('created_at', '<=', $akhir)
            ->get();

        foreach ($absents as $a) {
            $response = [
                'user_id' => $a->user->id,
                'nama' => $a->user->nama,
                'hadir' => $a->created_at,
            ];
        }

        return $this->responseOk($response, 200, 'Data absent harian perbulan berhasil ditampilkan');
    }
}
