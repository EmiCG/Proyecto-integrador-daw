<x-app-layout>
    <x-slot name='layoutTitle'>
        MENU
    </x-slot>

    <x-slot name='slot'>

        <div class="absolute top-4 right-4">
            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Ver Carrito
            </a>
        </div>

        @foreach ($productos as $producto)

        <div class="flex flex-col items-center justify-center bg-gray-100 p-4 rounded-lg shadow-md m-4">
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <h1 class="text-2xl font-bold text-gray-800" name='nombre'>{{$producto->nombre}}</h1>
                <h2 class="text-lg font-semibold text-green-600 mt-2" name='precio'>{{$producto->precio}}</h2>
                <p class="text-gray-600 mt-2" name='descripcion'>{{$producto->descripcion}}</p>
                <h2 class="text-xl font-medium text-gray-700 mt-4">Imagen</h2>
            </div>
        <button>
            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
                Añadir al carrito
            </a>
        <button>
        </div>

        @endforeach

    </x-slot>

</x-app-layout>