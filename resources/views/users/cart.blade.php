@extends('layouts.app')

@section('title')
<title>Keranjang Saya | Restoku</title>
@endsection

@section('content')
<div class="bg-white p-3 border rounded">
    <h2>Keranjang Saya</h2>
    <hr>
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
    @if(isset($items))
    <?php
    $qty=0;
    $total=0;
    ?>
    @foreach ($items as $item)
    <?php
    $qty+=$item->quantity;
    $total+=($item->price * $item->quantity)
    ?>
    <div class="d-flex mt-3">
        <img src="{{ asset('asset/menus/'.$item->image) }}" alt="{{ $item->image }}" width="120" height="120">
        <div class="d-flex flex-column ml-3 justify-content-between">
            <span class="cart-name font-weight-bold">{{ $item->name }}</span>
            <div class="d-flex flex-column">
                <div class="d-flex">
                    <a href="/user/cart/remove/{{ $item->menu_id }}" class="action-btn-cart d-flex align-items-center rounded-circle bg-danger text-white pointer">
                        <span class="material-icons">remove</span>
                    </a>
                    <span class="mr-3 ml-3 underline">{{ $item->quantity }}</span>
                    <a href=" /user/cart/add/{{ $item->menu_id }}" class="action-btn-cart d-flex align-items-center rounded-circle bg-success text-white pointer">
                        <span class="material-icons">add</span>
                    </a>
                </div>
                <span class="text-start text-secondary">( @currencyRp($item->price * $item->quantity) )</span>
            </div>
        </div>
    </div>
    @endforeach
    <hr>
    <form method="POST" action="/user/transaction" class="mt-5 d-flex flex-column align-items-end">
        @csrf
        <table>
            <tr>
                <td>
                    Jumlah
                </td>
                <td>:</td>
                <td class="text-right"><strong>{{ $qty }}</strong></td>
            </tr>
            <tr>
                <td>Total</td>
                <td>:</td>
                <td class="text-right"><strong>@currencyRp($total)</strong></td>
            </tr>
            <tr>
                <td>Meja Nomor</td>
                <td>:</td>
                <td class="text-right"><input type="number" min="1" max="10" name="table_number" required></td>
            </tr>
        </table>
        <div class="d-flex justify-content-between w-100 mt-3">
            <input type="text" name="id" value="{{ $cart_id}}" hidden>
            <input type="text" name="total" value="{{ $total}}" hidden>
            <a href="/user/cart/clear/{{ $cart_id }}" class="text-decoration-none d-flex align-items-center">
                <span class="material-icons mr-1">delete</span>
                Bersihkan Keranjang
            </a>
            <button type="submit" class="btn btn-success d-flex align-items-center ml-2">
                <span class="material-icons mr-2">fact_check</span>
                Buat Pesanan
            </button>
        </div>
        @else
        <p class="text-center">{{ $result}}</p>
        <a href="/menu" class="d-flex justify-content-center align-items-center">
            <span class="material-icons mr-1">shopping_basket</span>
            Beli Sekarang</a>
        @endif
</div>
@endsection
