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
        return view('admin-view', ['productos' => $productos]);
    }

    /**
     * Show create product form.
     */
    public function create()
    {
        return view('admin-create-product-view');
    }

    public function show($id)
    {
        $producto = Product::find($id);
        return view('admin-edit-product-view', ['producto' => $producto]);
    }

    public function store(Request $request)
    {
        // Support form submissions (Blade) and JSON API
        if ($request->isJson()) {
            $data = $request->json()->all();
        } else {
            // admin-create-product-view uses 'nombre_producto' as field name
            $data = [
                'nombre' => $request->input('nombre', $request->input('nombre_producto')),
                'descripcion' => $request->input('descripcion'),
                'precio' => $request->input('precio'),
            ];
        }

        $validator = validator($data, [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $producto = Product::create($data);

        if ($request->wantsJson()) {
            return response()->json($producto, 201);
        }

        return redirect()->route('admin-view.index');
    }

    public function update(Request $request, $id)
    {
        $producto = Product::find($id);

        if (!$producto) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Producto no encontrado'], 404);
            }
            return back()->with('error', 'Producto no encontrado');
        }

        if ($request->isJson()) {
            $data = $request->json()->all();
        } else {
            $data = [
                'nombre' => $request->input('nombre', $request->input('nombre_producto')),
                'descripcion' => $request->input('descripcion'),
                'precio' => $request->input('precio'),
            ];
        }

        $validator = validator($data, [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $producto->update($data);

        if ($request->wantsJson()) {
            return response()->json($producto);
        }

        return redirect()->route('admin-view.index');
    }

    public function destroy(Request $request, $id)
    {
        $producto = Product::find($id);
        if ($producto) {
            $producto->delete();
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Producto eliminado correctamente'], 204);
        }

        return redirect()->route('admin-view.index');
    }

}