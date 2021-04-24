@extends('layouts.admin')

@section('title')
    <title>Daftar Menu</title>
@endsection

@section('content')
    <h1>Daftar Menu</h1>
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menus as $key => $menu)
                <tr>
                    <td scope="row">{{ $menus->firstItem() + $key }}</td>
                    <td>{{ $menu->name }}</td>
                    <td> @currencyRp($menu->price) </td>
                    <td>{{ $menu->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                    <td>
                        @if ($menu->is_active == 1)
                            <a href="/admin/menu/nonactive/{{ $menu->id }}"> <span
                                    class="material-icons text-secondary">cancel</span> </a>
                        @else
                            <a href="/admin/menu/active/{{ $menu->id }}"> <span
                                    class="material-icons text-success">check_circle</span> </a>
                        @endif
                        <a href="/admin/menu/update/{{ $menu->id }}"> <span
                                class="material-icons text-primary">edit</span></a>
                        <a href="/admin/menu/delete/{{ $menu->id }}"> <span
                                class="material-icons text-danger">delete</span></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $menus->links() }}
    </div>
@endsection
