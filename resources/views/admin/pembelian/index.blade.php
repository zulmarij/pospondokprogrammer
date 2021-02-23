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
                                <h4 class="text-center">Pembelian</h4>
                            </div>
                        </div>
                    </div>

                    <div class="widget-content widget-content-area text-center">

                        <div class="simple--counter-container">

                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter1 s-counter">{{ $total_pembelian }}</h1>
                                </div>
                                <p class="s-counter-text">Total Pembelian</p>
                            </div>
                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter2 s-counter">{{ $total_barang }}</h1>
                                </div>
                                <p class="s-counter-text">Total Barang</p>
                            </div>
                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter3 s-counter">{{ $total_biaya }}</h1>
                                </div>
                                <p class="s-counter-text">Total Biaya</p>
                            </div>
                        </div>

                        @role('admin|staff')
                        <form action="{{ route('pembelian.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="supplier_id">Supplier</label>
                                    <select id="supplier_id" name="supplier_id" class="form-control">
                                        @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="barang_id">Barang</label>
                                    <select id="barang_id" name="barang_id" class="form-control">
                                        @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" name="jumlah" class="form-control" id="jumlah"
                                        value="{{ old('jumlah') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="total_biaya">Total Biaya</label>
                                    <input type="number" name="total_biaya" class="form-control" id="total_biaya"
                                        value="{{ old('total_biaya') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary btn-rounded mb-2">Tambah
                                Pembelian</button>
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
                                <th>Supplier</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Total Biaya</th>
                                <th>Tanggal</th>
                                @role('admin|staff')
                                <th class="text-center">Aksi</th>
                                @endrole
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
                                @role('admin|staff')
                                <td class="text-center">
                                    <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#update-{{$pembelian->id}}"> Ubah </button>
                                        <button type="button" class="btn btn-outline-danger btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#delete-{{$pembelian->id}}"> Delete
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
@include('admin.pembelian.modal')
@endsection
