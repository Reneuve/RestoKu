@extends('layouts.app')

@section('title')
<title>{{ $name }} | Restoku</title>
@endsection

@section('content')
@foreach ($menu as $menu)
<div class="bg-white p-2 border rounded">
    <div class="d-flex">
        <img src="{{ asset('asset/menus/'.$menu->image) }}" alt="{{ $menu->image }}" width="300px" height="300px">
        <div class="ml-3">
            <h3 class="font-weight-bold">{{ $menu->name }}</h3>
            <p>{{ $menu->description }}</p>
            <p class="font-weight-bold price-text">@currencyRp($menu->price)</p>
            <form method="POST" action="/user/cart" class="d-flex">
                @csrf
                <input type="text" value="{{ $menu->id }}" hidden name="id">
                <button type="submit" class="btn btn-success d-flex align-items-center ml-2">
                    <span class="material-icons">shopping_cart</span>
                    Beli
                </button>
            </form>
        </div>
    </div>
    @endforeach
    <div class="d-flex mt-2">
        <div class="d-flex align-items-center">
            <span>Share : </span>
            <span class="material-icons">facebook</span>
            <span class="material-icons">mail</span>
        </div>
        <div class="line-separator ml-2 mr-2"></div>
        <div class="d-flex align-items-center pointer">
            <span class="material-icons text-danger">favorite</span>
            <span>Favorit</span>
        </div>
    </div>
    <div class="mt-5">
        <h2>Review</h2>
    </div>
</div>
@endsection
