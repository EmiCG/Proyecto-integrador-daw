<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\menuViewController;
use App\Http\Controllers\AdminProductosController;
use App\Http\Controllers\AdminPedidosController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//Route::get('/', function () {
//     return view('welcome');
//});

Route::prefix('menu')->group(function(){
    Route::get('/', [menuViewController::class, 'index'])->name('menu');
    Route::get('/{id}',[menuViewController::class, 'show'])->name('menu.show');
}); 

Route::middleware(['web'])->group(function () {
    Route::get('/csrf-token', function () {
        return response()->json(['csrf_token' => csrf_token()]);
    });

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/logout', [LoginController::class, 'logout']);
});



Route::prefix('admin')->middleware(['web', 'auth'])->group(function () {

    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');

    Route::prefix('productos')->group(function(){

            Route::get('/', [AdminProductosController::class, 'index'])->name('admin-view.index');

            Route::get('/{id}', [AdminProductosController::class, 'show'])->name('admin-view.show')->middleware(\App\Http\Middleware\EnsureRole::class . ':admin');

            Route::get('/create', [AdminProductosController::class, 'create'])->name('admin-create-view.create')->middleware(\App\Http\Middleware\EnsureRole::class . ':admin');

            Route::post('/create', [AdminProductosController::class, 'store'])->name('admin.store')->middleware(\App\Http\Middleware\EnsureRole::class . ':admin');

            
            Route::put('/edit/{id}', [AdminProductosController::class, 'update'])->name('admin.update')->middleware(\App\Http\Middleware\EnsureRole::class . ':admin');

            Route::delete('/delete/{id}', [AdminProductosController::class, 'destroy'])->name('admin.destroy')->middleware(\App\Http\Middleware\EnsureRole::class . ':admin');

    });

    Route::prefix('pedidos')->group(function(){

        Route::get('/', [AdminPedidosController::class, 'index'])->name('admin-pedidos.index');

        Route::get('/search', [AdminPedidosController::class, 'search'])->name('admin-pedidos.search');

        Route::get('/{id}/comanda', [AdminPedidosController::class, 'comanda'])->name('admin-pedidos.comanda');

        Route::post('/{id}/status', [AdminPedidosController::class, 'updateStatus'])->name('admin-pedidos.updateStatus');

        Route::post('/{id}/payment', [AdminPedidosController::class, 'updatePaymentStatus'])->name('admin-pedidos.updatePayment');

        Route::post('/{id}/received', [AdminPedidosController::class, 'updateReceived'])->name('admin-pedidos.updateReceived');

    });
    
    Route::get('/settings', [App\Http\Controllers\AdminController::class, 'settings'])->name('admin.settings')->middleware(\App\Http\Middleware\EnsureRole::class . ':admin');
    
    Route::prefix('caja')->middleware(\App\Http\Middleware\EnsureRole::class . ':trabajador|admin')->group(function(){
        Route::get('/', [App\Http\Controllers\CajaController::class, 'index'])->name('admin-caja.index');
        Route::post('/{id}/payment', [App\Http\Controllers\CajaController::class, 'processPayment'])->name('admin-caja.processPayment');
    Route::post('/{id}/subtotalize', [App\Http\Controllers\CajaController::class, 'subtotalize'])->name('admin-caja.subtotalize');
        Route::post('/{id}/finalize', [App\Http\Controllers\CajaController::class, 'finalize'])->name('admin-caja.finalize');
    });
});

Route::middleware(['web'])->group(function () {
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'view'])->name('cart.view');
    Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout/confirm', [App\Http\Controllers\CartController::class, 'confirmCheckout'])->name('checkout.confirm');
});