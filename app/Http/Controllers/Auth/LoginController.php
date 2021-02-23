<?php

namespace App\Http\Controllers\Auth;

use App\Absent;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected function authenticated($request, $user)
    {
        if ($user->hasRole('admin')) {
            return redirect('/admin/user');
        } elseif ($user->hasRole('pimpinan')) {
            return redirect('/admin/laporan');
        } elseif ($user->hasRole('staff')) {
            return redirect('/admin/pembelian');
        } elseif ($user->hasRole('kasir')) {
            $data['user_id'] = $user->id;
            Absent::create($data);
            return redirect('/admin/penjualan/dibayar');
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
