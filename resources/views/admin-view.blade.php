<x-app-layout>
    <x-slot name='layoutTitle'>
        MENU
    </x-slot>

    <x-slot name='slot'>
        <div class="container mx-auto mt-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Productos / Menú</h1>
                @if(auth()->user() && auth()->user()->isAdmin())
                    <a href="{{ route('admin-create-view.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Crear producto</a>
                @endif
            </div>

            @if(session('status'))
                <div class="mb-4 p-3 bg-green-50 border border-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($productos as $producto)
                    <div class="bg-white rounded-lg shadow hover:shadow-md overflow-hidden">
                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-gray-800">{{ $producto->nombre }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $producto->descripcion }}</p>
                        </div>
                        <div class="px-4 pb-4 flex items-center justify-between">
                            <div class="text-green-600 font-medium">${{ number_format($producto->precio, 2) }}</div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin-view.show', ['id' => $producto->id]) }}" class="text-sm bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">Editar</a>

                                <form action="{{ route('admin.destroy', ['id' => $producto->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-600">No hay productos. @if(auth()->user() && auth()->user()->isAdmin()) <a href="{{ route('admin-create-view.create') }}" class="text-blue-600 underline">Crear uno</a>@endif</div>
                @endforelse
            </div>
        </div>
    </x-slot>

</x-app-layout>