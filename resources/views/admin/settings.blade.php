<x-app-layout>
    <x-slot name="layoutTitle">Configuraciones</x-slot>
    <x-slot name="slot">
        <div class="container mx-auto mt-8">
            <div class="bg-white rounded shadow p-6">
                <h1 class="text-2xl font-bold mb-4">Configuraciones de la sucursal</h1>

                <form method="POST" action="#">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Horario de apertura</label>
                        <input type="text" class="w-full border rounded px-3 py-2 mt-1" placeholder="Ej: 09:00 - 21:00" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Días abiertos</label>
                        <input type="text" class="w-full border rounded px-3 py-2 mt-1" placeholder="Ej: Lun-Vie" />
                    </div>

                    <div>
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
</x-app-layout>
