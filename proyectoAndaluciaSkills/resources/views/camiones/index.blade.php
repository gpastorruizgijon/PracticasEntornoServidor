<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Flota de Camiones') }}
            </h2>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('camiones.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                    Añadir Camión
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-300 text-green-800 rounded-lg px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-300 text-red-800 rounded-lg px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Matrícula</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Modelo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Capacidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Conductor</th>
                            @if(Auth::user()->isAdmin())
                                <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($camiones as $camion)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 bg-gray-200 rounded text-sm font-mono">{{ $camion->plate }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $camion->model }}</td>
                            <td class="px-6 py-4 font-mono">{{ number_format($camion->max_load_kg, 0) }} kg</td>
                            <td class="px-6 py-4">
                                @if($camion->driver)
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $camion->driver->name }}</p>
                                        <p class="text-xs text-gray-500">Licencia: {{ $camion->driver->license_type }}</p>
                                    </div>
                                @else
                                    <span class="text-red-500 italic text-sm">Sin conductor</span>
                                @endif
                            </td>
                            @if(Auth::user()->isAdmin())
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('camiones.edit', $camion->id) }}"
                                        class="text-yellow-600 hover:text-yellow-900 mr-3 text-sm font-semibold">Editar</a>

                                    <div class="inline-block" x-data="{ confirm: false }">
                                        <button @click="confirm = true"
                                            class="text-red-600 hover:text-red-900 text-sm font-semibold">
                                            Eliminar
                                        </button>
                                        <div x-show="confirm" x-transition.opacity
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
                                            @keydown.escape.window="confirm = false">
                                            <div class="bg-white rounded-xl shadow-xl p-6 max-w-sm w-full mx-4" @click.stop>
                                                <p class="font-semibold text-gray-900 mb-1">¿Eliminar camión {{ $camion->plate }}?</p>
                                                <p class="text-sm text-gray-500 mb-5">Esta acción no se puede deshacer.</p>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" @click="confirm = false"
                                                        class="px-4 py-2 text-sm border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                                                        Cancelar
                                                    </button>
                                                    <form action="{{ route('camiones.destroy', $camion->id) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="px-4 py-2 text-sm bg-red-600 text-white rounded-md hover:bg-red-700">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($camiones->hasPages())
                    <div class="mt-4">
                        {{ $camiones->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
