<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/login', function () {
    return view('users.login');
})->name('login')->middleware('guest');

Route::get('user/register', function () {
    return view('users.register');
});

Route::get('user', function () {
    return view('users.user');
})->middleware('auth:users');

Route::post('user/register', [UserController::class, 'Register']);

Route::post('user/login', [UserController::class, 'Login']);

// Admin

Route::get('admin/login', function () {
    return view('admins.login');
})->middleware('guest');

Route::get('admin/register', function () {
    return view('admins.register');
});

Route::get('admin', function () {
    return view('admins.admin');
})->middleware('auth:admins');

Route::post('admin/register', [AdminController::class, 'Register']);

Route::post('admin/login', [AdminController::class, 'Login']);

Route::post('logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});
