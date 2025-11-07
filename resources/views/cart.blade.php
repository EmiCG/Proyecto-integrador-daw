<x-app-layout>
    <x-slot name='layoutTitle'>Carrito</x-slot>

    <x-slot name='slot'>

        <header class="bg-orange-500 text-white py-4">
            <div class="container mx-auto flex items-center justify-between">
                <h1 class="text-3xl font-bold ml-10">Carrito de compras</h1>
            </div>
        </header>

        <div class="container mx-auto mt-6">
            


            @if(session('status'))
                <div class="bg-green-100 text-green-700 p-2 mb-4">{{ session('status') }}</div>
            @endif

            @if(empty($cart) || count($cart) === 0)
                <div class="bg-white p-6 rounded shadow">
                    <p class="mb-4">El carrito está vacío.</p>
                    <a href="{{ route('menu') }}" class="bg-orange-500 text-white px-4 py-2 rounded">Ir al menú</a>
                </div>
            @else
                @php $subtotal = 0; @endphp
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="md:col-span-2 bg-white rounded shadow p-4">
                        @foreach($cart as $pid => $qty)
                            @php $p = $products->get($pid); @endphp
                            @if($p)
                                @php $line = $p->precio * $qty; $subtotal += $line; @endphp
                                <div class="flex items-center justify-between border-b py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-20 h-20 bg-gray-100 flex items-center justify-center rounded">
                                            <span class="text-gray-400">Imagen</span>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800">{{ $p->nombre }}</div>
                                            <div class="text-sm text-gray-500">{{ $p->descripcion }}</div>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <div class="text-sm text-gray-600">Cant: <span class="font-medium">{{ $qty }}</span></div>
                                        <div class="text-sm text-gray-600">Precio: ${{ number_format($p->precio,2) }}</div>
                                        <div class="text-lg font-semibold mt-1">${{ number_format($line,2) }}</div>

                                        <form method="POST" action="{{ route('cart.remove') }}" class="mt-2">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $p->id }}">
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Remover</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="bg-white rounded shadow p-4">
                        <h3 class="text-lg font-semibold mb-4">Resumen del pedido</h3>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">${{ number_format($subtotal,2) }}</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-600">Envío</span>
                            <span class="text-gray-600">--</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between font-semibold text-xl">
                                <span>Total</span>
                                <span>${{ number_format($subtotal,2) }}</span>
                            </div>
                            <a href="{{ route('checkout.form') }}" class="block text-center bg-orange-500 hover:bg-orange-600 text-white mt-4 px-4 py-2 rounded">Proceder al pago</a>
                            <a href="{{ route('menu') }}" class="block text-center border mt-3 px-4 py-2 rounded text-gray-700">Seguir comprando</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </x-slot>
</x-app-layout>
