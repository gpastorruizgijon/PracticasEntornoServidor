<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Plantas de Reciclaje') }}
            </h2>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('plantas.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150 shadow-sm">
                    Nueva Planta
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
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Ciudad</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase">Capacidad / Ocupación</th>
                            @if(Auth::user()->isAdmin())
                                <th class="px-6 py-3 text-center text-xs font-bold uppercase">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($plantas as $planta)
                            @php
                                $cargaActiva = $planta->carga_activa_kg ?? 0;
                                $porcentaje  = $planta->max_capacity_kg > 0
                                    ? min(100, round(($cargaActiva / $planta->max_capacity_kg) * 100))
                                    : 0;
                                $barColor = $porcentaje >= 90 ? 'bg-red-500' : ($porcentaje >= 60 ? 'bg-yellow-400' : 'bg-green-500');
                            @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $planta->name }}</td>
                            <td class="px-6 py-4 italic text-gray-600">{{ $planta->city }}</td>
                            <td class="px-6 py-4 min-w-[200px]">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div class="{{ $barColor }} h-2 rounded-full transition-all" style="width: {{ $porcentaje }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600 whitespace-nowrap font-mono">
                                        {{ number_format($cargaActiva, 0) }} / {{ number_format($planta->max_capacity_kg, 0) }} kg
                                    </span>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">{{ $porcentaje }}% ocupado (envíos activos)</p>
                            </td>
                            @if(Auth::user()->isAdmin())
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('plantas.edit', $planta->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 font-bold mr-4 text-sm">Editar</a>

                                    <div class="inline-block" x-data="{ confirm: false }">
                                        <button @click="confirm = true"
                                            class="text-red-600 hover:text-red-900 text-sm font-bold">
                                            Borrar
                                        </button>
                                        <div x-show="confirm" x-transition.opacity
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
                                            @keydown.escape.window="confirm = false">
                                            <div class="bg-white rounded-xl shadow-xl p-6 max-w-sm w-full mx-4" @click.stop>
                                                <p class="font-semibold text-gray-900 mb-1">¿Borrar "{{ $planta->name }}"?</p>
                                                <p class="text-sm text-gray-500 mb-5">Esta acción no se puede deshacer.</p>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" @click="confirm = false"
                                                        class="px-4 py-2 text-sm border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                                                        Cancelar
                                                    </button>
                                                    <form action="{{ route('plantas.destroy', $planta->id) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="px-4 py-2 text-sm bg-red-600 text-white rounded-md hover:bg-red-700">
                                                            Borrar
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

                @if($plantas->hasPages())
                    <div class="mt-4">
                        {{ $plantas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
