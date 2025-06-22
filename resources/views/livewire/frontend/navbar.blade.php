
<nav class="bg-white shadow fixed top-0 w-full z-50 text-4xl">
    <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between px-4 py-2 text-4xl">
        {{-- Izquierda: Logo y subtítulo --}}
        <div class="flex items-center gap-2 min-w-max">
            <a href="/" class="flex items-center gap-2">
                <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" fill="currentColor"/>
                    <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <span class="text-lg font-bold text-gray-900 leading-tight">Jaime Romero</span>
            </a>
            <span class="ml-2 text-xs text-gray-500 hidden sm:inline">LatinGuitarScores</span>
        </div>

        {{-- Botón hamburguesa para móvil --}}
        <button id="navbar-toggle" class="sm:hidden flex items-center px-2 py-1 border rounded text-gray-700 border-gray-300 hover:bg-amber-50 focus:outline-none" onclick="document.getElementById('navbar-menu').classList.toggle('hidden')">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- Centro y derecha: Menú y social --}}
        <div id="navbar-menu" class="w-full sm:w-auto sm:flex flex-col sm:flex-row items-center gap-6 hidden mt-2 sm:mt-0">
            <ul class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6 text-sm font-medium text-gray-700 mb-2 sm:mb-0">
                <li><a href="/" class="hover:text-amber-600 block py-2 px-2">Home</a></li>
                <li><a href="/gallery" class="hover:text-amber-600 block py-2 px-2">Gallery</a></li>
                <li><a href="/bio" class="hover:text-amber-600 block py-2 px-2">Bio</a></li>
                {{-- <li><a href="/contact" class="hover:text-amber-600 block py-2 px-2">Contact</a></li> --}}
            </ul>
            <div class="flex items-center gap-3 justify-end min-w-max">
                @foreach($socialLinks as $link)
                    <a href="{{ $link['url'] }}" target="_blank" class="text-gray-600 hover:text-amber-500">
                        @switch($link['icon'])
                            @case('facebook')
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22 12c0-5.522-4.477-10-10-10S2 6.478 2 12c0 5.019 3.676 9.163 8.438 9.877v-6.987h-2.54v-2.89h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.242 0-1.63.771-1.63 1.562v1.875h2.773l-.443 2.89h-2.33v6.987C18.324 21.163 22 17.019 22 12"/>
                                </svg>
                                @break
                            @case('instagram')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect width="20" height="20" x="2" y="2" rx="5" fill="none" stroke="currentColor" stroke-width="2"/>
                                    <circle cx="12" cy="12" r="5" fill="none" stroke="currentColor" stroke-width="2"/>
                                    <circle cx="17" cy="7" r="1.5" fill="currentColor"/>
                                </svg>
                                @break
                            @case('youtube')
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21.8 8.001a2.752 2.752 0 0 0-1.938-1.948C18.077 6 12 6 12 6s-6.077 0-7.862.053A2.752 2.752 0 0 0 2.2 8.001 28.934 28.934 0 0 0 2 12a28.934 28.934 0 0 0 .2 3.999 2.752 2.752 0 0 0 1.938 1.948C5.923 18 12 18 12 18s6.077 0 7.862-.053a2.752 2.752 0 0 0 1.938-1.948A28.934 28.934 0 0 0 22 12a28.934 28.934 0 0 0-.2-3.999zM10 15V9l5 3-5 3z"/>
                                </svg>
                                @break
                            @case('twitter')
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.59-2.46.69a4.3 4.3 0 0 0 1.88-2.37 8.59 8.59 0 0 1-2.72 1.04A4.28 4.28 0 0 0 16.11 4c-2.37 0-4.29 1.92-4.29 4.29 0 .34.04.67.11.99C7.69 9.13 4.07 7.38 1.64 4.7c-.37.64-.58 1.38-.58 2.17 0 1.5.76 2.82 1.92 3.6a4.27 4.27 0 0 1-1.94-.54v.05c0 2.1 1.5 3.85 3.5 4.25-.36.1-.74.16-1.13.16-.28 0-.54-.03-.8-.08.54 1.68 2.12 2.9 3.99 2.93A8.6 8.6 0 0 1 2 19.54c-.29 0-.57-.02-.85-.05A12.13 12.13 0 0 0 8.29 21c7.55 0 11.68-6.26 11.68-11.68 0-.18-.01-.36-.02-.54A8.18 8.18 0 0 0 22.46 6z"/>
                                </svg>
                                @break
                            @default
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                    <path d="M2 12h20M12 2a15.3 15.3 0 0 1 0 20M12 2a15.3 15.3 0 0 0 0 20" stroke="currentColor" stroke-width="2"/>
                                </svg>
                        @endswitch
                    </a>
                @endforeach

                {{-- Selector idioma --}}
                {{-- <div class="flex gap-2 mt-2 sm:mt-0">
                    <button type="button" onclick="setLanguage('es')" class="text-sm border rounded p-1 bg-white hover:bg-amber-100">ES</button>
                    <button type="button" onclick="setLanguage('en')" class="text-sm border rounded p-1 bg-white hover:bg-amber-100">EN</button>
                </div> --}}
            </div>
        </div>
    </div>
</nav>
