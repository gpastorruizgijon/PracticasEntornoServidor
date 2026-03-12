@extends('layouts.app')

@section('content')
<h1>Registrar Nuevo Camión</h1>

<form action="{{ route('camiones.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Matrícula (Única)</label>
        <input type="text" name="plate" class="form-control" placeholder="Ej: 1234-BBB" required>
    </div>

    <div class="mb-3">
        <label>Modelo</label>
        <input type="text" name="model" class="form-control" placeholder="Ej: Volvo FH16" required>
    </div>

    <div class="mb-3">
        <label>Carga Máxima (kg)</label>
        <input type="number" name="max_load_kg" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Asignar Conductor</label>
        <select name="user_id" class="form-control" required>
            <option value="">Selecciona un conductor...</option>
            @foreach($conductores as $conductor)
                <option value="{{ $conductor->id }}">{{ $conductor->name }} ({{ $conductor->license_type }})</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar Camión</button>
</form>
@endsection