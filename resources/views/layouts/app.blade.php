<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Loging</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Encode+Sans:wdth,wght@75..125,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('build/assets/css/app.css') }}">
</head>
<body>
    {{-- Header --}}
    @include('layouts.header')

    {{-- menu verical --}}
    @include('layouts.menu')

    <div class="contenido">
        <main>
         {{-- @yield('content') --}}
         {{ $slot }}
        </main>
    </div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
