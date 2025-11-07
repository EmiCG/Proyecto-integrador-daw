<x-app-layout>
    <x-slot name='layoutTitle'>
        MENU
    </x-slot>

    <x-slot name='slot'>

        <header class="bg-orange-500 text-white py-4">
            <div class="container mx-auto flex items-center justify-between">
                <h1 class="text-3xl font-bold ml-10">Menú</h1>
                @php
                    $cart = session('cart', []);
                    $cartCount = is_array($cart) ? array_sum($cart) : 0;
                @endphp
                <div class="flex items-center space-x-3">
                    <a href="{{ route('cart.view') }}" class="hidden md:flex bg-white text-orange-600 px-4 py-2 rounded shadow hover:shadow-md items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1" />
                                <circle cx="20" cy="21" r="1" />
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                            </svg>
                        Ver carrito
                        <span class="ml-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">{{ $cartCount }}</span>
                    </a>
                </div>
            </div>
        </header>

        <div class="container mx-auto mt-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($productos as $producto)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-4">
                            <div class="h-40 bg-gray-100 rounded flex items-center justify-center mb-4">
                                <span class="text-gray-400">Imagen</span>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $producto->nombre }}</h2>
                            <p class="text-green-600 font-semibold mt-1">$ {{ number_format($producto->precio, 2) }}</p>
                            <p class="text-gray-600 mt-2">{{ $producto->descripcion }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 flex items-center justify-between">
                            <form method="POST" action="{{ route('cart.add') }}" class="flex items-center space-x-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $producto->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded">Añadir</button>
                            </form>
                            <a href="{{ route('menu.show', ['id' => $producto->id]) }}" class="text-sm text-gray-600 hover:underline">Ver</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <a href="{{ route('cart.view') }}" class="fixed bottom-6 right-6 bg-orange-500 text-white rounded-full shadow-lg p-4 flex items-center space-x-2 md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1" />
                <circle cx="20" cy="21" r="1" />
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
            </svg>
            <span class="text-sm font-semibold">Carrito ({{ $cartCount }})</span>
        </a>

    </x-slot>

</x-app-layout>
