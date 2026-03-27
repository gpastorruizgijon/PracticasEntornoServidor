<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nueva Carga de Residuos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg border border-gray-200">
                
                <form action="{{ route('residuos.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="type" class="block font-medium text-sm text-gray-700">Tipo de Material</label>
                        <input type="text" name="type" id="type" value="{{ old('type') }}" 
                            placeholder="Ej: Plástico PET, Cartón, Vidrio..."
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                        @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="kilos" class="block font-medium text-sm text-gray-700">Peso Total (kg)</label>
                        <input type="number" step="0.01" name="kilos" id="kilos" value="{{ old('kilos') }}" 
                            placeholder="0.00"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        @error('kilos') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="origin_address" class="block font-medium text-sm text-gray-700">Dirección de Origen</label>
                        <input type="text" name="origin_address" id="origin_address" value="{{ old('origin_address') }}" 
                            placeholder="Ej: Calle Industrial 123, Polígono Norte"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        @error('origin_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_hazardous" id="is_hazardous" value="1" {{ old('is_hazardous') ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <label for="is_hazardous" class="ml-2 block text-sm text-gray-900 font-bold">¿Es residuo peligroso?</label>
                    </div>

                    <div class="flex items-center justify-end mt-6 gap-4 border-t pt-6">
                        <a href="{{ route('residuos.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                            Cancelar y volver
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150 shadow-md">
                            Guardar Carga
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>