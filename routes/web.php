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
    Route::get('/', [menuViewController::class, 'index'])->name('menu-view.index');
    Route::get('/{id}',[menuViewController::class, 'show'])->name('menu-view.show');
}); 

Route::middleware(['web'])->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout']);
});



Route::prefix('admin')->group(function () {

    Route::get('/', function () { return 'panel de administracion';});

        Route::prefix('productos')->group(function(){

            Route::get('/', [AdminProductosController::class, 'index'])->name('admin-view.index');

            Route::get('/{id}', [AdminProductosController::class, 'show'])->name('admin-view.show');

            Route::get('/create', [AdminProductosController::class, 'create'])->name('admin-create-view.create');

            Route::post('/create', [AdminProductosController::class, 'store'])->name('admin.store');

            //Route::get('/edit/{id}', [AdminProductosController::class, 'edit'])->name('admin-edit-view.edit');
            
            Route::put('/edit/{id}', [AdminProductosController::class, 'update'])->name('admin.update');

            Route::delete('/delete/{id}', [AdminProductosController::class, 'destroy'])->name('admin.destroy');

    });

        Route::prefix('pedidos')->group(function(){

        Route::get('/', [AdminPedidosController::class, 'index'])->name('admin-pedidos.index');

        
        });
    
}); 