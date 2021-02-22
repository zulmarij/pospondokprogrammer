<?php

namespace App\Http\Controllers\Admin;

use App\Absent;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AbsentController extends Controller
{
    public function index()
    {
        $start = Carbon::today('Asia/Jakarta')->subMonth(1)->format('Y-m-d');
        $end = Carbon::today('Asia/Jakarta')->format('Y-m-d');

        $absents = Absent::select(['*'])
            // ->whereBetween('created_at', [$start, $end])
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->distinct()
            ->get();

        // $absents = DB::table('absents')
        //     ->select(['user_id', DB::raw('MIN(created_at)')])
        //     ->groupBy('user_id')
        //     ->get();

            // dd($absents);
        $data = [
            'category_name' => 'absent',
            'page_name' => 'index_absent',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'alt_menu' => 0,

        ];
        return view('admin.absent.index', compact('absents'))->with($data);
    }
}
