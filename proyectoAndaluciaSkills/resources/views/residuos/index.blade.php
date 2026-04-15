<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestión de Residuos
            </h2>
            <a href="{{ route('residuos.create') }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition ease-in-out duration-150 shadow-sm">
                + Nueva Carga
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-800 rounded-lg px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ===== DISPONIBLES ===== --}}
            <section>
                <h3 class="text-base font-bold text-gray-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-gray-400 inline-block"></span>
                    Disponibles
                    <span class="text-xs font-normal text-gray-400 normal-case">(sin envío asignado)</span>
                </h3>

                @if($disponibles->isEmpty())
                    <p class="text-sm text-gray-400 pl-5">No hay residuos disponibles.</p>
                @else
                    <div class="space-y-3" x-data="{ open: null }">
                        @foreach($disponibles as $tipo => $residuos)
                            @php $totalKilos = $residuos->sum('kilos'); @endphp
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">

                                <button type="button"
                                    @click="open = open === '{{ $tipo }}' ? null : '{{ $tipo }}'"
                                    class="w-full flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition text-left">
                                    <div class="flex items-center gap-3">
                                        <span class="font-bold text-gray-800">{{ $tipo }}</span>
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">
                                            {{ $residuos->count() }} {{ $residuos->count() === 1 ? 'carga' : 'cargas' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="font-mono font-bold text-gray-700">{{ number_format($totalKilos, 2) }} kg</span>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform"
                                            :class="open === '{{ $tipo }}' ? 'rotate-180' : ''"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </button>

                                <div x-show="open === '{{ $tipo }}'" x-transition class="border-t divide-y divide-gray-100">
                                    @foreach($residuos as $r)
                                        <div class="flex items-center justify-between px-6 py-3">
                                            <div class="flex items-center gap-3">
                                                <span>{{ $r->is_hazardous ? '⚠️' : '📦' }}</span>
                                                <div>
                                                    <p class="text-sm text-gray-800">{{ $r->origin_address }}</p>
                                                    @if($r->is_hazardous)
                                                        <span class="text-xs px-2 py-0.5 bg-red-100 text-red-700 rounded-full">Peligroso</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="font-mono text-sm font-bold text-gray-700">{{ $r->kilos }} kg</span>
                                                @if(Auth::user()->isAdmin())
                                                    <a href="{{ route('residuos.edit', $r->id) }}"
                                                        class="text-yellow-600 hover:text-yellow-800 text-xs font-semibold">Editar</a>
                                                    <form action="{{ route('residuos.destroy', $r->id) }}" method="POST" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-800 text-xs font-semibold"
                                                            onclick="return confirm('¿Borrar esta carga?')">Borrar</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- ===== EN TRÁNSITO ===== --}}
            <section>
                <h3 class="text-base font-bold text-blue-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span>
                    En Tránsito
                </h3>

                @if($enTransito->isEmpty())
                    <p class="text-sm text-gray-400 pl-5">Ningún residuo en tránsito actualmente.</p>
                @else
                    <div class="space-y-2">
                        @foreach($enTransito as $r)
                            <div class="bg-blue-50 border border-blue-200 border-l-4 border-l-blue-500 rounded-lg flex items-center justify-between px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <span>{{ $r->is_hazardous ? '⚠️' : '📦' }}</span>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">{{ $r->type }}</p>
                                        <p class="text-xs text-gray-500">{{ $r->origin_address }}</p>
                                        @if($r->shipment?->plant)
                                            <p class="text-xs text-blue-600">Destino: {{ $r->shipment->plant->name }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-mono font-bold text-gray-700">{{ $r->kilos }} kg</span>
                                    @if($r->is_hazardous)
                                        <p class="text-xs text-red-600 mt-1">Peligroso</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- ===== ENTREGADOS ===== --}}
            <section>
                <h3 class="text-base font-bold text-green-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                    Entregados
                </h3>

                @if($entregados->isEmpty())
                    <p class="text-sm text-gray-400 pl-5">Ningún residuo entregado todavía.</p>
                @else
                    <div class="space-y-2">
                        @foreach($entregados as $r)
                            <div class="bg-green-50 border border-green-200 border-l-4 border-l-green-500 rounded-lg flex items-center justify-between px-6 py-3 opacity-80">
                                <div class="flex items-center gap-3">
                                    <span>{{ $r->is_hazardous ? '⚠️' : '📦' }}</span>
                                    <div>
                                        <p class="text-sm font-bold text-gray-700">{{ $r->type }}</p>
                                        <p class="text-xs text-gray-500">{{ $r->origin_address }}</p>
                                        @if($r->shipment?->plant)
                                            <p class="text-xs text-green-600">Entregado en: {{ $r->shipment->plant->name }}</p>
                                        @endif
                                    </div>
                                </div>
                                <span class="font-mono text-sm text-gray-600">{{ $r->kilos }} kg</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

        </div>
    </div>
</x-app-layout>
