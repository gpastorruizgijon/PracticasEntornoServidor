<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nueva Planta de Reciclaje') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <p class="text-xs text-gray-500 mb-6"><span class="text-red-500">*</span> Campos obligatorios</p>

                <form action="{{ route('plantas.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div x-data="{ valid: null }">
                        <label for="name" class="block font-medium text-sm text-gray-700">
                            Nombre de la Instalación <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name') }}"
                            placeholder="Ej: Planta Central de Andalucía"
                            @blur="valid = $event.target.value.trim().length >= 2"
                            @input="if (valid !== null) valid = $event.target.value.trim().length >= 2"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required autofocus>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">El nombre debe tener al menos 2 caracteres.</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Correcto</p>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ valid: null }">
                        <label for="city" class="block font-medium text-sm text-gray-700">
                            Ciudad / Ubicación <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="text" name="city" id="city"
                            value="{{ old('city') }}"
                            placeholder="Ej: Sevilla"
                            @blur="valid = $event.target.value.trim().length >= 2"
                            @input="if (valid !== null) valid = $event.target.value.trim().length >= 2"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">La ciudad debe tener al menos 2 caracteres.</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Correcto</p>
                        @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ valid: null }">
                        <label for="max_capacity_kg" class="block font-medium text-sm text-gray-700">
                            Capacidad Máxima (en kg) <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="number" name="max_capacity_kg" id="max_capacity_kg"
                            value="{{ old('max_capacity_kg') }}"
                            placeholder="Ej: 50000"
                            min="1"
                            @blur="valid = parseFloat($event.target.value) > 0"
                            @input="if (valid !== null) valid = parseFloat($event.target.value) > 0"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
                        <p class="text-gray-500 text-xs mt-1">Indica el límite de almacenamiento de la planta en kilogramos.</p>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">La capacidad debe ser mayor que 0.</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Capacidad válida</p>
                        @error('max_capacity_kg') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between mt-6 pt-4 border-t">
                        <a href="{{ route('plantas.index') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 border border-gray-300 bg-white hover:bg-gray-50 rounded-md px-3 py-2 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Volver al listado
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150 shadow-md">
                            Guardar Planta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
