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
            class="fixed bottom-4 right-4 z-[999999] w-72 bg-white/95 backdrop-blur-sm rounded-lg shadow-2xl border-2 border-amber-200 overflow-hidden hover:shadow-2xl transform-gpu transition-all duration-300 ease-in-out"
        >
            <div class="relative p-4 bg-white/95 backdrop-blur">
                <button 
                    @click="show = false"
                    wire:click="close"
                    class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500/50 rounded-full p-1"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <h3 class="font-semibold text-gray-900 mb-2">Latest Composition</h3>
                <div class="mb-3">
                    <h4 class="text-lg font-medium text-amber-600 truncate">{{ $latestComposition->title }}</h4>
                    @if($latestComposition->category)
                        <span class="text-sm text-gray-500">{{ $latestComposition->category->name }}</span>
                    @endif
                </div>
                
                <div class="flex justify-end gap-2">
                    @if($latestComposition->hasPdf())
                        <a 
                            href="{{ route('preview.pdf', $latestComposition->id) }}" 
                            target="_blank"
                            class="px-3 py-1.5 bg-amber-100 text-amber-700 rounded-full text-sm hover:bg-amber-200 transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500/50"
                        >
                            Preview PDF
                        </a>
                    @endif
                    @if($latestComposition->hasFiles())
                        <a 
                            href="{{ route('download.package', $latestComposition->id) }}" 
                            class="px-3 py-1.5 bg-amber-500 text-white rounded-full text-sm hover:bg-amber-600 transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500/50"
                        >
                            Download
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>