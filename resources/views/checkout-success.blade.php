<x-app-layout>
    <x-slot name='layoutTitle'>Pedido confirmado</x-slot>
    <x-slot name='slot'>
        <div class="container mx-auto mt-8">
            <div class="bg-white rounded shadow p-6 text-center">
                <h2 class="text-2xl font-bold mb-4 text-green-700">¡Pedido confirmado!</h2>
                <p class="mb-4">Cualquier duda o aclaración respecto al pedido, solicitar información al número <strong>999-365-6551</strong>, con el siguiente folio de pedido:</p>
                <div class="inline-block bg-gray-100 px-4 py-3 rounded font-mono text-lg">{{ $order->order_referencia }}</div>

                <div class="mt-6">
                    <a href="{{ route('menu') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">Volver al menú</a>
                    <a href="{{ route('cart.view') }}" class="ml-3 text-gray-600">Ver carrito</a>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
