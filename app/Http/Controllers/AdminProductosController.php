<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductoResource; 

class AdminProductosController extends Controller
{
    public function index()
    {
        $productos = Product::with('pedidos')->orderBy('id', 'asc')->get();
        return ProductoResource::collection($productos); 
    }

    public function show($id) 
    {
        $producto = Product::find($id);
        return new ProductoResource($producto);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
        ]);

        $producto = Product::create($request->json()->all()); // Obtiene los datos JSON del cuerpo
        return new ProductoResource($producto, 201); // Devuelve el producto creado con código 201 Created
    }

    public function update(Request $request, $id)
    {
        $producto = Product::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404); 
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
        ]);

        $producto->update($request->json()->all()); 
        return new ProductoResource($producto);
    }

    public function destroy($id)
    {
        $producto = Product::find($id);
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado correctamente'], 204); 
    }

}