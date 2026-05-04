<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nuevo Envío') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg"
                x-data="{
                    selectedType: '',
                    selectedIds: [],
                    totalKilos: 0,
                    wastes: {{ Js::from($residuosDisponibles) }},
                    get wastesByType() {
                        return this.wastes[this.selectedType] ?? [];
                    },
                    toggleWaste(id, kilos, checked) {
                        if (checked) {
                            this.selectedIds.push(id);
                            this.totalKilos += parseFloat(kilos);
                        } else {
                            this.selectedIds = this.selectedIds.filter(i => i !== id);
                            this.totalKilos -= parseFloat(kilos);
                        }
                    },
                    changeType() {
                        this.selectedIds = [];
                        this.totalKilos = 0;
                    }
                }">

                <p class="text-xs text-gray-500 mb-6"><span class="text-red-500">*</span> Campos obligatorios</p>

                <form action="{{ route('envios.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Paso 1: Tipo de residuo --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">
                            Tipo de residuo <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <select x-model="selectedType" @change="changeType()"
                            class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Selecciona un tipo --</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo }}"
                                    @if(!isset($residuosDisponibles[$tipo]) || $residuosDisponibles[$tipo]->isEmpty())
                                        disabled class="text-gray-400"
                                    @endif>
                                    {{ $tipo }}
                                    @if(!isset($residuosDisponibles[$tipo]) || $residuosDisponibles[$tipo]->isEmpty())
                                        (sin stock)
                                    @else
                                        ({{ $residuosDisponibles[$tipo]->count() }} disponibles)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('waste_ids') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Paso 2: Residuos del tipo seleccionado --}}
                    <div x-show="selectedType !== ''" x-transition>
                        <label class="block font-medium text-sm text-gray-700 mb-2">
                            Selecciona los residuos a incluir <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                            <span class="text-gray-400 font-normal">(mismo tipo)</span>
                        </label>

                        <div class="border rounded-lg divide-y max-h-64 overflow-y-auto">
                            <template x-for="waste in wastesByType" :key="waste.id">
                                <label class="flex items-center justify-between p-3 hover:bg-gray-50 cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox"
                                            name="waste_ids[]"
                                            :value="waste.id"
                                            @change="toggleWaste(waste.id, waste.kilos, $event.target.checked)"
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900" x-text="waste.origin_address"></p>
                                            <p class="text-xs text-gray-500" x-text="waste.is_hazardous ? '⚠️ Peligroso' : 'Normal'"></p>
                                        </div>
                                    </div>
                                    <span class="font-mono text-sm font-bold text-gray-700" x-text="waste.kilos + ' kg'"></span>
                                </label>
                            </template>
                        </div>

                        {{-- Total kilos seleccionados --}}
                        <div class="mt-3 flex items-center justify-between bg-indigo-50 border border-indigo-200 rounded-lg px-4 py-2">
                            <span class="text-sm font-medium text-indigo-700">Total seleccionado:</span>
                            <span class="font-mono font-bold text-indigo-900" x-text="totalKilos.toFixed(2) + ' kg'"></span>
                        </div>
                        <p x-show="selectedType !== '' && selectedIds.length === 0" x-transition class="text-amber-600 text-xs mt-2">
                            Selecciona al menos un residuo para continuar.
                        </p>
                    </div>

                    {{-- Camión --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700">
                            Camión y Conductor <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <select name="truck_id"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Selecciona un camión...</option>
                            @foreach($camiones as $c)
                                <option value="{{ $c->id }}">
                                    {{ $c->plate }} — {{ $c->driver?->name ?? 'Sin conductor' }} (máx. {{ $c->max_load_kg }} kg)
                                </option>
                            @endforeach
                        </select>
                        @error('truck_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Planta --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700">
                            Planta de Destino <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <select name="recycling_plant_id"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Selecciona una planta...</option>
                            @foreach($plantas as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} — {{ $p->city }} (Cap: {{ number_format($p->max_capacity_kg, 0, ',', '.') }} kg)</option>
                            @endforeach
                        </select>
                        @error('recycling_plant_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Fechas --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div x-data="{ valid: null }">
                            <label class="block font-medium text-sm text-gray-700">
                                Fecha de Recogida <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                            </label>
                            <input type="date" name="pickup_date"
                                value="{{ old('pickup_date') }}"
                                @blur="valid = $event.target.value !== ''"
                                @input="if (valid !== null) valid = $event.target.value !== ''"
                                class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                                :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                      : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                      : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'">
                            <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">Indica una fecha de recogida.</p>
                            @error('pickup_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">
                                Fecha de Entrega
                                <span class="text-gray-400 font-normal text-xs">(opcional)</span>
                            </label>
                            <input type="date" name="delivery_date"
                                value="{{ old('delivery_date') }}"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @error('delivery_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t">
                        <a href="{{ route('envios.index') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 border border-gray-300 bg-white hover:bg-gray-50 rounded-md px-3 py-2 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Cancelar y volver
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition ease-in-out duration-150 shadow-md"
                            :disabled="selectedIds.length === 0"
                            :class="selectedIds.length === 0 ? 'opacity-50 cursor-not-allowed' : ''">
                            Registrar Envío
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
