<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    {{-- Icon Google --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    {{-- End --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('title')
    <script>
        var message = '';
        var number = 0;
        Echo.channel('Transaction')
            .listen('.NewTransactionMessage', (e) => {
                message += `
                <a href='/admin/order/${e.id}'>
                        Pelanggan <strong>${e.name}</strong> memesan menu
                        dengan total belanja <strong>Rp.${e.amount}</strong>
                        pada meja nomor <strong>${e.table_number}</strong>
                    </a>
                `;
                number++;
                $("#dropdown-notif-content").html(message);
                $("#number-notif").show();
                $("#number-notif").html(number)
            })
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
        <a class="navbar-brand" href="/admin">Dashboard</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0 text-white">
                <li>| {{ Auth::user()->name }}</li>
            </ul>
            <form method="POST" action="/logout" class="form-inline my-2 my-lg-0">
                @csrf
                <span class="material-icons text-white pointer mr-3">settings</span>
                <div class="dropdown-notif">
                    <div class="number-notif" id="number-notif"></div>
                    <span class="material-icons text-white pointer mr-3 notif-btn">notifications</span>
                    <div class="dropdown-notif-body">
                        <p>Notifikasi</p>
                        <hr>
                        <div id="dropdown-notif-content"></div>
                    </div>
                </div>
                <button class="btn btn-danger mt-2" type="submit">Logout</button>
            </form>
        </div>
    </nav>
    {{-- Main --}}
    <div class="d-flex">
        <div class="left-nav bg-primary">
            <p class="subtitle text-white font-weight-bold text-underline">
                Pesanan
            </p>
            <ul class="list-group left-nav-list">
                <a href="/admin/order">
                    <li class="list-group-item list-group-item-action pointer d-flex align-items-center">
                        <span class="material-icons mr-2">
                            list_alt
                        </span>
                        Daftar Pesanan
                    </li>
                </a>
            </ul>
            <p class="subtitle text-white font-weight-bold text-underline">
                Menu
            </p>
            <ul class="list-group left-nav-list">
                <a href="/admin/menu">
                    <li class="list-group-item list-group-item-action pointer d-flex align-items-center">
                        <span class="material-icons mr-2">
                            menu_book
                        </span>
                        Daftar Menu
                    </li>
                </a>
                <a href="/admin/menu/create">
                    <li class="list-group-item list-group-item-action pointer d-flex align-items-center">
                        <span class="material-icons mr-2">
                            add_box
                        </span>
                        Tambah Menu
                    </li>
                </a>
                <a href="">
                    <li class="list-group-item list-group-item-action pointer d-flex align-items-center">
                        <span class="material-icons mr-2">
                            history
                        </span>
                        Riwayat Menu
                    </li>
                </a>
            </ul>
        </div>
        <main class="p-3 bg-white w-100">
            @yield('content')
        </main>
    </div>
</body>

</html>
