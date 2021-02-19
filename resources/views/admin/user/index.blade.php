@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <button type="button" class="btn btn-outline-primary btn-rounded  mb-2" data-toggle="modal" data-target="#create">Tambah
                User</button>
            <div class="widget-content widget-content-area br-6">
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Hp</th>
                                <th>Umur</th>
                                <th>Alamat</th>
                                <th>Role</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <div class="usr-img-frame mr-2 rounded-circle">
                                            <img alt="avatar" class="img-fluid rounded-circle" src="{{ $user->foto }}"
                                                height="90" width="90">
                                        </div>
                                        <p class="align-self-center mb-0 admin-name"> {{ $user->nama }} </p>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->no_hp }}</td>
                                <td>{{ $user->umur }}</td>
                                <td>{{ $user->alamat }}</td>
                                <td class="text-center">
                                    @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $role)
                                    @if ($role == 'admin')
                                    <span class="badge outline-badge-danger shadow-none">{{ $role }}</span>
                                    @elseif ($role == 'pimpinan')
                                    <span class="badge outline-badge-warning shadow-none">{{ $role }}</span>
                                    @elseif ($role == 'staff')
                                    <span class="badge outline-badge-primary shadow-none">{{ $role }}</span>
                                    @elseif ($role == 'kasir')
                                    <span class="badge outline-badge-secondary shadow-none">{{ $role }}</span>
                                    @elseif ($role == 'member')
                                    <span class="badge outline-badge-success shadow-none">{{ $role }}</span>
                                    @endif
                                    @endforeach
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm" data-toggle="modal"
                                            data-target="#update-{{$user->id}}"> Ubah </button>
                                        <button type="button" class="btn btn-outline-danger btn-rounded btn-sm" data-toggle="modal"
                                            data-target="#delete-{{$user->id}}"> Delete </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
@include('admin.user.modal')
@endsection
