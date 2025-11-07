<x-app-layout>
    <x-slot name='layoutTitle'>Checkout</x-slot>
    <x-slot name='slot'>
        <div class="container mx-auto mt-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 bg-white rounded shadow p-6">
                    <h2 class="text-2xl font-bold mb-4">Datos de envío y contacto</h2>

                    <form method="POST" action="{{ route('checkout.confirm') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nombre del cliente</label>
                            <input type="text" name="nombre_cliente" class="w-full border px-3 py-2 rounded mt-1" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="text" name="telefono_cliente" class="w-full border px-3 py-2 rounded mt-1" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Dirección (si aplica)</label>
                            <textarea name="direccion_cliente_escrita" class="w-full border px-3 py-2 rounded mt-1"></textarea>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">Confirmar pedido</button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Resumen de compra</h3>
                    <ul class="divide-y">
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $pid => $qty)
                            @php $p = $products->get($pid); @endphp
                            @if($p)
                                @php $line = $p->precio * $qty; $subtotal += $line; @endphp
                                <li class="py-2 flex justify-between text-sm">
                                    <span>{{ $p->nombre }} x {{ $qty }}</span>
                                    <span>${{ number_format($line,2) }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                    <div class="mt-4 border-t pt-3">
                        <div class="flex justify-between font-semibold">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal,2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600 mt-2">
                            <span>Envío</span>
                            <span>--</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold mt-4">
                            <span>Total</span>
                            <span>${{ number_format($subtotal,2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
