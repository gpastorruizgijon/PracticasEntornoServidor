<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Planta:') }} {{ $planta->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <p class="text-xs text-gray-500 mb-6"><span class="text-red-500">*</span> Campos obligatorios</p>

                <form action="{{ route('plantas.update', $planta->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div x-data="{ valid: null }"
                         x-init="function check(v){ return v.trim().length >= 2 && /[a-zA-ZáéíóúñüÁÉÍÓÚÑÜ]/.test(v) && !/\d/.test(v) }">
                        <label for="name" class="block font-medium text-sm text-gray-700">
                            Nombre de la Planta <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            value="{{ $planta->name }}"
                            @blur="valid = check($event.target.value)"
                            @input="if (valid !== null) valid = check($event.target.value)"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">El nombre solo puede contener letras y espacios, sin números.</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Correcto</p>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ valid: null }"
                         x-init="function check(v){ return v.trim().length >= 2 && /[a-zA-ZáéíóúñüÁÉÍÓÚÑÜ]/.test(v) && !/\d/.test(v) }">
                        <label for="city" class="block font-medium text-sm text-gray-700">
                            Ciudad <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="text" name="city" id="city"
                            value="{{ $planta->city }}"
                            @blur="valid = check($event.target.value)"
                            @input="if (valid !== null) valid = check($event.target.value)"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">La ciudad solo puede contener letras, sin números (Ej: Sevilla).</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Correcto</p>
                        @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ valid: null }">
                        <label for="max_capacity_kg" class="block font-medium text-sm text-gray-700">
                            Capacidad Máxima (kg) <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="number" name="max_capacity_kg" id="max_capacity_kg"
                            value="{{ $planta->max_capacity_kg }}"
                            min="1"
                            @blur="valid = parseFloat($event.target.value) > 0"
                            @input="if (valid !== null) valid = parseFloat($event.target.value) > 0"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
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
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded shadow transition ease-in-out duration-150">
                            Actualizar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
