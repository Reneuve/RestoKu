@extends('layouts.app')

@section('title')
<title>Keranjang Saya | Restoku</title>
@endsection

@section('content')
<div class="bg-white p-3 border rounded">
    <h2>Keranjang Saya</h2>
    @if(isset($items))
    @foreach ($items as $item)
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
    @else
    <p class="text-center">{{ $result}}</p>
    <a href="/menu" class="d-flex justify-content-center align-items-center">
        <span class="material-icons mr-1">shopping_basket</span>
        Beli Sekarang</a>
    @endif
</div>
@endsection
