<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @php
    $manifest = json_decode(
        file_get_contents(public_path('build/manifest.json')),
        true
    );

    $bundle = $manifest['resources/js/admin.js'];
    @endphp

    @foreach ($bundle['css'] ?? [] as $css)
        <link rel="stylesheet" href="{{ asset('build/' . $css) }}">
    @endforeach

    <script src="{{ asset('build/' . $bundle['file']) }}" defer></script>

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon_icon.png') }}">
</head>
<body>
    @yield('content')
</body>
</html>
