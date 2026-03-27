<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Ofertas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4">Ofertas Disponibles</h1>
                
                <ul class="space-y-4">
                    @forelse ($offers as $offer)
                        <li class="border-b pb-4">
                            <strong class="text-lg text-blue-600">{{ $offer->title }}</strong> 
                            <span class="text-gray-500">- {{ $offer->company }}</span>
                            <p class="text-sm text-gray-700">{{ $offer->description }}</p>
                            <p class="font-bold mt-1 text-green-700">Salario: {{ $offer->salary ?? 'A convenir' }}€</p>
                        </li>
                    @empty
                        <p>No hay ofertas disponibles en este momento.</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>