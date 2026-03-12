@extends('layouts.app')

@section('content')
<h1>Editar Residuo #{{ $residuo->id }}</h1>

<form action="{{ route('residuos.update', $residuo->id) }}" method="POST">
    @csrf
    @method('PUT') {{-- Obligatorio para actualizaciones --}}
    
    <div class="mb-3">
        <label>Tipo de Material</label>
        <input type="text" name="type" class="form-control" value="{{ $residuo->type }}" required>
    </div>

    <div class="mb-3">
        <label>Kilos Totales</label>
        <input type="number" name="kilos" class="form-control" value="{{ $residuo->kilos }}" required>
    </div>

    <div class="mb-3">
        <label>Dirección de Origen</label>
        <input type="text" name="origin_address" class="form-control" value="{{ $residuo->origin_address }}" required>
    </div>

    <div class="mb-3">
        <label>¿Es peligroso?</label>
        <select name="is_hazardous" class="form-control">
            <option value="0" {{ !$residuo->is_hazardous ? 'selected' : '' }}>No</option>
            <option value="1" {{ $residuo->is_hazardous ? 'selected' : '' }}>Sí</option>
        </select>
    </div>

    <button type="submit" class="btn btn-warning">Actualizar Residuo</button>
    <a href="{{ route('residuos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection