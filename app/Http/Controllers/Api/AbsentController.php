<?php

namespace App\Http\Controllers\Api;

use App\Absent;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Carbon\Carbon;

class AbsentController extends BaseController
{
    public function absent()
    {
        // $start = Carbon::now()->subDays(30);
        // $end = Carbon::now();
        $kasir = Absent::whereBetween('created_at', [now(), now()->addDays(30)])
        ->orderBy('created_at')
        ->get()
        ->groupBy(function ($val) {
            return Carbon::parse($val->start_time)->format('d');
        });
        return $this->responseOk($kasir, 200,'Data harian berhasil ditampilkan');
    }
}

