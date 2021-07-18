<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Models\Menu;
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
})->middleware('guest');

Route::post('logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});

Route::get('user/login', function () {
    return view('users.login');
})->name('login')->middleware('guest');

Route::get('user/register', function () {
    return view('users.register');
});

Route::middleware('auth:users')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', function () {
            return view('users.user');
        });
        Route::prefix('cart')->group(function () {
            Route::get('/', [UserController::class, 'getCart']);
            Route::post('/', [UserController::class, 'cartBuy']);
            Route::get('add/{id}', [UserController::class, 'addItem']);
            Route::get('remove/{id}', [UserController::class, 'removeItem']);
            Route::get('clear/{id}', [UserController::class, 'clearCart']);
        });
        //
        Route::post('transaction', [UserController::class, 'transaction']);
        Route::get('history', [UserController::class, 'history']);
        Route::get('history/{id}', [UserController::class, 'historyDetail']);
    });
});

Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'viewUser']); // sama dengan /menu
    Route::get('/{id}', [MenuController::class, 'detail']);
});

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

Route::middleware('auth:admins')->group(function () {
    Route::prefix('admin')->group(function () {
        // 'restoku/admin/'
        Route::prefix('menu')->group(function () {
            // 'restoku/admin/menu'
            Route::get('/', [MenuController::class, 'view']);
            Route::get('/create', function () {
                return view('admins.menu.create');
            }); // restoku/admin/menu/create
            Route::post('/create', [MenuController::class, 'create']);
            Route::get('/update/{id}', [MenuController::class, 'updateView']);
            Route::post('/update', [MenuController::class, 'update']);
            Route::get('/delete/{id}', [MenuController::class, 'delete']);
            Route::get('/active/{id}', [MenuController::class, 'activeMenu']);
            Route::get('/nonactive/{id}', [MenuController::class, 'nonActiveMenu']);
        });
        Route::prefix('order')->group(function () {
            Route::get('/', [AdminController::class, 'order_view']);
            Route::get('/{id}',[AdminController::class,'detail_order']);
            Route::post('/update',[AdminController::class,'update_order']);
            Route::get('/status/{id}',[AdminController::class,'update_status_order']);
        });
    });
    // admin/order
});
