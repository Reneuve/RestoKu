<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function Register(Request $request)
    {
        # code...
        $this->validate($request, [
            'name' => 'required|min:6',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6'
        ]);
        DB::table('admins')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->back()->with('msg', 'Pendaftaran dengan email ' . $request->email . ' telah berhasil');
    }
    public function Login(Request $request)
    {
        # code...
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::guard('admins')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->intended('/admin');
        } else {
            return redirect()->back()->withErrors('Account Not Found');
        }
    }
    public function order_view(Request $request)
    {
        # code...
        if (isset($request->sort)) {
            // Jika disortir
            $data = DB::table('transactions')
                ->join('carts', 'carts.id', '=', 'transactions.cart_id')
                ->join('users', 'users.id', '=', 'carts.user_id')
                ->select('*', DB::raw('(SELECT COUNT(*) FROM cart_items CI WHERE CI.cart_id=carts.id) AS total_menu'), 'transactions.id as transaction_id')
                ->where('carts.is_finish', 0)
                ->orderBy('transactions.order_at', $request->sort)
                ->paginate(20);
        } else {
            // Jika tidak disortir
            $data = DB::table('transactions')
                ->join('carts', 'carts.id', '=', 'transactions.cart_id')
                ->join('users', 'users.id', '=', 'carts.user_id')
                ->select('*', DB::raw('(SELECT COUNT(*) FROM cart_items CI WHERE CI.cart_id=carts.id) AS total_menu'), 'transactions.id as transaction_id')
                ->where('carts.is_finish', 0)
                ->paginate(20);
        }
        // return $data;
        return view('admins.order.view', ['datas' => $data]);
    }

    public function detail_order(Request $request)
    {
        # code...
        $transaction = DB::table('transactions')
            ->join('carts', 'carts.id', '=', 'transactions.cart_id')
            ->join('users', 'users.id', '=', 'carts.user_id')
            ->select(
                '*',
                DB::raw('(SELECT COUNT(*) FROM cart_items CI WHERE CI.cart_id=carts.id) AS total_menu'),
                DB::raw('(SELECT COUNT(*) FROM cart_items CI WHERE CI.cart_id=carts.id AND CI.status<>"Selesai") AS not_finished_order'),
                'transactions.id as transaction_id'
            )
            ->where('transactions.id', $request->id)
            ->get();
        $transaction_data = json_decode($transaction, true)[0]; //mengubah object menjadi array
        // return gettype($transaction); cek type data
        $menus = DB::table('cart_items')
            ->join('menus', 'menus.id', '=', 'cart_items.menu_id')
            ->where('cart_items.cart_id', $transaction_data["cart_id"])
            ->select('*', 'cart_items.id as cart_items_id')
            ->paginate(15);
        // return $menus;
        return view('admins.order.detail', ['transactions' => $transaction, 'menus' => $menus]);
    }

    public function update_status_order(Request $request)
    {
        # code...
        $statusThen = "Menunggu"; //status awal
        $menu = DB::table('cart_items')->where('id', $request->id)->get();
        $menuJson = json_decode($menu, true)[0];

        if ($menuJson["status"] == "Menunggu") {
            //jika status saat ini menunggu maka selanjutnya akan diproses
            $statusThen = "Diproses";
        } else if ($menuJson["status"] == "Diproses") {
            //jika status saat ini menunggu maka selanjutnya akan selesai
            $statusThen = "Selesai";
        } else {
            $statusThen = "Menunggu";
        }
        DB::table('cart_items')->where('id', $request->id)->update([
            'status' => $statusThen
        ]);
        return redirect()->back();
    }
}
