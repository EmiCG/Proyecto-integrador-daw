<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductoResource;
use App\Models\Product;
use Illuminate\Http\Request;

class menuViewController extends Controller
{
    public function index()
    {
        $productos = Product::with('pedidos')->orderBy('id', 'asc')->get();

        // Render blade view for web (menu-view.blade.php)
        return view('menu-view', ['productos' => $productos]);
    }

    public function show($id){
        $producto = Product::find($id);

        // Reuse the menu view by passing a collection with a single product
        return view('menu-view', ['productos' => collect([$producto])]);
    }

}