@extends('layouts.app')

@section('title')
<title>Daftar Menu | Restoku</title>
@endsection

@section('content')
<h1>
    <img src="{{ asset('asset/catering.png') }}" alt="Menu" width="50" height="50">
    Menu
</h1>
<form action="/menu" method="get">
    <div class="input-group mb-3">
        <input type="text" name="name" class="form-control" placeholder="Nama Menu" aria-label="Nama Menu" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
                Cari
            </button>
        </div>
        <input type="text" name='dir' hidden value="{{ Request::get('dir') }}">
        <input type="text" name='sort' hidden value="{{ Request::get('sort') }}">
    </div>
</form>
<div class="d-flex justify-content-between">
    <div class="left-tab-menu p-2">
        <span class="d-flex align-items-center text-white">
            <span class="material-icons mr-2">sort_by_alpha</span>
            <a href="/menu?sort=name&&dir={{ Request::get('dir')=='asc'?'desc':'asc' }}&&name={{ Request::get('name') }}" class="text-white">
                Sort by name
            </a>
        </span>
        <span class="d-flex align-items-center text-white">
            <span class="material-icons mr-2">sort</span>
            <a href="/menu?sort=price&&dir={{ Request::get('dir')=='asc'?'desc':'asc' }}&&name={{ Request::get('name') }}" class="text-white">
                Sort by price
            </a>
        </span>
        <span class="d-flex align-items-center text-white">
            <span class="material-icons mr-2">clear</span>
            <a href="/menu" class="text-white">
                Reset Filter
            </a>
        </span>
    </div>
    <div class="w-100 d-flex flex-column menu-content align-items-center">
        <div class="d-flex flex-wrap">
            @if(isset($notfound))
            {{-- Tidak Ditemukan --}}
            <h2 class="text-secondary">{{ $notfound }}</h2>
            @else
            {{-- Menu Ditemukan --}}
            @foreach ($menus as $menu)
            <div class="card card-menu pointer">
                <img class="card-img-top" src="{{ asset('asset/menus/'.$menu->image) }}" alt="{{ $menu->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $menu->name }}</h5>
                    <div class="card-description">{{ $menu->description }}</div>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold">
                        @currencyRp($menu->price)
                    </span>
                    <form action="/user/cart" method="POST" class="d-flex">
                        @csrf
                        <a href="/menu/{{ $menu->id }}" class="btn btn-primary d-flex align-items-center">
                            <span class="material-icons">info</span>
                            Detail
                        </a>
                        <input type="text" value="{{ $menu->id }}" hidden name='id'>
                        <button type="submit" class="btn btn-success d-flex align-items-center ml-2">
                            <span class="material-icons">shopping_cart</span>
                            Beli
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
            @endif
        </div>
        @if(isset($menus))
        {{ $menus->links() }}
        @endif
    </div>
</div>
@endsection
