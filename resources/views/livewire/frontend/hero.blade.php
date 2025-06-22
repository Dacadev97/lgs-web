<div>
    @if($image && $text)
    <section class="relative w-full min-h-[320px] sm:min-h-[400px] md:min-h-[480px] flex flex-col items-center justify-center bg-[#FFF9ED] overflow-hidden py-8 sm:py-12">
        {{-- Imagen de fondo --}}
        <img src="{{ asset('storage/' . ltrim($image, '/')) }}"
             alt="Hero"
             class="absolute inset-0 w-full h-full object-cover opacity-20 pointer-events-none select-none" />

        <div class="relative z-10 flex flex-col items-center w-full max-w-3xl mx-auto px-4">
            {{-- Badge superior --}}
            <span class="mb-4 px-4 py-1 rounded-full border border-amber-200 bg-white/80 text-amber-700 text-xs font-semibold shadow-sm">
                Nationally Awarded Composer
            </span>
            {{-- Título principal --}}
            <h1 class="text-2xl sm:text-3xl md:text-5xl font-extrabold text-gray-900 text-center mb-2 drop-shadow-lg">
                Jaime Romero
            </h1>
            {{-- Subtítulo --}}
            <h2 class="text-base sm:text-lg md:text-xl text-gray-700 font-medium text-center mb-6 tracking-wide">
                COLOMBIAN MUSIC AROUND THE WORLD
            </h2>
            {{-- Caja de descripción y botones --}}
            <div class="w-full bg-white/90 border border-amber-100 rounded-xl shadow p-4 sm:p-6 flex flex-col items-center">          
                <p class="text-gray-700 text-sm sm:text-base md:text-lg text-center mb-6">
                    {!! $text !!}
                </p>
            </div>
        </div>
    </section>
    @endif
</div>
