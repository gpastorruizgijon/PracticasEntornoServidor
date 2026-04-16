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
                                    <a href="{{ route('conductores.edit', $usuario->id) }}"
                                        class="text-yellow-600 hover:text-yellow-900 font-semibold text-sm mr-3">
                                        Editar
                                    </a>

                                    <div class="inline-block" x-data="{ confirm: false }">
                                        <button @click="confirm = true"
                                            class="text-red-600 hover:text-red-900 font-bold text-sm">
                                            Dar de Baja
                                        </button>
                                        <div x-show="confirm" x-transition.opacity
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
                                            @keydown.escape.window="confirm = false">
                                            <div class="bg-white rounded-xl shadow-xl p-6 max-w-sm w-full mx-4" @click.stop>
                                                <p class="font-semibold text-gray-900 mb-1">¿Dar de baja a {{ $usuario->name }}?</p>
                                                <p class="text-sm text-gray-500 mb-5">El conductor quedará desactivado. Esta acción no se puede deshacer fácilmente.</p>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" @click="confirm = false"
                                                        class="px-4 py-2 text-sm border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                                                        Cancelar
                                                    </button>
                                                    <form action="{{ route('conductores.destroy', $usuario->id) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="px-4 py-2 text-sm bg-red-600 text-white rounded-md hover:bg-red-700">
                                                            Dar de Baja
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
            </div>
        </div>
    </div>
</x-app-layout>
