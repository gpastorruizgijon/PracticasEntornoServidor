@extends('layouts.app')

@section('content')
<div class="card col-md-8 mx-auto">
    <div class="card-header bg-primary text-white"><h3>Registrar Entrada de Residuo</h3></div>
    <div class="card-body">
        <form action="{{ route('residuos.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Tipo de Material</label>
                <input type="text" name="type" class="form-control" placeholder="Ej: Plástico PET" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kilos Totales</label>
                <input type="number" name="kilos" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Dirección de Origen</label>
                <input type="text" name="origin_address" class="form-control" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_hazardous" value="1" class="form-check-input" id="hazard">
                <label class="form-check-label" for="hazard">¿Es material peligroso?</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Guardar Residuo</button>
        </form>
    </div>
</div>
@endsection