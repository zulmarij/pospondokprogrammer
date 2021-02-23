@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div id="counterBasic" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4 class="text-center">Member</h4>
                            </div>
                        </div>
                    </div>

                    <div class="widget-content widget-content-area text-center">

                        <div class="simple--counter-container">

                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter1 s-counter">{{ $total_member }}</h1>
                                </div>
                                <p class="s-counter-text">Total Member</p>
                            </div>
                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter2 s-counter">{{ $total_saldo }}</h1>
                                </div>
                                <p class="s-counter-text">Total Saldo</p>
                            </div>
                        </div>

                        @role('admin|kasir')
                        <form action="{{ route('member.register') }}" method="post">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="user_id">Nama</label>
                                <select id="user_id" name="user_id" class="form-control">
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-outline-primary btn-rounded mb-2">Tambah
                                Member</button>
                        </form>
                        @endrole
                    </div>
                </div>
            </div>

            <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table id="html5-extension" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nama</th>
                            <th>Kode Member</th>
                            <th>Saldo</th>
                            @role('admin|kasir')
                            <th class="text-center">Aksi</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td>{{ $member->user->nama }}</td>
                            <td>{{ $member->user->kode_member }}</td>
                            <td>{{ $member->saldo }}</td>
                            @role('admin|kasir')
                            <td class="text-center">
                                <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm"
                                        data-toggle="modal" data-target="#topup-{{$member->id}}"> TopUp </button>
                                    <button type="button" class="btn btn-outline-danger btn-rounded btn-sm"
                                        data-toggle="modal" data-target="#delete-{{$member->id}}"> Delete
                                    </button>
                                </div>
                            </td>
                            @endrole
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</div>
@include('admin.member.modal')
@endsection
