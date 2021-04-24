@extends('layouts.admin')

@section('title')
<title>Tambah Menu</title>
@endsection

@section('content')
<h2>Tambah Menu</h2>
@if ($errors->any())
<div class="alert alert-danger" role="alert">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</div>
@endif
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    <li>{{ Session::get('success') }}</li>
</div>
@endif
<form action="/admin/menu/create" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Nama</label>
        <input type="text" class="form-control" name="name" placeholder="Nasi Goreng" required>
    </div>
    <div class="form-group">
        <label for="price">Harga</label>
        <input type="number" class="form-control" name="price" placeholder="5000" required>
    </div>
    <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea class="form-control" name="description" rows="4" required></textarea>
    </div>
    <label for="image">Gambar</label><br>
    <img id="output" src="{{ asset('asset/menu_def.png') }}" alt="Foto Menu" height="100px" class="border mb-3">
    <div class="form-group d-flex flex-column">
        <input onchange="document.getElementById('output').src=window.URL.createObjectURL(this.files[0])" type="file" name="image" accept="image/*">
        <small id="helpId" class="form-text text-muted">Max : 2mb</small>
    </div>
    <button type="submit" class="btn btn-primary">
        Save
    </button>
</form>
@endsection
