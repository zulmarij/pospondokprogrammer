<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Member;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::get();
        $users = User::role('member')->get();

        $total_member = Member::count();
        $total_saldo = Member::sum('saldo');
        $data = [
            'category_name' => 'member',
            'page_name' => 'index_member',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'alt_menu' => 0,

        ];
        return view('admin.member.index', compact('members', 'users', 'total_member', 'total_saldo'))->with($data);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return back()->withToastError($validator->messages()->all()[0])->withInput();
        }

        $params = [
            'user_id' => $request->user_id,
            'saldo' => 0,
        ];

        $member = Member::where('user_id', $params['user_id'])->first();
        if ($member != null) {
            return back()->withToastError('User ini sudah terdaftar menjadi member ');
        } else {
            Member::create($params);
            return back()->withToastSuccess('Berhasil topup');
        }

        // Member::create($params);
        // return back()->withToastSuccess('Berhasil topup');
    }

    public function topup(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'saldo' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return back()->withToastError($validator->messages()->all()[0])->withInput();
        }
        $member = Member::find($id);

        $params['saldo'] = $request->saldo + $member->saldo;

        $member->update($params);
        return back()->withToastSuccess('Berhasil Top Up');
    }

    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();

        return back()->withToastSuccess('Member Berhasil dihapus');
    }
}
