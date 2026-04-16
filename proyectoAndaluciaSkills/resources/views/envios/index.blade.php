<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Historial de Envíos') }}
            </h2>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('envios.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150">
                    Nuevo Envío
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-800 rounded-lg px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-300 text-red-800 rounded-lg px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            @forelse($envios as $envio)
                @php
                    $statusColor = match($envio->status) {
                        'delivered'  => 'border-l-green-500 bg-green-50',
                        'in_transit' => 'border-l-blue-500 bg-blue-50',
                        default      => 'border-l-yellow-400 bg-yellow-50',
                    };
                    $badgeColor = match($envio->status) {
                        'delivered'  => 'bg-green-100 text-green-800',
                        'in_transit' => 'bg-blue-100 text-blue-800',
                        default      => 'bg-yellow-100 text-yellow-800',
                    };
                    $statusLabel = match($envio->status) {
                        'delivered'  => 'Entregado',
                        'in_transit' => 'En Tránsito',
                        default      => 'Pendiente',
                    };
                    $canAdvance = Auth::user()->isAdmin()
                        || (Auth::user()->isConductor() && $envio->truck?->user_id === Auth::id());
                @endphp

                <div class="bg-white shadow-sm rounded-lg border-l-4 {{ $statusColor }} overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center gap-4 flex-wrap">
                            <span class="text-xs font-bold uppercase px-3 py-1 rounded-full {{ $badgeColor }}">
                                {{ $statusLabel }}
                            </span>
                            <span class="font-bold text-gray-800">{{ $envio->type }}</span>
                            <span class="text-sm text-gray-500">
                                {{ $envio->truck->plate ?? '—' }} · {{ $envio->plant->name ?? '—' }}
                            </span>
                        </div>

                        <div class="flex items-center gap-4 flex-wrap">
                            <div class="text-right">
                                <p class="text-xs text-gray-400">Recogida</p>
                                <p class="text-sm font-medium">{{ $envio->pickup_date->format('d/m/Y') }}</p>
                            </div>
                            @if($envio->delivery_date)
                                <div class="text-right">
                                    <p class="text-xs text-gray-400">Entrega</p>
                                    <p class="text-sm font-medium">{{ $envio->delivery_date->format('d/m/Y') }}</p>
                                </div>
                            @endif
                            <div class="text-right">
                                <p class="text-xs text-gray-400">Total</p>
                                <p class="font-mono font-bold text-gray-800">{{ number_format($envio->kilos_transported, 2) }} kg</p>
                            </div>

                            {{-- Avanzar estado --}}
                            @if($canAdvance && $envio->status !== 'delivered')
                                <form action="{{ route('envios.status', $envio->id) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="text-xs font-semibold px-3 py-1.5 rounded-full border transition
                                            {{ $envio->status === 'pending'
                                                ? 'border-yellow-400 text-yellow-700 hover:bg-yellow-100'
                                                : 'border-blue-400 text-blue-700 hover:bg-blue-100' }}">
                                        {{ $envio->status === 'pending' ? '▶ Iniciar trayecto' : '✓ Marcar entregado' }}
                                    </button>
                                </form>
                            @endif

                            {{-- Anular (solo admin, con modal) --}}
                            @if(Auth::user()->isAdmin())
                                <div x-data="{ confirm: false }">
                                    <button @click="confirm = true"
                                        class="text-red-500 hover:text-red-800 text-xs font-medium transition-colors">
                                        Anular
                                    </button>
                                    <div x-show="confirm" x-transition.opacity
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
                                        @keydown.escape.window="confirm = false">
                                        <div class="bg-white rounded-xl shadow-xl p-6 max-w-sm w-full mx-4" @click.stop>
                                            <p class="font-semibold text-gray-900 mb-1">¿Anular este envío?</p>
                                            <p class="text-sm text-gray-500 mb-5">Los residuos volverán a estar disponibles. Esta acción no se puede deshacer.</p>
                                            <div class="flex justify-end gap-2">
                                                <button type="button" @click="confirm = false"
                                                    class="px-4 py-2 text-sm border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                                                    Cancelar
                                                </button>
                                                <form action="{{ route('envios.destroy', $envio->id) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 text-sm bg-red-600 text-white rounded-md hover:bg-red-700">
                                                        Anular envío
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @foreach($envio->wastes as $residuo)
                            <div class="flex items-center justify-between px-6 py-3 text-sm">
                                <div class="flex items-center gap-3">
                                    <span class="text-base">{{ $residuo->is_hazardous ? '⚠️' : '📦' }}</span>
                                    <span class="text-gray-700">{{ $residuo->origin_address }}</span>
                                    @if($residuo->is_hazardous)
                                        <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Peligroso</span>
                                    @endif
                                </div>
                                <span class="font-mono text-gray-600">{{ $residuo->kilos }} kg</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white shadow-sm rounded-lg p-12 text-center">
                    <p class="text-gray-400 text-lg">No hay envíos registrados todavía.</p>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('envios.create') }}" class="mt-4 inline-block text-indigo-600 hover:underline">
                            Crear el primer envío
                        </a>
                    @endif
                </div>
            @endforelse

            {{-- Paginación --}}
            @if($envios->hasPages())
                <div class="mt-4">
                    {{ $envios->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
