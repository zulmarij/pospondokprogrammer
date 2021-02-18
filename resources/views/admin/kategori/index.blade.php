@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <button type="button" class="btn btn-outline-primary btn-rounded mb-2 btn-create" data-toggle="modal"
                data-target="#create">Tambah
                Kategori</button>

            <div class="widget-content widget-content-area br-6">
                {{-- @if(count($errors) > 0)
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close"
                        data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"
                            data-dismiss="alert">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg></button> <strong>Gagal!</strong> {{$error}}. </div>
            @endforeach
            @endif --}}
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
