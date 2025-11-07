<x-app-layout>
    <x-slot name="layoutTitle">Editar Producto</x-slot>

    <x-slot name='slot'>
        <div class="container mx-auto mt-6 max-w-2xl">
            <div class="bg-white shadow-md rounded px-6 py-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">Editar producto</h2>
                    <a href="{{ route('admin-view.index') }}" class="text-sm text-gray-600 hover:underline">← Volver a productos</a>
                </div>

                @if($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-100 p-3 rounded">
                        <ul class="text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.update', ['id' => $producto->id]) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nombre_input" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input id="nombre_input" type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" class="mt-1 block w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                    </div>

                    <div>
                        <label for="descripcion_input" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <input id="descripcion_input" type="text" name="descripcion" value="{{ old('descripcion', $producto->descripcion) }}" class="mt-1 block w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                    </div>

                    <div>
                        <label for="precio_input" class="block text-sm font-medium text-gray-700">Precio (MXN)</label>
                        <input id="precio_input" type="number" step="0.01" name="precio" value="{{ old('precio', $producto->precio) }}" class="mt-1 block w-48 border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                        <p class="text-xs text-gray-500 mt-1">Ingresa el precio en pesos. Usa punto para decimales (ej. 45.00).</p>
                    </div>

                    <div class="flex items-center space-x-3 mt-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Actualizar producto</button>
                        <a href="{{ route('admin-view.index') }}" class="text-sm text-gray-600 hover:underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>

</x-app-layout>