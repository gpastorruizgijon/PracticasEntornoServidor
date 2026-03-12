@extends('layouts.app')

@section('content')
<h1>Editar Planta: {{ $planta->name }}</h1>

<form action="{{ route('plantas.update', $planta->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nombre de la Planta</label>
        <input type="text" name="name" class="form-control" value="{{ $planta->name }}" required>
    </div>
    <div class="mb-3">
        <label>Capacidad Máxima (kg)</label>
        <input type="number" name="max_capacity_kg" class="form-control" value="{{ $planta->max_capacity_kg }}" required>
    </div>
    <div class="mb-3">
        <label>Ciudad</label>
        <input type="text" name="city" class="form-control" value="{{ $planta->city }}" required>
    </div>
    <button type="submit" class="btn btn-warning">Guardar Cambios</button>
</form>
@endsection