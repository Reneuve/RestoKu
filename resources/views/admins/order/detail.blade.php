@extends('layouts.admin')

@section('title')
<title>Detail Order | Admin</title>
@endsection

@section('content')
<h1>Detail Order</h1>
@foreach ($transactions as $transaction)
<table>
    <tr>
        <td>
            #ID Cart
        </td>
        <td>:</td>
        <td>{{ $transaction->cart_id }}</td>
    </tr>
    <tr>
        <td>
            Customer
        </td>
        <td>:</td>
        <td>{{ $transaction->name }}</td>
    </tr>
    <tr>
        <td>
            Nomor Meja
        </td>
        <td>:</td>
        <td>{{ $transaction->table_number }}</td>
    </tr>
    <tr>
        <td>
            Jumlah Pesanan
        </td>
        <td>:</td>
        <td>{{ $transaction->total_menu }}</td>
    </tr>
    <tr>
        <td>
            Pesanan Belum Selesai
        </td>
        <td>:</td>
        <td><strong>{{ $transaction->not_finished_order}}</strong></td>
    </tr>
    <tr>
        <td>
            Waktu Order
        </td>
        <td>:</td>
        <td>{{ \Carbon\Carbon::parse( $transaction->order_at)->format('d/m/Y H:m:s') }}</td>
    </tr>
</table>
@endforeach
<div class="mt-4">
    <h2>Pesanan</h2>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Menu</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menus as $key=>$menu)
            <tr>
                <td scope="row">{{ $menus->firstItem()+$key }}</td>
                <td>{{ $menu->name }}</td>
                <td>{{ $menu->quantity }}</td>
                <td> {{ $menu->status }}</td>
                <td>
                    @if($menu->status=="Menunggu")
                    <a href="/admin/order/status/{{ $menu->cart_items_id }}">
                        <button type="button" class="btn btn-primary btn-action-order">Proses Pesanan</button>
                    </a>
                    @elseif ($menu->status=="Diproses")
                    <a href="/admin/order/status/{{ $menu->cart_items_id }}">
                        <button type="button" class="btn btn-success btn-action-order">Selesaikan Pesanan</button>
                    </a>
                    @else
                    <p>-</p>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $menus->links() }}
</div>
@endsection
