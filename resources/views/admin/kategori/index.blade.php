@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <button type="button" class="btn btn-outline-primary btn-rounded mb-2 btn-create" data-toggle="modal"
                data-target="#create">Tambah
                Kategori</button>

            <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table id="html5-extension" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nama</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategoris as $kategori)
                        <tr>
                            <td>{{ $kategori->id }}</td>
                            <td>{{ $kategori->nama }}</td>
                            <td class="text-center">
                                <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm"
                                        data-toggle="modal" data-target="#update-{{$kategori->id}}"> Ubah </button>
                                    <button type="button" class="btn btn-outline-danger btn-rounded btn-sm"
                                        data-toggle="modal" data-target="#delete-{{$kategori->id}}"> Delete
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
@include('admin.kategori.modal')
@endsection
