<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nuevo Camión') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 bg-white p-8 shadow-sm sm:rounded-lg">
            <form action="{{ route('camiones.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block font-medium text-sm text-gray-700">Matrícula</label>
                    <input type="text" name="plate" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" placeholder="1234-BBB" required>
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700">Modelo</label>
                    <input type="text" name="model" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700">Carga Máxima (kg)</label>
                    <input type="number" name="max_load_kg" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700">Asignar Conductor</label>
                    <select name="user_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                        <option value="">Selecciona...</option>
                        @foreach($conductores as $conductor)
                            <option value="{{ $conductor->id }}">{{ $conductor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
                        Guardar Camión
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>