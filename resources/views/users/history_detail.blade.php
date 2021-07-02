@extends('layouts.app')

@section('title')
<title>Detail Pesanan| Restoku</title>
@endsection

@section('content')
<h2>Detail Cart</h2>
@foreach ($datas as $data)
<table>
    <tr>
        <td>Meja Nomor</td>
        <td>:</td>
        <td>{{ $data->table_number }}</td>
    </tr>
    <tr>
        <td>Waktu Order</td>
        <td>:</td>
        <td>{{ \Carbon\Carbon::parse( $data->order_at)->format('d/m/Y H:m:s') }}</td>
    </tr>
    <tr>
        <td>Status Transaksi</td>
        <td>:</td>
        <td>{{ $data->is_finish==0?'Menunggu':'Selesai' }}</td>
    </tr>
    <tr>
        <td>Total Pembayaran</td>
        <td>:</td>
        <td>@currencyRp($data->amount)</td>
    </tr>
</table>
@endforeach
<hr>
<div class="mt-3 d-flex flex-column align-items-center">
    <h4 class="align-self-start">Daftar Pesanan</h4>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Menu</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $key => $item)
            <tr>
                <td scope="row">{{ $items->firstItem()+$key }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $items->links() }}
</div>
@endsection
