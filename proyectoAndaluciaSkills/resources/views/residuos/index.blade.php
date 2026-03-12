@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestión de Residuos</h1>
    <a href="{{ route('residuos.create') }}" class="btn btn-primary">Registrar Nueva Carga</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tipo de Material</th>
                    <th>Peso Total (kg)</th>
                    <th>Origen</th>
                    <th>Peligroso</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($residuos as $residuo)
                <tr>
                    <td>{{ $residuo->id }}</td>
                    <td><strong>{{ $residuo->type }}</strong></td>
                    <td>{{ number_format($residuo->kilos, 2) }} kg</td>
                    <td>{{ $residuo->origin_address }}</td>
                    <td>
                        @if($residuo->is_hazardous)
                            <span class="badge bg-danger">SÍ</span>
                        @else
                            <span class="badge bg-success">NO</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('residuos.edit', $residuo->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('residuos.destroy', $residuo->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Borrar esta carga?')">Borrar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection