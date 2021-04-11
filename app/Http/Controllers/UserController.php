<?php

namespace App\Http\Controllers;

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
}
