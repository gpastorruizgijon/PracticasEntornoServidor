<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Camión:') }} {{ $camione->plate }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <p class="text-xs text-gray-500 mb-6"><span class="text-red-500">*</span> Campos obligatorios</p>

                <form action="{{ route('camiones.update', $camione->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div x-data="{ valid: null }">
                        <label for="plate" class="block font-medium text-sm text-gray-700">
                            Matrícula <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="text" name="plate" id="plate"
                            value="{{ $camione->plate }}"
                            @blur="valid = /^\d{4}-?[A-Z]{3}$/i.test($event.target.value.trim())"
                            @input="if (valid !== null) valid = /^\d{4}-?[A-Z]{3}$/i.test($event.target.value.trim())"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors uppercase"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
                        <p class="text-gray-500 text-xs mt-1">Formato: 4 dígitos + guión opcional + 3 letras (Ej: 1234-BBB).</p>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">Formato incorrecto. Debe ser 4 dígitos seguidos de 3 letras, como 1234-BBB.</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Matrícula válida</p>
                        @error('plate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ valid: null }">
                        <label for="model" class="block font-medium text-sm text-gray-700">
                            Modelo <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="text" name="model" id="model"
                            value="{{ $camione->model }}"
                            @blur="valid = $event.target.value.trim().length >= 2"
                            @input="if (valid !== null) valid = $event.target.value.trim().length >= 2"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">El modelo debe tener al menos 2 caracteres.</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Correcto</p>
                        @error('model') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ valid: null }">
                        <label for="max_load_kg" class="block font-medium text-sm text-gray-700">
                            Carga Máxima (kg) <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="number" name="max_load_kg" id="max_load_kg"
                            value="{{ $camione->max_load_kg }}"
                            min="1"
                            @blur="valid = parseFloat($event.target.value) > 0"
                            @input="if (valid !== null) valid = parseFloat($event.target.value) > 0"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">La carga máxima debe ser mayor que 0.</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Capacidad válida</p>
                        @error('max_load_kg') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="user_id" class="block font-medium text-sm text-gray-700">
                            Asignar Conductor <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <select name="user_id" id="user_id"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="">Selecciona un conductor...</option>
                            @foreach($conductores as $conductor)
                                <option value="{{ $conductor->id }}" {{ $camione->user_id == $conductor->id ? 'selected' : '' }}>
                                    {{ $conductor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between mt-4 pt-4 border-t">
                        <a href="{{ route('camiones.index') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 border border-gray-300 bg-white hover:bg-gray-50 rounded-md px-3 py-2 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded shadow transition">
                            Actualizar Camión
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
