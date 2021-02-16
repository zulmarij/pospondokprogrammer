<?php

namespace App\Http\Controllers\Api;

use App\Absent;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;

class AbsentController extends BaseController
{
    public function absentkasir()
    {
        $kasir = Absent::whereDay('created_at', date('d'))->get();

        if ($kasir) {
            # code...
        }
    }
}
