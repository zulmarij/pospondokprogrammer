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
                                <h4 class="text-center">Barang</h4>
                            </div>
                        </div>
                    </div>

                    <div class="widget-content widget-content-area text-center">

                        <div class="simple--counter-container">

                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter1 s-counter">{{ $total_barang }}</h1>
                                </div>
                                <p class="s-counter-text">Total Barang</p>
                            </div>
                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter2 s-counter">{{ $total_stok }}</h1>
                                </div>
                                <p class="s-counter-text">Total Stok</p>
                            </div>
                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter3 s-counter">{{ $total_harga_beli }}</h1>
                                </div>
                                <p class="s-counter-text">Total Harga Beli</p>
                            </div>
                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter4 s-counter">{{ $total_harga_jual }}</h1>
                                </div>
                                <p class="s-counter-text">Total Harga Jual</p>
                            </div>
                        </div>

                        @role('admin|staff')
                        <form action="{{ route('barang.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama"
                                        value="{{ old('nama') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="uid">UID</label>
                                    <input type="number" name="uid" class="form-control" id="uid"
                                        value="{{ rand(0, 9999999999) }}">
                                </div>
                            </div>
                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="harga_beli">Harga Beli</label>
                                    <input type="number" name="harga_beli" class="form-control" id="harga_beli"
                                        value="{{ old('harga_beli') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="harga_jual">Harga Jual</label>
                                    <input type="number" name="harga_jual" class="form-control" id="harga_jual"
                                        value="{{ old('harga_jual') }}">
                                </div>
                            </div>
                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="merk">Merk</label>
                                    <input type="text" name="merk" class="form-control" id="merk"
                                        value="{{ old('merk') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="kategori_id">Kategori</label>
                                    <select id="kategori_id" name="kategori_id" class="form-control">
                                        @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="stok">Stok</label>
                                    <input type="number" name="stok" class="form-control" id="stok"
                                        value="{{ old('stok') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="diskon">Diskon</label>
                                    <input type="number" name="diskon" class="form-control" id="diskon"
                                        value="{{ old('diskon') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary btn-rounded mb-2">Tambah
                                Barang</button>
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
                                <th>Uid</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Kategori</th>
                                <th>Merk</th>
                                <th>Stok</th>
                                <th>Diskon</th>
                                @role('admin|staff')
                                <th class="text-center">Aksi</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $barang)
                            <tr>
                                <td>{{ $barang->id }}</td>
                                <td>{{ $barang->nama }}</td>
                                <td>{{ $barang->uid }}</td>
                                <td>{{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                                <td>{{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ $barang->kategori->nama }}</td>
                                <td>{{ $barang->merk }}</td>
                                <td>{{ $barang->stok }}</td>
                                <td>{{ number_format($barang->diskon, 0, ',', '.') }}</td>
                                @role('admin|staff')
                                <td class="text-center">
                                    <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#update-{{$barang->id}}"> Ubah </button>
                                        <button type="button" class="btn btn-outline-danger btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#delete-{{$barang->id}}"> Delete
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
@include('admin.barang.modal')
@endsection
