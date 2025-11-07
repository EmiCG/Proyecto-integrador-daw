<x-app-layout>
    <x-slot name="layoutTitle">Crear Producto</x-slot>

    <x-slot name='slot'>
        <div class="container mx-auto mt-5">
            <form action="{{ route('admin.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf

                <div class="mb-4">
                    <label>
                        Nombre:
                        <input type="text" name="nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </label>
                </div>
                    
                <div class="mb-4">
                    <label>
                        Descripcion:
                        <input type="text" name="descripcion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </label>
                </div>

                <div class="mb-4">
                    <label>
                        Precio:
                        <input type="number" name="precio" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </label>
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear producto</button>
            </form>
        </div>
    </x-slot>
</x-app-layout>