<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Residuo #') }}{{ $residuo->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <form action="{{ route('residuos.update', $residuo->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Tipo de Material</label>
                        <input type="text" name="type" value="{{ $residuo->type }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Kilos Totales</label>
                        <input type="number" name="kilos" step="0.01" value="{{ $residuo->kilos }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Dirección de Origen</label>
                        <input type="text" name="origin_address" value="{{ $residuo->origin_address }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nivel de Riesgo</label>
                        <select name="is_hazardous" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="0" {{ !$residuo->is_hazardous ? 'selected' : '' }}>No peligroso</option>
                            <option value="1" {{ $residuo->is_hazardous ? 'selected' : '' }}>Material Peligroso / Especial</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-6 gap-4">
                        <a href="{{ route('residuos.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-800 transition ease-in-out duration-150">
                            Actualizar Residuo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>