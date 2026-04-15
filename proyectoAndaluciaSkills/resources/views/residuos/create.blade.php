<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nueva Carga de Residuos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg border border-gray-200">
                <p class="text-xs text-gray-500 mb-6"><span class="text-red-500">*</span> Campos obligatorios</p>

                <form action="{{ route('residuos.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="type" class="block font-medium text-sm text-gray-700">
                            Tipo de Material <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <select name="type" id="type"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="">-- Selecciona un tipo --</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo }}" {{ old('type') === $tipo ? 'selected' : '' }}>
                                    {{ $tipo }}
                                </option>
                            @endforeach
                        </select>
                        @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ valid: null }">
                        <label for="kilos" class="block font-medium text-sm text-gray-700">
                            Peso Total (kg) <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="number" step="0.01" name="kilos" id="kilos"
                            value="{{ old('kilos') }}"
                            placeholder="0.00" min="0.1"
                            @blur="valid = parseFloat($event.target.value) >= 0.1"
                            @input="if (valid !== null) valid = parseFloat($event.target.value) >= 0.1"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
                        <p class="text-gray-500 text-xs mt-1">Mínimo 0.1 kg. Usa punto o coma decimal.</p>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">El peso mínimo es 0.1 kg.</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Peso válido</p>
                        @error('kilos') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ valid: null }">
                        <label for="origin_address" class="block font-medium text-sm text-gray-700">
                            Dirección de Origen <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="text" name="origin_address" id="origin_address"
                            value="{{ old('origin_address') }}"
                            placeholder="Ej: Calle Industrial 123, Polígono Norte"
                            @blur="valid = $event.target.value.trim().length >= 5"
                            @input="if (valid !== null) valid = $event.target.value.trim().length >= 5"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">Indica una dirección completa (mínimo 5 caracteres).</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Dirección válida</p>
                        @error('origin_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_hazardous" id="is_hazardous" value="1"
                            {{ old('is_hazardous') ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <label for="is_hazardous" class="ml-2 block text-sm text-gray-900 font-bold">¿Es residuo peligroso?</label>
                    </div>

                    <div class="flex items-center justify-between mt-6 pt-6 border-t">
                        <a href="{{ route('residuos.index') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 border border-gray-300 bg-white hover:bg-gray-50 rounded-md px-3 py-2 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Cancelar y volver
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150 shadow-md">
                            Guardar Carga
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
