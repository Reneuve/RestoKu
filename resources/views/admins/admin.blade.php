@extends('layouts.app')

@section('content')
<h1>Welcome to Admin Page {{ Auth::user()->name }}</h1>
<form action="logout" method="post">
    @csrf
    <button type="submit" class="btn btn-danger">
        Log Out
    </button>
</form>
@endsection
