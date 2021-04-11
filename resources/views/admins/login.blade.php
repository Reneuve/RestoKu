@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center">
    <div class="card">
        <img class="card-img-top" src="holder.js/100x180/" alt="">
        <div class="card-header">
            <h4>Login Admin</h4>
        </div>
        <form action="/admin/login" method="POST">
            @csrf
            @if($errors->any())
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </div>
            @endif
            <div class="card-body">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" aria-describedby="Email" placeholder="JohnDoe@gmail.com">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="******">
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center flex-column">
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <span>Belum punya akun?
                    <a href="/admin/register">Daftar Sekarang</a>
                </span>
            </div>
        </form>
    </div>
</div>
@endsection
