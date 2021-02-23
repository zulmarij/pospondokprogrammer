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
                                <h4 class="text-center">Supplier</h4>
                            </div>
                        </div>
                    </div>

                    <div class="widget-content widget-content-area text-center">

                        <div class="simple--counter-container">

                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter1 s-counter">{{ $total_supplier }}</h1>
                                </div>
                                <p class="s-counter-text">Total Supplier</p>
                            </div>
                        </div>

                        @role('admin|staff')
                        <form action="{{ route('supplier.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama"
                                        value="{{ old('nama') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="no_hp">No Hp</label>
                                    <input type="number" name="no_hp" class="form-control" id="no_hp"
                                        value="{{ old('no_hp') }}">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="alamat">alamat</label>
                                <input type="text" name="alamat" class="form-control" id="alamat"
                                    value="{{ old('alamat') }}">
                            </div>
                            <button type="submit" class="btn btn-outline-primary btn-rounded mb-2">Tambah
                                Supplier</button>
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
                                <th>Alamat</th>
                                <th>No Hp</th>
                                @role('admin|staff')
                                <th class="text-center">Aksi</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->id }}</td>
                                <td>{{ $supplier->nama }}</td>
                                <td>{{ $supplier->alamat }}</td>
                                <td>{{ $supplier->no_hp }}</td>
                                @role('admin|staff')
                                <td class="text-center">
                                    <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#update-{{$supplier->id}}"> Ubah </button>
                                        <button type="button" class="btn btn-outline-danger btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#delete-{{$supplier->id}}"> Delete
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
@include('admin.supplier.modal')
@endsection
