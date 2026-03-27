<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Reciclaje</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">RecyclingPlant System</a>
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('plantas.index') }}">Plantas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('residuos.index') }}">Residuos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('camiones.index') }}">Camiones</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.index') }}">Conductores</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('envios.index') }}">Envíos</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</body>

</html>