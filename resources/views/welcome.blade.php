<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latin Guitar Scores - Jaime Romero | Classical Guitarist & Composer</title>
    <meta name="description" content="Discover the scores, biography, and gallery of Jaime Romero, an internationally awarded Colombian classical guitarist and composer.">
    <meta name="author" content="Jaime Romero">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif; }
    </style>
    @livewireStyles
    
    @php
        $manifestPath = public_path('build/manifest.json');
        $useVite = !file_exists($manifestPath) || app()->environment('local');
    @endphp
    
    @if($useVite)
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        @php
            $manifest = json_decode(file_get_contents($manifestPath), true);
            $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
            $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
        @endphp
        @if($cssFile)
            <link rel="stylesheet" href="{{ asset('build/' . $cssFile) }}">
        @else
            <!-- Fallback CSS -->
            <link rel="stylesheet" href="{{ asset('build/assets/app-9c741352.css') }}">
        @endif
        @if($jsFile)
            <script src="{{ asset('build/' . $jsFile) }}" defer></script>
        @else
            <!-- Fallback JS -->
            <script src="{{ asset('build/assets/app-f68654ee.js') }}" defer></script>
        @endif
    @endif
</head>
<body class="font-sans">
    @livewire('frontend.navbar')
    @livewire('frontend.hero')
    @livewire('frontend.featured-compositions')
    @livewire('frontend.categories')
    @livewire('frontend.footer')
    @livewire('frontend.floating-latest-composition')

    @livewireScripts
</body>
</html>
