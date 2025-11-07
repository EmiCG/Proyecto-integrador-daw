<div class="comanda bg-white p-4 rounded shadow mb-4 h-full">
    <div class="header mb-2">
        <h3 class="text-lg font-semibold">Comanda</h3>
        <div class="small text-sm text-gray-600">Referencia: {{ $pedido->order_referencia }}</div>
        <div class="small text-sm text-gray-600">Cliente: {{ $pedido->nombre_cliente }} @if($pedido->telefono_cliente) - {{ $pedido->telefono_cliente }}@endif</div>
    </div>

    <div class="items border-t pt-2">
        @foreach($pedido->productos as $producto)
            <div class="item flex justify-between py-2">
                <div>
                    <strong class="block">{{ $producto->nombre ?? $producto->name ?? 'Producto' }}</strong>
                    <div class="small text-sm text-gray-600">x {{ $producto->pivot->cantidad }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        {{-- If order is in preparacion, allow worker to mark it as preparado --}}
        @if($pedido->estado_produccion === 'preparacion')
            <form method="POST" action="{{ route('admin-pedidos.updateStatus', ['id' => $pedido->id]) }}">@csrf
                <input type="hidden" name="estado_produccion" value="preparado" />
                <button type="submit" class="bg-yellow-500 text-white px-3 py-1 rounded">Marcar preparado</button>
            </form>
        @else
            <div class="text-sm text-gray-700">Estado: <span class="font-semibold">{{ $pedido->estado_produccion }}</span></div>
            <a target="_blank" href="{{ route('admin-pedidos.comanda', ['id' => $pedido->id]) }}" class="inline-block mt-2 bg-gray-200 text-gray-800 px-3 py-1 rounded">Imprimir</a>
        @endif
    </div>
</div>
