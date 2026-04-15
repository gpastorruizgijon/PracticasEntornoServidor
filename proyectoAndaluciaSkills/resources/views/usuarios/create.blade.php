<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nuevo Conductor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <p class="text-xs text-gray-500 mb-6"><span class="text-red-500">*</span> Campos obligatorios</p>

                <form action="{{ route('conductores.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div x-data="{ valid: null }">
                        <label for="name" class="block font-medium text-sm text-gray-700">
                            Nombre Completo <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name') }}"
                            placeholder="Ej: Juan García López"
                            @blur="valid = $event.target.value.trim().length >= 2"
                            @input="if (valid !== null) valid = $event.target.value.trim().length >= 2"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">El nombre debe tener al menos 2 caracteres.</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Correcto</p>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ valid: null }">
                        <label for="email" class="block font-medium text-sm text-gray-700">
                            Correo Electrónico <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email') }}"
                            placeholder="Ej: conductor@empresa.com"
                            @blur="valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($event.target.value.trim())"
                            @input="if (valid !== null) valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($event.target.value.trim())"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                            required>
                        <p class="text-gray-500 text-xs mt-1">Formato: nombre@dominio.com</p>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">El formato del correo no es válido (Ej: usuario@dominio.com).</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Correo válido</p>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="license_type" class="block font-medium text-sm text-gray-700">
                            Tipo de Licencia <span class="text-red-500 ml-0.5" aria-hidden="true">*</span>
                        </label>
                        <select name="license_type" id="license_type"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="">Selecciona una licencia...</option>
                            <option value="B" {{ old('license_type') === 'B' ? 'selected' : '' }}>Clase B — Vehículos ligeros</option>
                            <option value="C" {{ old('license_type') === 'C' ? 'selected' : '' }}>Clase C — Camiones rígidos</option>
                            <option value="C+E" {{ old('license_type') === 'C+E' ? 'selected' : '' }}>Clase C+E — Tráiler / Semirremolque</option>
                        </select>
                        <p class="text-gray-500 text-xs mt-1">La licencia C+E es necesaria para camiones con remolque.</p>
                        @error('license_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ valid: null }">
                        <label for="phone" class="block font-medium text-sm text-gray-700">
                            Teléfono de Contacto
                            <span class="text-gray-400 font-normal text-xs">(opcional)</span>
                        </label>
                        <input type="text" name="phone" id="phone"
                            value="{{ old('phone') }}"
                            placeholder="Ej: 612345678"
                            @blur="valid = $event.target.value === '' ? null : /^[6789]\d{8}$/.test($event.target.value.trim())"
                            @input="if (valid !== null) valid = $event.target.value === '' ? null : /^[6789]\d{8}$/.test($event.target.value.trim())"
                            class="mt-1 block w-full rounded-md shadow-sm transition-colors"
                            :class="valid === false ? 'border-red-400 focus:border-red-500 focus:ring-red-500'
                                  : valid === true  ? 'border-green-400 focus:border-green-500 focus:ring-green-500'
                                  : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'">
                        <p class="text-gray-500 text-xs mt-1">9 dígitos, comenzando por 6, 7, 8 o 9 (móvil o fijo español).</p>
                        <p x-show="valid === false" x-transition class="text-red-500 text-xs mt-1">Formato incorrecto. Introduce 9 dígitos comenzando por 6, 7, 8 o 9.</p>
                        <p x-show="valid === true" x-transition class="text-green-600 text-xs mt-1">&#10003; Teléfono válido</p>
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between mt-6 pt-4 border-t">
                        <a href="{{ route('conductores.index') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 border border-gray-300 bg-white hover:bg-gray-50 rounded-md px-3 py-2 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Volver al listado
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-md transition duration-150">
                            Guardar Conductor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
