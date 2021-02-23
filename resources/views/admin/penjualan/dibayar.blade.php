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
                                <h4 class="text-center">Penjualan</h4>
                            </div>
                        </div>
                    </div>

                    <div class="widget-content widget-content-area text-center">

                        <div class="simple--counter-container">

                            <div class="counter-container">
                                <div class="">
                                    <h1 class="s-counter1 s-counter">{{ $total_penjualan }}</h1>
                                </div>
                                <p class="s-counter-text">Total Penjualan</p>
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area br-6">
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Total Harga</th>
                                <th>Dibayar</th>
                                <th>Kembalian</th>
                                <th>Diskon</th>
                                <th>Member</th>
                                <th>Kasir</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualans as $penjualan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $penjualan->barang->nama }}</td>
                                <td>{{ $penjualan->jumlah_barang }}</td>
                                <td>{{ $penjualan->total_harga }}</td>
                                <td>{{ $penjualan->dibayar }}</td>
                                <td>{{ $penjualan->kembalian }}</td>
                                <td>{{ $penjualan->barang->diskon }}</td>
                                <td>{{ !empty($penjualan->member) ? $penjualan->member->user->nama:' '}}</td>
                                <td>{{ !empty($penjualan->user) ? $penjualan->user->nama:'' }}</td>
                                <td>{{ $penjualan->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
