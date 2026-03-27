<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->role === 'admin' ? '📊 Panel de Administración' : '🚛 Mi Jornada de Trabajo' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(Auth::user()->role === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow border-b-4 border-blue-500">
                        <p class="text-gray-500 text-sm uppercase font-bold">Plantas</p>
                        <p class="text-3xl font-black">{{ \App\Models\RecyclingPlant::count() }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow border-b-4 border-green-500">
                        <p class="text-gray-500 text-sm uppercase font-bold">Conductores</p>
                        <p class="text-3xl font-black">{{ \App\Models\User::where('role', 'conductor')->count() }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow border-b-4 border-yellow-500">
                        <p class="text-gray-500 text-sm uppercase font-bold">Total Kilos</p>
                        <p class="text-3xl font-black">{{ number_format(\App\Models\Waste::sum('kilos'), 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow border-b-4 border-red-500">
                        <p class="text-gray-500 text-sm uppercase font-bold">Alertas Peligrosas</p>
                        <p class="text-3xl font-black text-red-600">{{ \App\Models\Waste::where('is_hazardous', true)->count() }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-4">Acciones Globales</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('envios.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">Nuevo Envío</a>
                        <a href="{{ route('plantas.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition">Nueva Planta</a>
                        <a href="{{ route('usuarios.index') }}" class="bg-gray-800 hover:bg-black text-white px-4 py-2 rounded shadow transition">Ver Conductores</a>
                    </div>
                </div>

            @else
                <div class="bg-indigo-700 p-8 rounded-lg shadow-lg text-white mb-8">
                    <h3 class="text-3xl font-bold">Bienvenido, {{ Auth::user()->name }}</h3>
                    <p class="opacity-80">Hoy tienes {{ \App\Models\Waste::where('user_id', Auth::id())->count() }} servicios asignados.</p>
                </div>

                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-6 border-b bg-gray-50">
                        <h4 class="font-bold text-gray-700">Mis Tareas Pendientes</h4>
                    </div>
                    <div class="p-6">
                        @php $misTareas = \App\Models\Waste::where('user_id', Auth::id())->latest()->get(); @endphp
                        
                        @if($misTareas->isEmpty())
                            <div class="text-center py-10">
                                <p class="text-gray-400">No tienes servicios asignados para hoy. ¡Buen descanso!</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($misTareas as $tarea)
                                    <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50 transition">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-full {{ $tarea->is_hazardous ? 'bg-red-100' : 'bg-green-100' }} flex items-center justify-center">
                                                <span class="text-xl">{{ $tarea->is_hazardous ? '⚠️' : '📦' }}</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900">{{ $tarea->type }}</p>
                                                <p class="text-sm text-gray-500">{{ $tarea->origin_address }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-mono font-bold">{{ $tarea->kilos }} kg</p>
                                            <span class="text-xs uppercase px-2 py-1 rounded-full {{ $tarea->is_hazardous ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                                {{ $tarea->is_hazardous ? 'Peligroso' : 'Normal' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>