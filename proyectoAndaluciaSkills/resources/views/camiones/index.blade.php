@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Flota de Camiones</h1>
    <a href="{{ route('camiones.create') }}" class="btn btn-primary">Añadir Camión</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Matrícula</th>
                    <th>Modelo</th>
                    <th>Capacidad Máxima</th>
                    <th>Conductor Asignado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($camiones as $camion)
                <tr>
                    <td><span class="badge bg-secondary">{{ $camion->plate }}</span></td>
                    <td>{{ $camion->model }}</td>
                    <td>{{ number_format($camion->max_load_kg, 0) }} kg</td>
                    <td>
                        @if($camion->driver)
                            {{ $camion->driver->name }}
                            @if($camion->driver->trashed())
                                <small class="text-muted">(Baja del sistema)</small>
                            @endif
                        @else
                            <span class="text-danger">Sin conductor</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('camiones.edit', $camion->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('camiones.destroy', $camion->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar camión?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection