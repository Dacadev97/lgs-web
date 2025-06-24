<div>
    @if($latestComposition && $visible)
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="fixed bottom-[60%] right-12 md:bottom-[70%] md:right-10 z-[999999] w-72 bg-gradient-to-br from-white to-amber-50 rounded-lg shadow-xl border border-amber-200 overflow-hidden hover:shadow-2xl transform-gpu transition-all duration-300 ease-in-out group"
        >
            {{-- Banner de New Release con botón de cerrar --}}
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 text-white px-3 py-1.5 flex items-center justify-between">
                <span class="text-xs font-bold">New Release</span>
                <button 
                    @click="show = false"
                    wire:click="close"
                    class="text-white/80 hover:text-white transition-colors focus:outline-none"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-4 space-y-3">
                {{-- Título y Categoría --}}
                <div>
                    <h4 class="text-lg font-medium text-amber-600 truncate hover:text-amber-700 transition-colors cursor-pointer">
                        {{ $latestComposition->title }}
                    </h4>
                    @if($latestComposition->category)
                        <span class="text-sm text-gray-500">{{ $latestComposition->category->name }}</span>
                    @endif
                </div>

                {{-- Reproductor de Audio --}}
                @if($latestComposition->hasAudio())
                    <div class="bg-gray-50 rounded-lg p-2">
                        <audio 
                            controls 
                            class="w-full h-8"
                            preload="metadata"
                        >
                            <source src="{{ $latestComposition->getAudioUrl() }}" type="audio/mpeg">
                            Tu navegador no soporta el elemento de audio.
                        </audio>
                    </div>
                @endif

                {{-- Acciones --}}
                <div class="flex justify-end gap-2">
                    @if($latestComposition->hasPdf())
                        <a 
                            href="{{ route('preview.pdf', $latestComposition->id) }}" 
                            target="_blank"
                            class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-medium hover:bg-amber-200 transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500/50 gap-1"
                        >
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Preview
                        </a>
                    @endif
                    @if($latestComposition->hasFiles())
                        <a 
                            href="{{ route('download.package', $latestComposition->id) }}" 
                            class="inline-flex items-center px-3 py-1 bg-amber-500 text-white rounded-full text-xs font-medium hover:bg-amber-600 transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500/50 gap-1"
                        >
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>