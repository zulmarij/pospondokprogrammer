<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function navbar()
    {
        $user = User::find(1)->all();

        return view('inc.sidebar', compact('user'));
    }
}
