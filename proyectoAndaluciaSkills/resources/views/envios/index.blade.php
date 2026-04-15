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
                @endphp

                <div class="bg-white shadow-sm rounded-lg border-l-4 {{ $statusColor }} overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center gap-4">
                            <span class="text-xs font-bold uppercase px-3 py-1 rounded-full {{ $badgeColor }}">
                                {{ $statusLabel }}
                            </span>
                            <span class="font-bold text-gray-800">{{ $envio->type }}</span>
                            <span class="text-sm text-gray-500">
                                {{ $envio->truck->plate ?? '—' }} · {{ $envio->plant->name ?? '—' }}
                            </span>
                        </div>
                        <div class="flex items-center gap-6">
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
                            @if(Auth::user()->isAdmin())
                                <form action="{{ route('envios.destroy', $envio->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-800 text-xs font-medium transition-colors"
                                        onclick="return confirm('¿Anular este envío? Los residuos volverán a estar disponibles.')">
                                        Anular
                                    </button>
                                </form>
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

        </div>
    </div>
</x-app-layout>
