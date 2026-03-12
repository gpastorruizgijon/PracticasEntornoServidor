@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Plantas de Reciclaje</h1>
    <a href="{{ route('plantas.create') }}" class="btn btn-primary">Nueva Planta</a>
    
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ciudad</th>
                <th>Capacidad Máxima</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plantas as $planta)
            <tr>
                <td>{{ $planta->name }}</td> <td>{{ $planta->city }}</td> <td>{{ $planta->max_capacity_kg }} kg</td> <td>
                    <a href="{{ route('plantas.edit', $planta->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('plantas.destroy', $planta->id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Borrar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection