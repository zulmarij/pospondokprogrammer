@extends('layouts.app')

@section('content')
{{-- {{dd($array)}} --}}
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div id="counterBasic" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4 class="text-center">Laporan</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area text-center">
                        <div class="simple--counter-container">
                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter2 s-counter">{{ $total_pembelian }}</h1>
                                </div>
                                <p class="s-counter-text">Total Pembelian</p>
                            </div>
                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter3 s-counter">{{ $total_penjualan }}</h1>
                                </div>
                                <p class="s-counter-text">Total Penjualan</p>
                            </div>
                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter4 s-counter">{{ $total_pengeluaran }}</h1>
                                </div>
                                <p class="s-counter-text">Total Pengeluaran</p>
                            </div>
                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter5 s-counter">{{ $total_pendapatan }}</h1>
                                </div>
                                <p class="s-counter-text">Total Pendapatan</p>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-rounded mb-2" data-toggle="modal"
                        data-target="#ubah">Ubah Tanggal</button>
                        <a href="{{ url('admin/laporan')}}" class="btn btn-outline-primary btn-rounded mb-2">Refresh</a>
                    </div>
                </div>
            </div>

            <div class="widget-content widget-content-area br-6">
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Pembelian</th>
                                <th>Penjualan</th>
                                <th>Pengeluaran</th>
                                <th>Pendapatan</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($array as $item)
                            <tr>
                                {{-- <td>{{ $loop->iteration }}</td> --}}
                                <td>{{ ($item['no'] !== null)?$item['no']:0 }}</td>
                                <td>{{ ($item['pembelian'] !== null)?$item['pembelian']:0 }}</td>
                                <td>{{ ($item['penjualan'] !== null)?$item['penjualan']:0 }}</td>
                                <td>{{ ($item['pengeluaran'] !== null)?$item['pengeluaran']:0 }}</td>
                                <td>{{ ($item['pendapatan'] !== null)?$item['pendapatan']:0 }}</td>
                                <td>{{ ($item['tanggal'] !== null)?$item['tanggal']:0 }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@include('admin.laporan.modal')
@endsection
