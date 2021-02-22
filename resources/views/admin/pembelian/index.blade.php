@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <button type="button" class="btn btn-outline-primary btn-rounded mb-2" data-toggle="modal"
                data-target="#create">Tambah
                Pembelian</button>
            <div class="widget-content widget-content-area br-6">
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Supplier</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Total Biaya</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelians as $pembelian)
                            <tr>
                                <td>{{ $pembelian->id }}</td>
                                <td>{{ $pembelian->supplier->nama }}</td>
                                <td>{{ $pembelian->barang->nama }}</td>
                                <td>{{ $pembelian->jumlah }}</td>
                                <td>{{ $pembelian->total_biaya }}</td>
                                <td>{{ $pembelian->created_at }}</td>
                                <td class="text-center">
                                    <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#update-{{$pembelian->id}}"> Ubah </button>
                                        <button type="button" class="btn btn-outline-danger btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#delete-{{$pembelian->id}}"> Delete
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
@include('admin.pembelian.modal')
@endsection
