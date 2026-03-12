@extends('layouts.app')

@section('content')
<div class="card col-md-6 mx-auto">
    <div class="card-header bg-dark text-white"><h3>Registrar Conductor</h3></div>
    <div class="card-body">
        <form action="{{ route('conductores.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nombre Completo</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Correo Electrónico</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Tipo de Licencia</label>
                <select name="license_type" class="form-control" required>
                    <option value="C1">Clase C1 (Camiones rígidos)</option>
                    <option value="C+E">Clase C+E (Tráiler)</option>
                    <option value="ADR">ADR (Mercancías Peligrosas)</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Teléfono</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100">Guardar Conductor</button>
        </form>
    </div>
</div>
@endsection