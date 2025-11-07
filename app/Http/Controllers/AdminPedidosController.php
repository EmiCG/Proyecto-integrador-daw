<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoResource;
use App\Http\Resources\ProductoResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPedidosController extends Controller
{
    public function index(Request $request){
        // By default show pending pedidos (estado_produccion = 'preparacion')
        $filter = $request->input('filter', 'pending');

    // Show oldest orders first so they appear at the left of the horizontal list
    $query = Order::with('productos')->orderBy('created_at', 'asc');

        if ($filter === 'pending') {
            $query->where('estado_produccion', 'preparacion');
        }

        $pedidos = $query->get();

    // Render the 'Cocina' view (comandas sin precios)
    return view('admin-cocina', ['pedidos' => $pedidos, 'filter' => $filter]);
    }

    /**
     * Search orders by folio (order_referencia)
     */
    public function search(Request $request)
    {
        $folio = $request->input('folio');

        $pedidos = Order::with('productos')
            ->where('order_referencia', 'like', "%{$folio}%")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin-pedidos', ['pedidos' => $pedidos, 'search' => $folio]);
    }

    /**
     * Show an order as a comanda (ticket)
     */
    public function comanda($id)
    {
        $pedido = Order::with('productos')->findOrFail($id);

        return view('pedidos.comanda', ['pedido' => $pedido]);
    }

    /**
     * Update production status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'estado_produccion' => 'required|string|in:preparacion,preparado,enviado,entregado,cancelado,finalizado',
        ]);

        $pedido = Order::findOrFail($id);
        $pedido->estado_produccion = $request->input('estado_produccion');
        $pedido->save();

        return redirect()->back()->with('status', 'Estado de producción actualizado');
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'estado_pago' => 'required|string|in:por pagar,pagado',
        ]);

        $pedido = Order::findOrFail($id);
        $pedido->estado_pago = $request->input('estado_pago');
        $pedido->save();

        return redirect()->back()->with('status', 'Estado de pago actualizado');
    }

    /**
     * Update received quantities (pivot)
     */
    public function updateReceived(Request $request, $id)
    {
        $pedido = Order::with('productos')->findOrFail($id);

        $data = $request->input('received', []); // expected: [product_id => cantidad_recibida]

        DB::transaction(function () use ($pedido, $data) {
            foreach ($data as $productId => $cantidadRecibida) {
                $cantidadRecibida = (int) $cantidadRecibida;
                // Update pivot table; if column doesn't exist this will fail (migration added)
                $pedido->productos()->updateExistingPivot($productId, ['cantidad_recibida' => $cantidadRecibida]);
            }
        });

        return redirect()->back()->with('status', 'Cantidades recibidas actualizadas');
    }

}
