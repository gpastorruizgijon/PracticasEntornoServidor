<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(Auth::user()->role === 'admin')
                Panel de Administración
            @elseif(Auth::user()->role === 'conductor')
                Mi Jornada de Trabajo
            @else
                Mis Residuos
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-300 text-green-800 rounded-lg px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-300 text-red-800 rounded-lg px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{--  PANEL ADMIN                                            --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            @if(Auth::user()->role === 'admin')

                {{-- Stats --}}
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

                {{-- Acciones rápidas --}}
                <div class="bg-white p-6 rounded-lg shadow mb-8">
                    <h3 class="text-lg font-bold mb-4">Acciones Rápidas</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('envios.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">Nuevo Envío</a>
                        <a href="{{ route('plantas.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition">Nueva Planta</a>
                        <a href="{{ route('residuos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow transition">Nueva Carga</a>
                        <a href="{{ route('usuarios.index') }}" class="bg-gray-800 hover:bg-black text-white px-4 py-2 rounded shadow transition">Ver Conductores</a>
                    </div>
                </div>

                {{-- Residuos del admin --}}
                @if($misResiduos->isNotEmpty())
                    <div class="bg-white rounded-lg shadow mb-8 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-base font-bold text-gray-800">Mis Cargas Registradas</h3>
                            <a href="{{ route('residuos.index') }}" class="text-xs text-indigo-600 hover:underline">Ver todas →</a>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach($misResiduos->take(5) as $r)
                                @php
                                    $rStatus = $r->shipment?->status;
                                    $rBg = $rStatus === 'delivered' ? 'bg-green-50' : ($rStatus === 'in_transit' ? 'bg-blue-50' : 'bg-white');
                                @endphp
                                <div class="flex items-center justify-between px-6 py-3 {{ $rBg }}">
                                    <div class="flex items-center gap-3">
                                        <span>{{ $r->is_hazardous ? '⚠️' : '📦' }}</span>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">{{ $r->type }}</p>
                                            <p class="text-xs text-gray-500">{{ $r->origin_address }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="font-mono text-sm font-bold text-gray-700">{{ $r->kilos }} kg</span>
                                        @if($rStatus === 'delivered')
                                            <span class="text-xs px-2 py-0.5 bg-green-100 text-green-700 rounded-full">Entregado</span>
                                        @elseif($rStatus === 'in_transit')
                                            <span class="text-xs px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full">En tránsito</span>
                                        @else
                                            <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full">Disponible</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Todos los usuarios registrados --}}
                <div class="bg-white rounded-lg shadow mb-8 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-base font-bold text-gray-800">Usuarios Registrados</h3>
                        <span class="text-xs text-gray-400">{{ $todosUsuarios->count() }} en total</span>
                    </div>
                    <div class="p-4">
                        <table class="min-w-full divide-y divide-gray-100 text-sm">
                            <thead>
                                <tr class="text-xs text-gray-500 uppercase">
                                    <th class="px-4 py-2 text-left font-semibold">Nombre</th>
                                    <th class="px-4 py-2 text-left font-semibold">Email</th>
                                    <th class="px-4 py-2 text-left font-semibold">Rol</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($todosUsuarios as $u)
                                    @php
                                        $rolColor = match($u->role) {
                                            'admin'     => 'bg-red-100 text-red-700',
                                            'conductor' => 'bg-blue-100 text-blue-700',
                                            default     => 'bg-gray-100 text-gray-600',
                                        };
                                        $rolLabel = match($u->role) {
                                            'admin'     => 'Admin',
                                            'conductor' => 'Conductor',
                                            default     => 'Usuario',
                                        };
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 font-medium text-gray-800">{{ $u->name }}</td>
                                        <td class="px-4 py-2 text-gray-500">{{ $u->email }}</td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $rolColor }}">
                                                {{ $rolLabel }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Envíos recientes --}}
                @if($envios->isNotEmpty())
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-base font-bold text-gray-800">Envíos Recientes</h3>
                            <a href="{{ route('envios.index') }}" class="text-xs text-indigo-600 hover:underline">Ver todos →</a>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach($envios as $envio)
                                @php
                                    $badge = match($envio->status) {
                                        'delivered'  => 'bg-green-100 text-green-700',
                                        'in_transit' => 'bg-blue-100 text-blue-700',
                                        default      => 'bg-yellow-100 text-yellow-700',
                                    };
                                    $label = match($envio->status) {
                                        'delivered'  => 'Entregado',
                                        'in_transit' => 'En Tránsito',
                                        default      => 'Pendiente',
                                    };
                                @endphp
                                <div class="flex items-center justify-between px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $badge }}">{{ $label }}</span>
                                        <span class="text-sm font-medium text-gray-800">{{ $envio->type }}</span>
                                        <span class="text-xs text-gray-500">{{ $envio->plant?->name ?? '—' }}</span>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm">
                                        <span class="text-gray-500">{{ $envio->pickup_date->format('d/m/Y') }}</span>
                                        <span class="font-mono font-bold text-gray-700">{{ number_format($envio->kilos_transported, 2) }} kg</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{--  PANEL CONDUCTOR                                         --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            
            @elseif(Auth::user()->role === 'conductor')

                @php
                    $user=Auth::user();
                    $pendientes = $envios->get('pending',    collect());
                    $enTransito = $envios->get('in_transit', collect());
                    $entregados = $envios->get('delivered',  collect());
                @endphp

                {{-- Banner bienvenida --}}
                <div class="bg-indigo-700 p-8 rounded-lg shadow-lg text-white mb-4">
                    <h3 class="text-3xl font-bold">Bienvenido, {{ Auth::user()->name }}</h3>
                    <div class="mt-2 flex gap-6 opacity-90 text-sm">
                        <span>{{ $pendientes->count() + $enTransito->count() }} envíos activos</span>
                        <span>{{ $entregados->count() }} entregados</span>
                    </div>
                </div>

                {{-- Tarjeta de perfil --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 mb-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xl shrink-0">
                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900 truncate">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                        <div class="flex flex-wrap gap-4 mt-1 text-xs text-gray-500">
                            <span>Licencia: <strong class="text-gray-700">{{ $user->license_type ?? 'N/A' }}</strong></span>
                            <span>Teléfono: <strong class="text-gray-700">{{ $user->phone ?? 'N/A' }}</strong></span>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}"
                        class="text-xs text-indigo-600 hover:underline shrink-0">
                        Editar perfil →
                    </a>
                </div>

                {{-- Camión asignado --}}
                @if($miCamion)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 mb-6 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-400 uppercase font-semibold tracking-wide mb-0.5">Mi Vehículo Asignado</p>
                            <p class="font-semibold text-gray-900">{{ $miCamion->model }}</p>
                            <div class="flex flex-wrap gap-4 mt-1 text-xs text-gray-500">
                                <span>Matrícula: <strong class="text-gray-700">{{ $miCamion->plate }}</strong></span>
                                <span>Carga máx.: <strong class="text-gray-700">{{ number_format($miCamion->max_load_kg, 0) }} kg</strong></span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6 text-sm text-yellow-700">
                        No tienes ningún vehículo asignado. Contacta con el administrador.
                    </div>
                @endif

                {{-- Botón crear carga --}}
                <div class="mb-6">
                    <a href="{{ route('residuos.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow font-semibold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Registrar Nueva Carga
                    </a>
                </div>

                {{-- Mis envíos --}}
                @if($pendientes->isNotEmpty() || $enTransito->isNotEmpty() || $entregados->isNotEmpty())
                    <h4 class="text-lg font-bold text-gray-800 mb-4">Mis Envíos</h4>
                @endif

                @if($pendientes->isNotEmpty())
                    <div class="mb-6">
                        <h5 class="text-sm font-semibold text-yellow-700 uppercase tracking-wider mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-yellow-400 inline-block"></span> Pendientes
                        </h5>
                        <div class="space-y-3">
                            @foreach($pendientes as $envio)
                                @include('dashboard._envio_card', ['envio' => $envio, 'colorBorder' => 'border-l-yellow-400', 'colorBg' => 'bg-yellow-50'])
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($enTransito->isNotEmpty())
                    <div class="mb-6">
                        <h5 class="text-sm font-semibold text-blue-700 uppercase tracking-wider mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span> En Tránsito
                        </h5>
                        <div class="space-y-3">
                            @foreach($enTransito as $envio)
                                @include('dashboard._envio_card', ['envio' => $envio, 'colorBorder' => 'border-l-blue-500', 'colorBg' => 'bg-blue-50'])
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($entregados->isNotEmpty())
                    <div class="mb-6">
                        <h5 class="text-sm font-semibold text-green-700 uppercase tracking-wider mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Entregados
                        </h5>
                        <div class="space-y-3">
                            @foreach($entregados as $envio)
                                @include('dashboard._envio_card', ['envio' => $envio, 'colorBorder' => 'border-l-green-500', 'colorBg' => 'bg-green-50'])
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($pendientes->isEmpty() && $enTransito->isEmpty() && $entregados->isEmpty())
                    <div class="bg-white rounded-lg shadow p-8 text-center text-gray-400 mb-6">
                        No tienes envíos asignados todavía.
                    </div>
                @endif

                {{-- Residuos registrados por el conductor --}}
                @if($misResiduos->isNotEmpty())
                    <div class="bg-white rounded-lg shadow overflow-hidden mt-8">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h4 class="text-base font-bold text-gray-800">Cargas que he registrado</h4>
                            <a href="{{ route('residuos.index') }}" class="text-xs text-indigo-600 hover:underline">Ver todas →</a>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach($misResiduos as $r)
                                @php
                                    $rStatus = $r->shipment?->status;
                                @endphp
                                <div class="flex items-center justify-between px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <span>{{ $r->is_hazardous ? '⚠️' : '📦' }}</span>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">{{ $r->type }}</p>
                                            <p class="text-xs text-gray-500">{{ $r->origin_address }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="font-mono text-sm font-bold text-gray-700">{{ $r->kilos }} kg</span>
                                        @if($rStatus === 'delivered')
                                            <span class="text-xs px-2 py-0.5 bg-green-100 text-green-700 rounded-full">Entregado</span>
                                        @elseif($rStatus === 'in_transit')
                                            <span class="text-xs px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full">En tránsito</span>
                                        @else
                                            <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full">Disponible</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{--  PANEL USUARIO NORMAL                                   --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            @else

                {{-- Botón principal crear carga --}}
                <div class="mb-8 text-center">
                    <a href="{{ route('residuos.create') }}"
                        class="inline-flex items-center gap-3 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg font-bold text-base transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Registrar Nueva Carga de Residuos
                    </a>
                    <p class="mt-2 text-xs text-gray-400">Un conductor recogerá tu carga cuando sea asignada.</p>
                </div>

                @php
                    $sinAsignar   = $misResiduos->whereNull('shipment_id');
                    $programadosU = $misResiduos->whereNotNull('shipment_id')->filter(fn($r) => $r->shipment?->status === 'pending');
                    $enTransitoU  = $misResiduos->whereNotNull('shipment_id')->filter(fn($r) => $r->shipment?->status === 'in_transit');
                    $entregadosU  = $misResiduos->whereNotNull('shipment_id')->filter(fn($r) => $r->shipment?->status === 'delivered');
                @endphp

                @if($misResiduos->isEmpty())
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>
                        <p class="text-gray-400 text-lg font-medium">Aún no tienes cargas registradas</p>
                        <p class="text-gray-300 text-sm mt-1">Pulsa el botón de arriba para añadir tu primer residuo.</p>
                    </div>
                @else

                    {{-- Sin asignar --}}
                    @if($sinAsignar->isNotEmpty())
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-gray-400 inline-block"></span>
                                En espera de recogida
                            </h4>
                            <div class="space-y-2">
                                @foreach($sinAsignar as $r)
                                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 flex items-center justify-between px-5 py-3">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">{{ $r->is_hazardous ? '⚠️' : '📦' }}</span>
                                            <div>
                                                <p class="text-sm font-bold text-gray-800">{{ $r->type }}</p>
                                                <p class="text-xs text-gray-500">{{ $r->origin_address }}</p>
                                            </div>
                                        </div>
                                        <span class="font-mono text-sm font-bold text-gray-600">{{ $r->kilos }} kg</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Recogida programada (pending) --}}
                    @if($programadosU->isNotEmpty())
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-yellow-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-yellow-400 inline-block"></span>
                                Recogida programada
                            </h4>
                            <div class="space-y-2">
                                @foreach($programadosU as $r)
                                    <div class="bg-yellow-50 border border-yellow-200 border-l-4 border-l-yellow-400 rounded-lg flex items-center justify-between px-5 py-3">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">{{ $r->is_hazardous ? '⚠️' : '📦' }}</span>
                                            <div>
                                                <p class="text-sm font-bold text-gray-800">{{ $r->type }}</p>
                                                <p class="text-xs text-gray-500">{{ $r->origin_address }}</p>
                                                @if($r->shipment?->pickup_date)
                                                    <p class="text-xs text-yellow-600">Fecha de recogida: {{ $r->shipment->pickup_date->format('d/m/Y') }}</p>
                                                @endif
                                                @if($r->shipment?->truck)
                                                    <p class="text-xs text-yellow-700 font-medium">
                                                        Camión: {{ $r->shipment->truck->model }} ({{ $r->shipment->truck->plate }})
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="font-mono text-sm font-bold text-gray-600">{{ $r->kilos }} kg</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- En tránsito --}}
                    @if($enTransitoU->isNotEmpty())
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-blue-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span>
                                En camino a la planta
                            </h4>
                            <div class="space-y-2">
                                @foreach($enTransitoU as $r)
                                    <div class="bg-blue-50 border border-blue-200 border-l-4 border-l-blue-500 rounded-lg flex items-center justify-between px-5 py-3">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">{{ $r->is_hazardous ? '⚠️' : '📦' }}</span>
                                            <div>
                                                <p class="text-sm font-bold text-gray-800">{{ $r->type }}</p>
                                                <p class="text-xs text-gray-500">{{ $r->origin_address }}</p>
                                                @if($r->shipment?->plant)
                                                    <p class="text-xs text-blue-600">Destino: {{ $r->shipment->plant->name }}</p>
                                                @endif
                                                @if($r->shipment?->pickup_date)
                                                    <p class="text-xs text-blue-500">Recogida: {{ $r->shipment->pickup_date->format('d/m/Y') }}</p>
                                                @endif
                                                @if($r->shipment?->truck)
                                                    <p class="text-xs text-blue-700 font-medium">
                                                        Camión: {{ $r->shipment->truck->model }} ({{ $r->shipment->truck->plate }})
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="font-mono text-sm font-bold text-gray-600">{{ $r->kilos }} kg</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Entregados --}}
                    @if($entregadosU->isNotEmpty())
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-green-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                                Entregados en planta
                            </h4>
                            <div class="space-y-2">
                                @foreach($entregadosU as $r)
                                    <div class="bg-green-50 border border-green-200 border-l-4 border-l-green-500 rounded-lg flex items-center justify-between px-5 py-3 opacity-80">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">{{ $r->is_hazardous ? '⚠️' : '📦' }}</span>
                                            <div>
                                                <p class="text-sm font-bold text-gray-700">{{ $r->type }}</p>
                                                <p class="text-xs text-gray-500">{{ $r->origin_address }}</p>
                                                @if($r->shipment?->plant)
                                                    <p class="text-xs text-green-600">Entregado en: {{ $r->shipment->plant->name }}</p>
                                                @endif
                                                @if($r->shipment?->delivery_date)
                                                    <p class="text-xs text-green-500">Fecha: {{ $r->shipment->delivery_date->format('d/m/Y') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="font-mono text-sm text-gray-500">{{ $r->kilos }} kg</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                @endif

            @endif

        </div>
    </div>
</x-app-layout>
