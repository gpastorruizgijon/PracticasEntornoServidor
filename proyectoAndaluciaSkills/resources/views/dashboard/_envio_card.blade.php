<div class="bg-white rounded-lg shadow border-l-4 {{ $colorBorder }} overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 flex-wrap gap-3">
        <div class="flex items-center gap-4">
            <span class="font-bold text-gray-800">{{ $envio->type }}</span>
            <span class="text-sm text-gray-500">
                {{ $envio->plant?->name ?? '—' }}
            </span>
        </div>
        <div class="flex items-center gap-4 text-sm flex-wrap">
            <div class="text-right">
                <p class="text-xs text-gray-400">Recogida</p>
                <p class="font-medium">{{ $envio->pickup_date->format('d/m/Y') }}</p>
            </div>
            @if($envio->delivery_date)
                <div class="text-right">
                    <p class="text-xs text-gray-400">Entrega</p>
                    <p class="font-medium">{{ $envio->delivery_date->format('d/m/Y') }}</p>
                </div>
            @endif
            <div class="text-right">
                <p class="text-xs text-gray-400">Total</p>
                <p class="font-mono font-bold">{{ number_format($envio->kilos_transported, 2) }} kg</p>
            </div>

            {{-- Botón avanzar estado (conductor sobre su propio envío) --}}
            @if($envio->status !== 'delivered')
                <form action="{{ route('envios.status', $envio->id) }}" method="POST">
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
        </div>
    </div>

    {{-- Residuos incluidos --}}
    @if($envio->wastes->isNotEmpty())
        <div class="border-t divide-y divide-gray-100 {{ $colorBg }}">
            @foreach($envio->wastes as $r)
                <div class="flex items-center justify-between px-6 py-2 text-sm">
                    <div class="flex items-center gap-2">
                        <span>{{ $r->is_hazardous ? '⚠️' : '📦' }}</span>
                        <span class="text-gray-600">{{ $r->origin_address }}</span>
                        @if($r->is_hazardous)
                            <span class="text-xs px-1.5 py-0.5 bg-red-100 text-red-600 rounded">Peligroso</span>
                        @endif
                    </div>
                    <span class="font-mono text-gray-600">{{ $r->kilos }} kg</span>
                </div>
            @endforeach
        </div>
    @endif
</div>
