@extends('layouts.app')

@section('title')
<title>Restoku | History</title>
@endsection

@section('content')
<div class="d-flex mb-3">
    <a href="/user/history?sort={{ Request::get('sort')=='asc'?'desc':'asc' }}"><button type="button" class="btn btn-success">Sort By Order At</button></a>
    <a href="/user/history"><button type="button" class="btn btn-primary ml-3">Reset</button></a>
</div>
<div class="d-flex flex-column align-items-center">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Action</th>
                <th>Waktu Pemesanan</th>
                <th>Nomor Meja</th>
                <th>Total</th>
                <th>Status Pesanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $key => $data)
            <tr>
                <td>{{ $datas->firstItem() + $key }}</td>
                <td><a href="/user/history/{{ $data->id }}">Lihat Detail</a></td>
                <td>{{ \Carbon\Carbon::parse( $data->order_at)->format('D,M Y H:m:s') }}</td>
                <td>{{ $data->table_number }}</td>
                <td>@currencyRp($data->amount)</td>
                <td>{{ $data->is_finish==0?'Sedang Diproses':'Selesai' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $datas->links() }}
</div>
@endsection
