<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CajaController extends Controller
{
    public function index()
    {
        $pedidos = Order::with('productos')
            ->whereIn('estado_produccion', ['preparado', 'enviado', 'entregado'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin-caja', ['pedidos' => $pedidos]);
    }

    public function processPayment(Request $request, $id)
    {
        $request->validate([
            'efectivo_recibido' => 'required|numeric|min:0',
        ]);

        $pedido = Order::findOrFail($id);

        if ($pedido->estado_produccion !== 'entregado') {
            return redirect()->back()->with('error', 'El pedido debe estar en estado "entregado" para registrar el pago.');
        }

        $efectivo = (float) $request->input('efectivo_recibido');

        $pedido->recordPayment($efectivo);
        $pedido->estado_produccion = 'finalizado';
        $pedido->save();

        return redirect()->back()->with('status', 'Pago registrado y pedido finalizado');
    }

    public function subtotalize(Request $request, $id)
    {
        $request->validate([
            'efectivo_recibido' => 'required|numeric|min:0',
        ]);

        $pedido = Order::findOrFail($id);

        if ($pedido->estado_produccion !== 'entregado') {
            return redirect()->back()->with('error', 'El pedido debe estar en estado "entregado" para calcular el cambio.');
        }

            $efectivo = (float) $request->input('efectivo_recibido');

            // Compute amounts
            $total = $pedido->totalAmount();
            $difference = $efectivo - $total;

            // If the customer gave less than the total, record how much is missing (short)
            if ($difference < 0) {
                session()->flash('subtotalized_'.$pedido->id, [
                    'efectivo' => $efectivo,
                    'change' => 0.0,
                    'short' => round(abs($difference), 2),
                    'enough' => false,
                ]);

                return redirect()->back()->with('error', 'El dinero entregado no alcanza para cubrir el total.');
            }

            // Enough cash: compute change normally
            $change = $pedido->computeChange($efectivo);
            session()->flash('subtotalized_'.$pedido->id, [
                'efectivo' => $efectivo,
                'change' => $change,
                'short' => 0.0,
                'enough' => true,
            ]);

            return redirect()->back()->with('status', 'Cambio calculado');
    }

    public function finalize(Request $request, $id)
    {
        $user = Auth::user();
        if (! $user || ! in_array($user->role ?? '', ['caja', 'admin'])) {
            abort(403, 'No autorizado');
        }

        $pedido = Order::findOrFail($id);
        $pedido->estado_produccion = 'finalizado';
        $pedido->save();

        return redirect()->back()->with('status', 'Pedido finalizado');
    }
}
