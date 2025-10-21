<x-app-layout>
    <x-slot name="layoutTitle">Editar Producto</x-slot>

    <x-slot name='slot'>
        <div class="container mx-auto mt-5">
            <form action="/laravel/test1/public/admin/productos/edit/{{$producto->id}}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label>
                        Nombre:
                        <input type="text" name="nombre" value="{{$producto->nombre}}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </label>
                </div>
                    
                <div class="mb-4">
                    <label>
                        Descripcion:
                        <input type="text" name="descripcion" value="{{$producto->descripcion}}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </label>
                </div>

                <div class="mb-4">
                    <label>
                        precio:
                        <input type="number" name="precio" value="{{$producto->precio}}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </label>
                 </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Actualizar producto</button>
            </form>
    </x-slot>

</x-app-layout>