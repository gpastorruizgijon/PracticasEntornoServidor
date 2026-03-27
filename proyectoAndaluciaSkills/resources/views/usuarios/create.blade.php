<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nuevo Conductor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <form action="{{ route('conductores.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nombre Completo</label>
                        <input type="text" name="name" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Correo Electrónico</label>
                        <input type="email" name="email" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Tipo de Licencia</label>
                        <select name="license_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="C1">Clase C1 (Camiones rígidos)</option>
                            <option value="C+E">Clase C+E (Tráiler)</option>
                            <option value="ADR">ADR (Mercancías Peligrosas)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Teléfono de Contacto</label>
                        <input type="text" name="phone" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-md transition duration-150">
                            Guardar Conductor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>