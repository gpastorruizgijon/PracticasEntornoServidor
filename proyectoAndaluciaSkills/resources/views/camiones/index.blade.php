<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Flota de Camiones') }}
            </h2>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('camiones.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                    Añadir Camión
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 bg-gray-200 rounded text-sm font-mono">{{ $camion->plate }}</span></td>
                            <td class="px-6 py-4">{{ $camion->model }}</td>
                            <td class="px-6 py-4">{{ number_format($camion->max_load_kg, 0) }} kg</td>
                            <td class="px-6 py-4">
                                @if($camion->driver)
                                    {{ $camion->driver->name }}
                                @else
                                    <span class="text-red-500 italic">Sin conductor</span>
                                @endif
                            </td>
                            @if(Auth::user()->isAdmin())
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('camiones.edit', $camion->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                                    <form action="{{ route('camiones.destroy', $camion->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('¿Eliminar?')">Eliminar</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
