@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Historial de Envíos</h1>
    <a href="{{ route('envios.create') }}" class="btn btn-primary">Nuevo Envío</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Fecha Entrega</th>
                    <th>Residuo</th>
                    <th>Peso</th>
                    <th>Camión (Matrícula)</th>
                    <th>Planta Destino</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($envios as $envio)
                <tr>
                    <td>{{ $envio->delivery_date->format('d/m/Y') }}</td>
                    <td>{{ $envio->waste->type }}</td>
                    <td>{{ number_format($envio->kilos_transported, 2) }} kg</td>
                    <td>{{ $envio->truck->plate }}</td>
                    <td>{{ $envio->plant->name }}</td>
                    <td>
                        <form action="{{ route('envios.destroy', $envio->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Anular</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection