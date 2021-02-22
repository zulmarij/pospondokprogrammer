@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <button type="button" class="btn btn-outline-primary btn-rounded mb-2" data-toggle="modal"
                data-target="#create">Tambah
                Keranjang</button>
            <div class="widget-content widget-content-area br-6">
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Total Harga</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <p hidden>{{ $no = 1 }}</p>
                            @foreach ($penjualans as $penjualan)
                            <tr>
                                <td>{{ $no ++ }}</td>
                                <td>{{ $penjualan->barang->nama }}</td>
                                <td>{{ $penjualan->jumlah_barang }}</td>
                                <td>{{ $penjualan->total_harga }}</td>
                                <td>{{ $penjualan->created_at }}</td>
                                <td class="text-center">
                                    <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#update-{{$penjualan->id}}"> Ubah </button>
                                        <button type="button" class="btn btn-outline-danger btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#delete-{{$penjualan->id}}"> Delete
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
        <div id="counterBasic" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 class="text-center">Keranjang</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area text-center">
                    <div class="simple--counter-container">
                        <div class="counter-container">
                            <div class="">
                                <h1 class="s-counter1 s-counter">{{ $total_item }}</h1>
                            </div>
                            <p class="s-counter-text">Total Item</p>
                        </div>
                        <div class="counter-container">
                            <div class="">
                                <h1 class="s-counter2 s-counter">{{ $total_barang }}</h1>
                            </div>
                            <p class="s-counter-text">Total Barang</p>
                        </div>
                        <div class="counter-container">
                            <div class="">
                                <h1 class="s-counter3 s-counter">{{ $total_harga }}</h1>
                            </div>
                            <p class="s-counter-text">Total Harga</p>
                        </div>
                        <div class="counter-container">
                            <div class="">
                                <h1 class="s-counter4 s-counter">{{ $total_diskon }}</h1>
                            </div>
                            <p class="s-counter-text">Total Diskon</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-rounded mb-2" data-toggle="modal"
                    data-target="#confirmbayar">Konfirmasi bayar langsung</button>
                    <button type="button" class="btn btn-outline-primary btn-rounded mb-2" data-toggle="modal"
                    data-target="#confirmmember">Konfirmasi bayar pakai saldo member</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.penjualan.modal')
@endsection
