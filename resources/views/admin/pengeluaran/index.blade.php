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
                                <h4 class="text-center">Pengeluaran</h4>
                            </div>
                        </div>
                    </div>

                    <div class="widget-content widget-content-area text-center">
                        <div class="simple--counter-container">

                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter1 s-counter">{{ $jumlah }}</h1>
                                </div>
                                <p class="s-counter-text">Total Jumlah</p>
                            </div>
                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter2 s-counter">{{ $biaya }}</h1>
                                </div>
                                <p class="s-counter-text">Total Biaya</p>
                            </div>
                        </div>
                        <form action="{{ route('pengeluaran.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="tipe">Tipe</label>
                                    <input type="text" name="tipe" class="form-control" id="tipe"
                                        value="{{ old('tipe') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="biaya">Biaya</label>
                                    <input type="number" name="biaya" class="form-control" id="biaya"
                                        value="{{ old('biaya') }}">
                                </div>
                            </div>
                        <button type="submit" class="btn btn-outline-primary btn-rounded mb-2">Tambah
                            Pengeluaran</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="widget-content widget-content-area br-6">
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tipe</th>
                                <th>Biaya</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengeluarans as $pengeluaran)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pengeluaran->tipe }}</td>
                                <td>{{ $pengeluaran->biaya }}</td>
                                <td>{{ $pengeluaran->created_at }}</td>
                                <td class="text-center">
                                    <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm"
                                            data-toggle="modal" data-target="#update-{{$pengeluaran->id}}"> Ubah
                                        </button>
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
