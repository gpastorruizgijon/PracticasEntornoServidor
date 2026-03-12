@extends('layouts.app')

@section('content')
<h1>Editar Camión: {{ $camione->plate }}</h1>

<form action="{{ route('camiones.update', $camione->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Modelo</label>
        <input type="text" name="model" class="form-control" value="{{ $camione->model }}" required>
    </div>
    <div class="mb-3">
        <label>Carga Máxima (kg)</label>
        <input type="number" name="max_load_kg" class="form-control" value="{{ $camione->max_load_kg }}" required>
    </div>
    <div class="mb-3">
        <label>Cambiar Conductor</label>
        <select name="user_id" class="form-control" required>
            @foreach($conductores as $conductor)
                <option value="{{ $conductor->id }}" {{ $camione->user_id == $conductor->id ? 'selected' : '' }}>
                    {{ $conductor->name }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-warning">Actualizar Datos</button>
</form>
@endsection