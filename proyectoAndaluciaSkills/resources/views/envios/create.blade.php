@extends('layouts.app')

@section('content')
<h1>Nuevo Envío</h1>

<form action="{{ route('envios.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Residuo (Origen)</label>
        <select name="waste_id" class="form-control">
            @foreach($residuos as $r)
                <option value="{{ $r->id }}">{{ $r->type }} ({{ $r->kilos }}kg)</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Camión y Conductor</label>
        <select name="truck_id" class="form-control">
            @foreach($camiones as $c)
                <option value="{{ $c->id }}">{{ $c->plate }} - {{ $c->driver->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Planta de Destino</label>
        <select name="recycling_plant_id" class="form-control">
            @foreach($plantas as $p)
                <option value="{{ $p->id }}">{{ $p->name }} (Cap: {{ $p->max_capacity_kg }}kg)</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Kilos a transportar</label>
        <input type="number" name="kilos_transported" class="form-control">
        @error('kilos_transported') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="row">
        <div class="col"><label>Fecha Recogida</label><input type="date" name="pickup_date" class="form-control"></div>
        <div class="col"><label>Fecha Entrega</label><input type="date" name="delivery_date" class="form-control"></div>
    </div>

    <button type="submit" class="btn btn-success mt-4">Registrar Envío</button>
</form>
@endsection