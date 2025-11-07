<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Comanda - Pedido #{{ $pedido->order_referencia }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .comanda { width: 320px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 10px; }
        .items { border-top: 1px dashed #000; margin-top: 8px; }
        .item { display:flex; justify-content:space-between; padding:4px 0; }
        .totales { border-top:1px solid #000; margin-top:8px; padding-top:8px; }
        .small { font-size:0.9em; color:#555 }
        input[type="number"] { width:70px }
    </style>
</head>
<body>
    <div class="comanda">
        <div class="header">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                <h3 style="margin:0">Comanda</h3>
                <a style="background:#e5e7eb;padding:6px 10px;border-radius:6px;color:#111;text-decoration:none" href="{{ route('admin.dashboard') }}">Volver al panel</a>
            </div>
            <div class="small">Referencia: {{ $pedido->order_referencia }}</div>
            <div class="small">Cliente: {{ $pedido->nombre_cliente }} - {{ $pedido->telefono_cliente }}</div>
            <div class="small">Dirección: {{ $pedido->direccion_cliente_escrita }}</div>
        </div>

        <div class="items">
            @foreach($pedido->productos as $producto)
                <div class="item">
                    <div>
                        <strong>{{ $producto->nombre ?? $producto->name ?? 'Producto' }}</strong>
                        <div class="small">x {{ $producto->pivot->cantidad }} @ {{ number_format($producto->pivot->precio_unitario,2) }}</div>
                    </div>
                    <div style="text-align:right">
                        <div>Total: {{ number_format($producto->pivot->cantidad * $producto->pivot->precio_unitario,2) }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="totales">
            <div>Subtotal: {{ number_format($pedido->calcularTotal(),2) }}</div>
        </div>

        <div style="margin-top:12px">
            <form method="POST" action="{{ url("/admin/pedidos/{$pedido->id}/status") }}">@csrf
                <label for="estado_produccion_{{ $pedido->id }}">Estado producción:</label>
                <select id="estado_produccion_{{ $pedido->id }}" name="estado_produccion">
                        <option value="preparacion" {{ $pedido->estado_produccion=='preparacion'?'selected':'' }}>Preparación</option>
                        <option value="preparado" {{ $pedido->estado_produccion=='preparado'?'selected':'' }}>Preparado</option>
                        <option value="enviado" {{ $pedido->estado_produccion=='enviado'?'selected':'' }}>Enviado</option>
                        <option value="entregado" {{ $pedido->estado_produccion=='entregado'?'selected':'' }}>Entregado</option>
                        <option value="cancelado" {{ $pedido->estado_produccion=='cancelado'?'selected':'' }}>Cancelado</option>
                </select>
                <button type="submit">Actualizar estado</button>
            </form>
            <a target="_blank" href="{{ url("/admin/pedidos/{$pedido->id}/comanda") }}">Imprimir comanda</a>
        </div>
    </div>
</body>
</html>
