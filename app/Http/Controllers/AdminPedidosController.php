<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoResource;
use App\Http\Resources\ProductoResource;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminPedidosController extends Controller
{
    
    public function index(){
        $pedidos = Order::with('productos')->orderBy('created_at', 'desc')->get();

        return PedidoResource::collection($pedidos); 
    }

}
