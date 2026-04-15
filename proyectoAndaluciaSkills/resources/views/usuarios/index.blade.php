<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Panel de Conductores') }}
            </h2>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('conductores.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150 shadow-sm">
                    Nuevo Conductor
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Teléfono</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Licencia</th>
                            @if(Auth::user()->isAdmin())
                                <th class="px-6 py-3 text-center text-xs font-bold uppercase">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($usuarios as $usuario)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $usuario->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $usuario->email }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $usuario->phone ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 uppercase">
                                    {{ $usuario->license_type }}
                                </span>
                            </td>
                            @if(Auth::user()->isAdmin())
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('conductores.destroy', $usuario->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold"
                                            onclick="return confirm('¿Dar de baja a este conductor?')">
                                            Dar de Baja
                                        </button>
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
