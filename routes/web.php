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

    // Show login form
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

    // Authentication actions
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // Also accept GET for logout links (some templates use anchor tags).
    // Note: POST with CSRF is recommended; GET is provided for convenience.
    Route::get('/logout', [LoginController::class, 'logout']);
});



Route::prefix('admin')->middleware(['web', 'auth'])->group(function () {

    Route::get('/', function () { return 'panel de administracion';});

    Route::prefix('productos')->group(function(){

            Route::get('/', [AdminProductosController::class, 'index'])->name('admin-view.index');

            Route::get('/{id}', [AdminProductosController::class, 'show'])->name('admin-view.show');

            Route::get('/create', [AdminProductosController::class, 'create'])->name('admin-create-view.create');

            Route::post('/create', [AdminProductosController::class, 'store'])->name('admin.store');

            
            Route::put('/edit/{id}', [AdminProductosController::class, 'update'])->name('admin.update');

            Route::delete('/delete/{id}', [AdminProductosController::class, 'destroy'])->name('admin.destroy');

    });

    Route::prefix('pedidos')->group(function(){

        Route::get('/', [AdminPedidosController::class, 'index'])->name('admin-pedidos.index');

    });

    Route::prefix('pedidos')->group(function(){

        Route::get('/', [AdminPedidosController::class, 'index'])->name('admin-pedidos.index');

    });
});