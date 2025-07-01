<div>
<footer class="bg-[#181e29] text-white">
    <div class="max-w-6xl mx-auto px-4 py-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-6">
            <div>
                <h4 class="font-bold mb-2">Audios</h4>
                <ul class="space-y-1 text-gray-200">
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ url('/compositions?category=' . urlencode($cat)) }}" class="hover:text-amber-500">{{ $cat }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-2">PDF Scores</h4>
                <ul class="space-y-1 text-gray-200">
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ url('/compositions?category=' . urlencode($cat)) }}" class="hover:text-amber-500">{{ $cat }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-2">Connect</h4>
                <div class="flex gap-4 mt-2">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link['url'] }}" target="_blank" class="text-gray-400 hover:text-amber-500">
                            @switch($link['icon'])
                                @case('facebook')
                                    {{-- Facebook SVG --}}
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22 12c0-5.522-4.477-10-10-10S2 6.478 2 12c0 5.019 3.676 9.163 8.438 9.877v-6.987h-2.54v-2.89h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.242 0-1.63.771-1.63 1.562v1.875h2.773l-.443 2.89h-2.33v6.987C18.324 21.163 22 17.019 22 12"/>
                                    </svg>
                                    @break
                                @case('instagram')
                                    {{-- Instagram SVG --}}
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect width="20" height="20" x="2" y="2" rx="5" fill="none" stroke="currentColor" stroke-width="2"/>
                                        <circle cx="12" cy="12" r="5" fill="none" stroke="currentColor" stroke-width="2"/>
                                        <circle cx="17" cy="7" r="1.5" fill="currentColor"/>
                                    </svg>
                                    @break
                                @case('twitter')
                                    {{-- Twitter SVG --}}
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22.46 6c-.77.35-1.6.59-2.46.69a4.3 4.3 0 0 0 1.88-2.37 8.59 8.59 0 0 1-2.72 1.04A4.28 4.28 0 0 0 16.11 4c-2.37 0-4.29 1.92-4.29 4.29 0 .34.04.67.11.99C7.69 9.13 4.07 7.38 1.64 4.7c-.37.64-.58 1.38-.58 2.17 0 1.5.76 2.82 1.92 3.6a4.27 4.27 0 0 1-1.94-.54v.05c0 2.1 1.5 3.85 3.5 4.25a4.3 4.3 0 0 1-1.93.07c.54 1.68 2.1 2.9 3.95 2.93A8.6 8.6 0 0 1 2 19.54a12.13 12.13 0 0 0 6.56 1.92c7.88 0 12.2-6.53 12.2-12.2 0-.19 0-.39-.01-.58A8.72 8.72 0 0 0 24 4.59a8.59 8.59 0 0 1-2.54.7z"/>
                                    </svg>
                                    @break
                                @case('youtube')
                                    {{-- YouTube SVG --}}
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M21.8 8.001a2.752 2.752 0 0 0-1.938-1.948C18.077 6 12 6 12 6s-6.077 0-7.862.053A2.752 2.752 0 0 0 2.2 8.001 28.934 28.934 0 0 0 2 12a28.934 28.934 0 0 0 .2 3.999 2.752 2.752 0 0 0 1.938 1.948C5.923 18 12 18 12 18s6.077 0 7.862-.053a2.752 2.752 0 0 0 1.938-1.948A28.934 28.934 0 0 0 22 12a28.934 28.934 0 0 0-.2-3.999zM9.545 15.568V8.432l6.545 3.568-6.545 3.568z"/>
                                    </svg>
                                    @break
                                @default
                                    {{-- Icono genérico --}}
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                        <path d="M2 12h20M12 2a15.3 15.3 0 0 1 0 20M12 2a15.3 15.3 0 0 0 0 20" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                            @endswitch
                        </a>
                    @endforeach
                </div>
            </div>
            {{-- <div>
                <h4 class="font-bold mb-2">Contact</h4>
                <a href="/contact" class="block bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2 px-6 rounded text-center mt-2">Contact Now!</a>
            </div> --}}
        </div>
        <hr class="border-amber-900/20 my-6">
            <div class="text-center text-gray-400 text-sm">
                <div class="flex flex-col md:flex-row items-center justify-center gap-2 mb-2">
                    © {{ date('Y') }} LatinGuitarScores | Developed by
                    <img src="{{ asset('images/techdxlogo.png') }}" alt="Tech DX Logo" class="h-20 inline-block align-middle">
                </div>
                <div class="flex items-center justify-center gap-2 mt-2">
                    <a href="mailto:jaimearomero@yahoo.com" class="hover:text-amber-500 transition-colors">jaimearomero@yahoo.com</a>
                </div>
            </div>
    </div>
</footer>
</div>
