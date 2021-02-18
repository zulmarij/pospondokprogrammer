@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <button type="button" class="btn btn-outline-primary btn-rounded mb-2" data-toggle="modal"
                data-target="#create">Tambah
                Barang</button>
            <div class="widget-content widget-content-area br-6">
                @if(count($errors) > 0)
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
                @endif
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Uid</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Kategori</th>
                                <th>Merk</th>
                                <th>Stok</th>
                                <th>Diskon</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $barang)
                            <tr>
                                <td>{{ $barang->nama }}</td>
                                <td>{{ $barang->uid }}</td>
                                <td>{{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                                <td>{{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ $barang->kategori->nama }}</td>
                                <td>{{ $barang->merk }}</td>
                                <td>{{ $barang->stok }}</td>
                                <td>{{ number_format($barang->diskon, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#update-{{$barang->id}}"> Ubah </button>
                                        <button type="button" class="btn btn-outline-danger btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#delete-{{$barang->id}}"> Delete
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
@include('admin.barang.modal')
@endsection
