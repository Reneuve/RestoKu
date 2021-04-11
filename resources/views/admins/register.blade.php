@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center">
    <div class="card">
        <img class="card-img-top" src="holder.js/100x180/" alt="">
        <div class="card-header">
            <h4>Register Admin</h4>
        </div>
        <form action="/admin/register" method="POST">
            @csrf
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            @if(Session::has('msg'))
                <div class="alert alert-success" role="alert">
                    <li>{{ Session::get('msg') }}</li>
                </div>
            @endif
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" aria-describedby="Name" placeholder="JohnDoe">
                </div>
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
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </div>
        </form>
    </div>
</div>
@endsection
