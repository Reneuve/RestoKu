@extends('layouts.admin')

@section('title')
<title>Order | Admin</title>
@endsection

@section('content')
<h1>Daftar Pesanan</h1>
<div class="mb-2 d-flex">
    <a href="/admin/order?sort={{ Request::get('sort')=='desc'?'asc':'desc' }}">
        <button type="button" class="btn btn-primary d-flex align-items-center">
            <span class="material-icons mr-2">sort</span>
            Sort By Date
        </button>
    </a>
    <a href="/admin/order">
        <button type="button" class="btn btn-secondary d-flex align-items-center ml-3">
            <span class="material-icons mr-2">clear</span>
            Reset
        </button>
    </a>
</div>
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Action</th>
            <th>Status</th>
            <th>Customer</th>
            <th>Nomor Meja</th>
            <th>Jumlah Pesanan</th>
            <th>Waktu Order</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $key => $data)
        <tr>
            <td scope="row">{{ $datas->firstItem()+$key }}</td>
            <td><a href="/admin/order/{{ $data->transaction_id }}">Lihat Detail</a></td>
            <td>{{ $data->is_finish==0?'Belum Selesai':'Selesai' }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->total_menu }}</td>
            <td>{{ $data->table_number }}</td>
            <td>{{ \Carbon\Carbon::parse( $data->order_at)->format('d/m/Y H:m:s') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
    {{ $datas->links() }}
</div>
@endsection
