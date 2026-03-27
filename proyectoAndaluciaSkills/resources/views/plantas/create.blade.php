<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nueva Planta de Reciclaje') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                
                <form action="{{ route('plantas.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700">Nombre de la Instalación</label>
                        <input type="text" name="name" id="name" 
                            value="{{ old('name') }}" 
                            placeholder="Ej: Planta Central de Andalucía"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                            required autofocus>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="city" class="block font-medium text-sm text-gray-700">Ciudad / Ubicación</label>
                        <input type="text" name="city" id="city" 
                            value="{{ old('city') }}" 
                            placeholder="Ej: Sevilla"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                            required>
                        @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="max_capacity_kg" class="block font-medium text-sm text-gray-700">Capacidad Máxima (en kg)</label>
                        <input type="number" name="max_capacity_kg" id="max_capacity_kg" 
                            value="{{ old('max_capacity_kg') }}" 
                            placeholder="Ej: 50000"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                            required>
                        <p class="text-gray-500 text-xs mt-1">Indica el límite de almacenamiento de la planta.</p>
                        @error('max_capacity_kg') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6 gap-4">
                        <a href="{{ route('plantas.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                            Volver al listado
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150 shadow-md">
                            Guardar Planta
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>