<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Latin Guitar Scores - Jaime Romero | Classical Guitarist & Composer</title>
    <meta name="description" content="Discover the scores, biography, and gallery of Jaime Romero, an internationally awarded Colombian classical guitarist and composer.">
    <meta name="author" content="Jaime Romero">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    
    @livewireStyles
    
<style>
        body { 
            font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif; 
            position: relative;
            min-height: 100vh;
        }
        [x-cloak] { 
            display: none !important; 
        }
        #floating-container {
            position: fixed !important;
            bottom: 1rem !important;
            right: 1rem !important;
            z-index: 99999 !important;
            pointer-events: none !important;
            width: auto !important;
            height: auto !important;
        }
        #floating-container > * {
            pointer-events: auto !important;
        }
        
        /* Ocultar completamente el widget de Google Translate */
        #google_translate_element {
            display: none !important;
            visibility: hidden !important;
            position: absolute !important;
            left: -9999px !important;
            top: -9999px !important;
            width: 0 !important;
            height: 0 !important;
            overflow: hidden !important;
        }
        
        /* Ocultar todos los elementos relacionados con Google Translate */
        .goog-te-gadget,
        .goog-te-combo,
        .goog-te-banner-frame,
        .VIpgJd-yAWNEb-L7lbkb,
        .goog-te-gadget-simple,
        .VIpgJd-ZVi9od-xl07Ob-lTBxed {
            display: none !important;
            visibility: hidden !important;
        }
        
        /* Ocultar la barra de traducción que aparece arriba después de traducir */
        .goog-te-banner,
        .goog-te-banner-frame,
        body > .skiptranslate,
        #goog-gt-tt,
        .goog-tooltip,
        .goog-te-spinner-pos,
        .goog-te-balloon-frame {
            display: none !important;
            visibility: hidden !important;
            position: absolute !important;
            left: -9999px !important;
            top: -9999px !important;
        }
        
        /* Permitir que los iframes de traducción funcionen pero mantenerlos ocultos */
        iframe.VIpgJd-ZVi9od-xl07Ob-OEVmcd,
        iframe[class*="goog-te"] {
            opacity: 0 !important;
            pointer-events: none !important;
        }
        .goog-te-banner-frame {
            display: none !important;
        }
    </style>

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
<body class="font-sans notranslate">
    {{-- Contenido principal --}}
    <main class="relative z-0 pt-16">
        @livewire('frontend.navbar')
        @livewire('frontend.hero')
        @livewire('frontend.featured-compositions')
        @livewire('frontend.categories')
        @livewire('frontend.footer')
    </main>

    {{-- Componente flotante fuera del flujo principal --}}
    <div id="floating-container">
        @livewire('frontend.floating-latest-composition')
    </div>

    {{-- Google Translate Element --}}
    <div id="google_translate_element"></div>

    {{-- Scripts al final del body --}}
    @livewireScripts
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- Translation System --}}
    <script src="{{ asset('js/translation.js') }}" defer></script>

</body>
</html>