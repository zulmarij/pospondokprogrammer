@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Total Harga</th>
                                <th>Dibayar</th>
                                <th>Kembalian</th>
                                <th>Diskon</th>
                                <th>Member</th>
                                <th>Kasir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualans as $penjualan)
                            <tr>
                                <td>{{ $penjualan->id }}</td>
                                <td>{{ $penjualan->barang->nama }}</td>
                                <td>{{ $penjualan->jumlah_barang }}</td>
                                <td>{{ $penjualan->total_harga }}</td>
                                <td>{{ $penjualan->dibayar }}</td>
                                <td>{{ $penjualan->kembalian }}</td>
                                <td>{{ $penjualan->barang->diskon }}</td>
                                <td>{{ !empty($penjualan->member) ? $penjualan->member->user->nama:' '}}</td>
                                <td>{{ !empty($penjualan->user) ? $penjualan->user->nama:'' }}</td>
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
