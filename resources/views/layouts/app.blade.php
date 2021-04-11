<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <a class="navbar-brand" href="/">RestoKu</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <a class="dropdown-item" href="#">Action 1</a>
                        <a class="dropdown-item" href="#">Action 2</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="POST" action="logout">
                @csrf
                @auth('admins')
                <span>
                    Admin : {{ Auth::guard('admins')->user()->name }}
                    <button type="submit" class="btn btn-danger">Log Out</button>
                </span>
                @endauth
                @auth('users')
                <span>
                    User : {{ Auth::guard('users')->user()->name }}
                    <button type="submit" class="btn btn-danger">Log Out</button>
                </span>
                @endauth
                @if(!Auth::guard('admins')->check() && !Auth::guard('users')->check())
                    <a href="/admin/login"><button type="button" class="btn btn-primary">Login Admin</button></a>
                    <a href="/user/login"><button type="button" class="btn btn-secondary ml-3">Login User</button></a>
                @endif
            </form>
        </div>
    </nav>
    <main class="p-5">
        @yield('content')
    </main>
</body>
</html>
