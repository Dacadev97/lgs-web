@if($latestComposition && $visible)
    <div
        x-data
        x-cloak
        x-init="setTimeout(() => $el.classList.add('show'), 500)"
        class="fixed bottom-4 right-4 z-[9999] w-72 bg-white rounded-lg shadow-xl border border-amber-100 overflow-hidden hover:shadow-2xl transition-all duration-300 opacity-0 transform translate-y-2"
        :class="{ 'show': true }"
    >
        <div class="p-4">
            <button 
                wire:click="close"
                class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <h3 class="font-semibold text-gray-900 mb-2">Latest Composition</h3>
            <div class="mb-3">
                <h4 class="text-lg font-medium text-amber-600">{{ $latestComposition->title }}</h4>
                @if($latestComposition->category)
                    <span class="text-sm text-gray-500">{{ $latestComposition->category->name }}</span>
                @endif
            </div>
            
            <div class="flex justify-end gap-2">
                @if($latestComposition->pdf)
                    <a 
                        href="{{ route('preview.pdf', $latestComposition->id) }}" 
                        target="_blank"
                        class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-sm hover:bg-amber-200 transition-colors"
                    >
                        Preview PDF
                    </a>
                @endif
            </div>
        </div>
    </div>

    <style>
        .show {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
    </style>
@endif