<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Plantas de Reciclaje') }}
            </h2>
            <a href="{{ route('plantas.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150 shadow-sm">
                Nueva Planta
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Ciudad</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Capacidad Máxima</th>
                            <th class="px-6 py-3 text-center text-xs font-bold uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($plantas as $planta)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $planta->name }}</td>
                            <td class="px-6 py-4 italic text-gray-600">{{ $planta->city }}</td>
                            <td class="px-6 py-4 font-mono">{{ number_format($planta->max_capacity_kg, 0) }} kg</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('plantas.edit', $planta->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold mr-4">Editar</a>
                                <form action="{{ route('plantas.destroy', $planta->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Borrar planta?')">Borrar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>