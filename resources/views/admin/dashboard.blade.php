<x-app-layout>
    <x-slot name="layoutTitle">Admin Dashboard</x-slot>
    <x-slot name="slot">
        <div class="container mx-auto mt-8">
            <div class="bg-white rounded shadow p-6">
                <h1 class="text-2xl font-bold mb-4">Panel de administración</h1>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if(auth()->user() && auth()->user()->isAdmin())
                        <a href="{{ route('admin-view.index') }}" class="block p-4 bg-orange-50 border rounded hover:shadow">
                            <h3 class="font-semibold">Productos</h3>
                            <p class="text-sm text-gray-600">Crear, editar y eliminar productos</p>
                        </a>
                    @endif

                    <a href="{{ route('admin-pedidos.index') }}" class="block p-4 bg-orange-50 border rounded hover:shadow">
                        <h3 class="font-semibold">Cocina</h3>
                        <p class="text-sm text-gray-600">Ver comandas y gestionar estados de producción</p>
                    </a>

                    <a href="{{ route('admin-caja.index') }}" class="block p-4 bg-orange-50 border rounded hover:shadow">
                        <h3 class="font-semibold">Caja</h3>
                        <p class="text-sm text-gray-600">Registrar pagos y finalizar pedidos preparados</p>
                    </a>

                    @if(auth()->user() && (auth()->user()->isAdmin() || auth()->user()->role === 'trabajador'))
                        <a href="#" class="block p-4 bg-gray-50 border rounded hover:shadow">
                            <h3 class="font-semibold">Reportes</h3>
                            <p class="text-sm text-gray-600">Acceso rápido a reportes (próximamente)</p>
                        </a>

                        <a href="#" class="block p-4 bg-gray-50 border rounded hover:shadow">
                            <h3 class="font-semibold">Historial de pedidos</h3>
                            <p class="text-sm text-gray-600">Ver historial y búsquedas (próximamente)</p>
                        </a>

                        <a href="#" class="block p-4 bg-gray-50 border rounded hover:shadow">
                            <h3 class="font-semibold">Crear pedido manualmente</h3>
                            <p class="text-sm text-gray-600">Registrar pedidos manuales (próximamente)</p>
                        </a>
                    @endif

                    @if(auth()->user() && auth()->user()->isAdmin())
                        <a href="{{ route('admin.settings') }}" class="block p-4 bg-gray-50 border rounded hover:shadow">
                            <h3 class="font-semibold">Configuraciones</h3>
                            <p class="text-sm text-gray-600">Horario, días de apertura y otras opciones</p>
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="p-4">
                        @csrf
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
