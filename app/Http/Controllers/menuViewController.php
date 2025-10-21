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
        return ProductoResource::collection($productos); // Devuelve la colección de productos como JSON para que el front pueda consumirlo
    }

    public function show($id){
        $producto = Product::find($id);
        return new ProductoResource($producto);
    }

}