<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Latin Guitar Scores')</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite CSS -->
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
    
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased bg-white pt-16">
    @livewire('frontend.navbar')
    
    <main>
        {{ $slot }}
    </main>
    
    @livewire('frontend.footer')
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Translation System -->
    <script src="{{ asset('js/translation.js') }}" defer></script>
</body>
</html>

