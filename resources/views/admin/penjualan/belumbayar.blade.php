@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
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
                                    <h1 class="s-counter1 s-counter">{{ $total_keranjang }}</h1>
                                </div>
                                <p class="s-counter-text">Total Keranjang</p>
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
                        @role('kasir|admin')
                        <button type="button" class="btn btn-outline-primary btn-rounded mb-2" data-toggle="modal"
                            data-target="#confirmbayar">Konfirmasi bayar langsung</button>
                        <button type="button" class="btn btn-outline-primary btn-rounded mb-2" data-toggle="modal"
                            data-target="#confirmmember">Konfirmasi bayar pakai saldo member</button>
                        @endrole
                    </div>
                    @role('kasir|admin')
                    <div class="widget-content widget-content-area text-center">
                        <form action="{{ route('penjualan.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="barang_id">Barang</label>
                                    <select id="barang_id" name="barang_id" class="form-control">
                                        @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jumlah_barang">Jumlah Barang</label>
                                    <input type="number" name="jumlah_barang" class="form-control" id="jumlah_barang"
                                        value="{{ old('jumlah_barang') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary btn-rounded mb-2">Tambah
                                Keranjang</button>
                        </form>
                    </div>
                    @endrole

                </div>
            </div>

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
                                @role('admin|kasir')
                                <th class="text-center">Aksi</th>
                                @endrole
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
                                @role('admin|kasir')
                                <td class="text-center">
                                    <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#update-{{$penjualan->id}}"> Ubah </button>
                                        <button type="button" class="btn btn-outline-danger btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#delete-{{$penjualan->id}}"> Delete
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
@include('admin.penjualan.modal')
@endsection
