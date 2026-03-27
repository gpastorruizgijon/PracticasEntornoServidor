<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nuevo Envío') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <form action="{{ route('envios.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Residuo (Origen)</label>
                        <select name="waste_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach($residuos as $r)
                                <option value="{{ $r->id }}">{{ $r->type }} ({{ $r->kilos }}kg)</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Camión y Conductor</label>
                        <select name="truck_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach($camiones as $c)
                                <option value="{{ $c->id }}">{{ $c->plate }} - {{ $c->driver->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Planta de Destino</label>
                        <select name="recycling_plant_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach($plantas as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} (Cap: {{ $p->max_capacity_kg }}kg)</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Kilos a transportar</label>
                        <input type="number" name="kilos_transported" step="0.01" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @error('kilos_transported') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Fecha Recogida</label>
                            <input type="date" name="pickup_date" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Fecha Entrega</label>
                            <input type="date" name="delivery_date" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 transition ease-in-out duration-150 shadow-md">
                            Registrar Envío
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>