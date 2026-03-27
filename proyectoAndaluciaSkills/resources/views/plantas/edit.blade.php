<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Planta:') }} {{ $planta->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 bg-white p-8 shadow-sm sm:rounded-lg">
            <form action="{{ route('plantas.update', $planta->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block font-medium text-sm text-gray-700">Nombre de la Planta</label>
                    <input type="text" name="name" value="{{ $planta->name }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700">Capacidad Máxima (kg)</label>
                    <input type="number" name="max_capacity_kg" value="{{ $planta->max_capacity_kg }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700">Ciudad</label>
                    <input type="text" name="city" value="{{ $planta->city }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                </div>

                <div class="flex items-center justify-end mt-4 gap-4">
                    <a href="{{ route('plantas.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Cancelar</a>
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded shadow transition ease-in-out duration-150">
                        Actualizar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>