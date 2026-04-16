<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Residuo #') }}{{ $residuo->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <p class="text-xs text-gray-500 mb-6"><span class="text-red-500">*</span> Campos obligatorios</p>

                <form action="{{ route('residuos.update', $residuo->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="type" class="block font-medium text-sm text-gray-700">
                            Tipo de Material <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <select name="type" id="type"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="">-- Selecciona un tipo --</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo }}" {{ $residuo->type === $tipo ? 'selected' : '' }}>
                                    {{ $tipo }}
                                </option>
                            @endforeach
                        </select>
                        @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ valid: null }">
                        <label for="kilos" class="block font-medium text-sm text-gray-700">
                            Kilos Totales <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="number" name="kilos" id="kilos" step="0.01"
                            value="{{ $residuo->kilos }}"
                            min="0.01"
                            @blur="valid = parseFloat($event.target.value) >= 0.01"
                            @input="if (valid !== null) valid = parseFloat($event.target.value) >= 0.01"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">El peso debe ser mayor que 0.</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Peso válido</p>
                        @error('kilos') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ valid: null, msg: '' }"
                         x-init="
                            function check(v) {
                                if (v.trim().length < 5) { msg = 'La dirección debe tener al menos 5 caracteres.'; return false; }
                                if (!/[a-zA-ZáéíóúñüÁÉÍÓÚÑÜ]/.test(v)) { msg = 'La dirección debe contener texto, no solo números.'; return false; }
                                return true;
                            }
                         ">
                        <label for="origin_address" class="block font-medium text-sm text-gray-700">
                            Dirección de Origen <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="text" name="origin_address" id="origin_address"
                            value="{{ $residuo->origin_address }}"
                            @blur="valid = check($event.target.value)"
                            @input="if (valid !== null) valid = check($event.target.value)"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1" x-text="msg"></p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Dirección válida</p>
                        @error('origin_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="is_hazardous" class="block font-medium text-sm text-gray-700">Nivel de Riesgo</label>
                        <select name="is_hazardous" id="is_hazardous"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="0" {{ !$residuo->is_hazardous ? 'selected' : '' }}>No peligroso</option>
                            <option value="1" {{ $residuo->is_hazardous ? 'selected' : '' }}>Material Peligroso / Especial</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between mt-6 pt-4 border-t">
                        <a href="{{ route('residuos.index') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 border border-gray-300 bg-white hover:bg-gray-50 rounded-md px-3 py-2 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-800 transition ease-in-out duration-150">
                            Actualizar Residuo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
