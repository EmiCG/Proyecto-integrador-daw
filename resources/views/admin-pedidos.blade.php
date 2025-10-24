<x-app-layout>
    <x-slot name='layoutTitle'>
        Pedidos
    </x-slot>

    <x-slot name='slot'>
        <div class="container mx-auto mt-5">
            <h1 class="text-2xl font-bold mb-4">Pedidos</h1>
            @foreach($pedidos as $pedido)
                <div class="bg-white p-4 rounded shadow mb-4">
                    <h2 class="font-semibold">Pedido #{{ $pedido->id }} - {{ $pedido->created_at }}</h2>
                    <ul>
                        @foreach($pedido->productos as $prod)
                            <li>{{ $prod->nombre }} - {{ $prod->precio }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </x-slot>
</x-app-layout>
