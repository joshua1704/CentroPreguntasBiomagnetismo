<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @php
        $manifestPath = public_path('build/manifest.json');

        if (!file_exists($manifestPath)) {
            throw new Exception('Vite manifest not found');
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);

        $appjs = $manifest['resources/js/app.js'];
        $appcss = $manifest['resources/css/app.css'];
    @endphp

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('build/' . $appcss['file']) }}" rel="stylesheet">

    {{-- JS --}}
    <script src="{{ asset('build/' . $appjs['file']) }}" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon_icon.png') }}">
</head>
<body>
    @yield('content')
</body>
</html>
