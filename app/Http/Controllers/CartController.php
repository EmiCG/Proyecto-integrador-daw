<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    protected $sessionKey = 'cart';

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:productos,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);

        $cart = session()->get($this->sessionKey, []);

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        session()->put($this->sessionKey, $cart);

        return redirect()->back()->with('status', 'Producto añadido al carrito');
    }

    public function view()
    {
        $cart = session()->get($this->sessionKey, []);

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        return view('cart', ['cart' => $cart, 'products' => $products]);
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required|integer|exists:productos,id']);

        $cart = session()->get($this->sessionKey, []);
        $productId = $request->input('product_id');

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put($this->sessionKey, $cart);
        }

        return redirect()->back()->with('status', 'Producto removido del carrito');
    }

    public function checkoutForm()
    {
        $cart = session()->get($this->sessionKey, []);
        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'El carrito está vacío');
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        return view('checkout', ['cart' => $cart, 'products' => $products]);
    }

    public function confirmCheckout(Request $request)
    {
        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'telefono_cliente' => 'required|string|max:50',
            'direccion_cliente_escrita' => 'nullable|string|max:500',
        ]);

        $cart = session()->get($this->sessionKey, []);
        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'El carrito está vacío');
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        // Calculate total
        $total = 0;
        foreach ($cart as $pid => $qty) {
            $prod = $products->get($pid);
            if ($prod) {
                $total += $prod->precio * $qty;
            }
        }

        $order = Order::create([
            'nombre_cliente' => $request->input('nombre_cliente'),
            'telefono_cliente' => $request->input('telefono_cliente'),
            'direccion_cliente_escrita' => $request->input('direccion_cliente_escrita', ''),
            'direccion_cliente_ubicacion' => '',
            'order_referencia' => strtoupper(Str::random(8)),
            'total' => $total,
        ]);

        // Attach products to pivot
        foreach ($cart as $pid => $qty) {
            $prod = $products->get($pid);
            if ($prod) {
                $order->productos()->attach($pid, ['cantidad' => $qty, 'precio_unitario' => $prod->precio]);
            }
        }

        // Clear cart
        session()->forget($this->sessionKey);

        // Show success page with order reference
        return view('checkout-success', ['order' => $order]);
    }
}
