<x-app-layout>
    <x-slot name='layoutTitle'>
        Caja
    </x-slot>

    <x-slot name='slot'>
        <div class="container mx-auto mt-5">
            <div class="mb-4 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Caja</h1>
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded">Volver al panel</a>
            </div>

            <div class="space-y-4">
                @foreach($pedidos as $pedido)
                    <div class="bg-white p-4 rounded-lg shadow-md flex flex-col md:flex-row md:items-start md:space-x-6">
                        <!-- Left: Order info -->
                        <div class="md:w-1/3">
                            <h3 class="font-semibold text-lg">Referencia: {{ $pedido->order_referencia }}</h3>
                            <div class="text-sm text-gray-600 mt-1">{{ $pedido->nombre_cliente }} @if($pedido->telefono_cliente) • {{ $pedido->telefono_cliente }}@endif</div>
                            <div class="text-sm text-gray-600 mt-2">{{ $pedido->direccion_cliente_escrita }}</div>
                            <div class="mt-3">
                                <span class="inline-block px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Producción: {{ $pedido->estado_produccion }}</span>
                                <span class="inline-block px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 ml-2">Pago: {{ $pedido->estado_pago }}</span>
                            </div>
                        </div>

                        <!-- Middle: Products -->
                        <div class="md:w-1/3 mt-4 md:mt-0">
                            <h4 class="font-medium">Productos</h4>
                            <ul class="mt-2 text-sm space-y-1">
                                @foreach($pedido->productos as $producto)
                                    <li class="flex justify-between">
                                        <span class="text-gray-800">{{ $producto->nombre ?? $producto->name }}</span>
                                        <span class="text-gray-600">x {{ $producto->pivot->cantidad }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Right: Totals & actions -->
                        <div class="md:w-1/3 mt-4 md:mt-0 flex flex-col items-start md:items-end">
                            <div class="text-right">
                                <div class="text-2xl font-semibold">{{ number_format($pedido->totalAmount(),2) }}</div>
                                <div class="text-sm text-gray-600">Subtotal: {{ number_format($pedido->subtotal(),2) }}</div>
                                <div class="text-sm text-gray-600">Envío: {{ number_format($pedido->shipping(),2) }}</div>
                            </div>

                            <div class="w-full md:w-auto mt-4">
                                @if($pedido->estado_produccion === 'preparado')
                                    <form method="POST" action="{{ route('admin-pedidos.updateStatus', ['id' => $pedido->id]) }}">@csrf
                                        <input type="hidden" name="estado_produccion" value="enviado" />
                                        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Marcar enviado</button>
                                    </form>
                                @elseif($pedido->estado_produccion === 'enviado')
                                    <form method="POST" action="{{ route('admin-pedidos.updateStatus', ['id' => $pedido->id]) }}">@csrf
                                        <input type="hidden" name="estado_produccion" value="entregado" />
                                        <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">Marcar entregado</button>
                                    </form>
                                @elseif($pedido->estado_produccion === 'entregado')
                                    <form method="POST" action="{{ route('admin-caja.subtotalize', ['id' => $pedido->id]) }}">@csrf
                                        <label for="efectivo_recibido_{{ $pedido->id }}" class="block text-sm text-gray-700">Efectivo recibido</label>
                                        <input id="efectivo_recibido_{{ $pedido->id }}" step="0.01" type="number" name="efectivo_recibido" class="w-full md:w-48 border rounded px-2 py-1 mt-1" required />
                                        <button type="submit" class="mt-2 w-full md:w-auto bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded">Calcular cambio</button>
                                    </form>

                                    @php $subtotalized = session('subtotalized_'.$pedido->id); @endphp
                                    @if($subtotalized)
                                        <div class="mt-3 text-right">
                                            <div class="text-sm">Efectivo: <span class="font-medium">{{ number_format($subtotalized['efectivo'],2) }}</span></div>
                                            @if(isset($subtotalized['enough']) && $subtotalized['enough'])
                                                <div class="text-sm text-green-700 font-semibold">Cambio: {{ number_format($subtotalized['change'],2) }}</div>
                                            @else
                                                <div class="text-sm text-red-700 font-semibold">Faltan: {{ number_format($subtotalized['short'] ?? 0,2) }}</div>
                                            @endif
                                        </div>

                                        <form method="POST" action="{{ route('admin-caja.processPayment', ['id' => $pedido->id]) }}" class="mt-2">@csrf
                                            <input type="hidden" name="efectivo_recibido" value="{{ $subtotalized['efectivo'] }}" />
                                            @if(isset($subtotalized['enough']) && $subtotalized['enough'])
                                                <button type="submit" class="mt-2 w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Registrar pago y finalizar</button>
                                            @else
                                                <button disabled class="mt-2 w-full opacity-60 bg-blue-600 text-white px-4 py-2 rounded">No se puede registrar: dinero insuficiente</button>
                                            @endif
                                        </form>
                                    @else
                                        <button disabled class="mt-2 w-full opacity-60 bg-blue-600 text-white px-4 py-2 rounded">Registrar pago y finalizar (calcule el cambio)</button>
                                    @endif
                                @else
                                    <div class="text-sm text-gray-600">No hay acciones para este estado.</div>
                                @endif
                            </div>

                            <!-- consolidated summary is shown above in the action area; avoid duplicate rendering here -->
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-slot>
</x-app-layout>
