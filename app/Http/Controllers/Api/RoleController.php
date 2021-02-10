<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::get();

        if (empty($role)) {
            return $this->responseError('Role Kosong', 403);
        }
        return $this->responseOk($role, 200, 'Sukses Liat Data Role');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Buat Role', 422, $validator->errors());
        }

        $params = [
            'name' => $request->name,
        ];

        $role = Role::create($params);

        return $this->responseOk($role, 200, 'Sukses Buat Role');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Gagal Ubah Role', 422, $validator->errors());
        }

        $role = Role::find($id);

        $params = [
            'name' => $request->name ?? $role->name,
        ];

        $role->update($params);

        return $this->responseOk($role, 200, 'Sukses Ubah Role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();

        return $this->responseOk(null, 200, 'Sukses Hapus Role');
    }
}
