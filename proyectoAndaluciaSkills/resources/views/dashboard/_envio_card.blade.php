<div class="bg-white rounded-lg shadow border-l-4 {{ $colorBorder }} overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center gap-4">
            <span class="font-bold text-gray-800">{{ $envio->type }}</span>
            <span class="text-sm text-gray-500">
                {{ $envio->plant?->name ?? '—' }}
            </span>
        </div>
        <div class="flex items-center gap-6 text-sm">
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
                    </div>
                    <span class="font-mono text-gray-600">{{ $r->kilos }} kg</span>
                </div>
            @endforeach
        </div>
    @endif
</div>
