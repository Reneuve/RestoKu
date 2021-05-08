<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cart_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function Register(Request $request)
    {
        # code...
        $this->validate($request, [
            'name' => 'required|min:6',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);
        DB::table('users')->insert([
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
        if (Auth::guard('users')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->intended('/user');
        } else {
            return redirect()->back()->withErrors('Account Not Found');
        }
    }

        public function cartBuy(Request $request)
    {
        # code...
        $user = Auth::guard('users')->user(); //untuk mengambil data user
        $cart = Cart::where('user_id', $user->id)->where('already_paid', 0)->first(); //untuk mengambil data cart
        if (!$cart) {
            // Jika belum membikin cart
            // Untuk Membikin
            $cartNew = new Cart();
            $cartNew->user_id = $user->id;
            $cartNew->save();
            // End
            // Untuk Menambah Cart_item
            $cartItems = new Cart_item();
            $cartItems->cart_id = $cartNew->id;
            $cartItems->menu_id = $request->id;
            $cartItems->quantity = 1;
            $cartItems->save();
            // End
        } else {
            // Jika sudah memasukan menu yang sama ke cart
            $cartItems = Cart_item::where('cart_id', $cart->id)->where('menu_id', $request->id)->first(); //untuk mengambil data cart_item

            if (!$cartItems) {
                // Jika menu belum ada
                $newCartItems = new Cart_item();
                $newCartItems->cart_id = $cart->id;
                $newCartItems->menu_id = $request->id;
                $newCartItems->save();
            } else {
                // Jika menu sudah ada tinggal kita update
                Cart_item::where('cart_id', $cart->id)->where('menu_id', $request->id)
                    ->update([
                        'quantity' => ($cartItems->quantity + 1),
                    ]);
            }
        }
        return $this->getCart($request);
    }

    public function getCart(Request $request)
    {
        # code...
        $user = Auth::guard('users')->user();
        $cart = Cart::where('user_id', $user->id)->where('already_paid', 0)->first();
        if ($cart) {
            $cartItems = DB::table('cart_items')
                ->where('cart_id', $cart->id)
                ->join('menus', 'cart_items.menu_id', '=', 'menus.id')
                ->select('cart_items.*', 'menus.name', 'menus.price', 'menus.image')->get();;
            return view('users.cart', ['items' => $cartItems]);
        } else {
            return view('users.cart')->with('result', 'Ups anda belum memasukan menu apapun ke keranjang anda');
        }
    }

    public function addItem(Request $request)
    {
        # code...
        $user = Auth::guard('users')->user();
        $cart = Cart::where('user_id', $user->id)->where('already_paid', 0)->first();
        $cartItems = Cart_item::where('cart_id', $cart->id)->where('menu_id', $request->id)->first();
        Cart_item::where('menu_id', $request->id)->where('cart_id', $cart->id)
            ->update([
                'quantity' => ($cartItems->quantity + 1),
            ]);
        return redirect()->back();
    }

    public function removeItem(Request $request)
    {
        # code...
        $user = Auth::guard('users')->user();
        $cart = Cart::where('user_id', $user->id)->where('already_paid', 0)->first();
        $cartItems = Cart_item::where('cart_id', $cart->id)->where('menu_id', $request->id)->first();
        if ($cartItems->quantity > 1) {
            # code...
            Cart_item::where('menu_id', $request->id)->where('cart_id', $cart->id)
                ->update([
                    'quantity' => ($cartItems->quantity - 1),
                ]);
        } else {
            Cart_item::where('menu_id', $request->id)->where('cart_id', $cart->id)->delete();
        }
        return redirect()->back();
    }
}
