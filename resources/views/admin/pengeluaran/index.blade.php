@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <button type="button" class="btn btn-outline-primary btn-rounded mb-2 btn-create" data-toggle="modal"
                data-target="#create">Tambah
                Pengeluaran</button>

            <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table id="html5-extension" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Tipe</th>
                            <th>Biaya</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengeluarans as $pengeluaran)
                        <tr>
                            <td>{{ $pengeluaran->id }}</td>
                            <td>{{ $pengeluaran->tipe }}</td>
                            <td>{{ $pengeluaran->biaya }}</td>
                            <td>{{ $pengeluaran->created_at }}</td>
                            <td class="text-center">
                                <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm"
                                        data-toggle="modal" data-target="#update-{{$pengeluaran->id}}"> Ubah </button>
                                    <button type="button" class="btn btn-outline-danger btn-rounded btn-sm"
                                        data-toggle="modal" data-target="#delete-{{$pengeluaran->id}}"> Delete
                                    </button>
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
@include('admin.pengeluaran.modal')
@endsection
