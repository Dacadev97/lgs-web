@if($latestComposition && $showComponent)
<div
    wire:init="$set('isVisible', true)"
    x-data="{ show: @entangle('isVisible').defer }"
    x-cloak
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-2"
    class="fixed bottom-4 right-4 z-[9999] w-72 bg-white rounded-lg shadow-xl border border-amber-100 overflow-hidden hover:shadow-2xl"
>
    <div class="p-4">
        <button 
            @click="show = false"
            wire:click="close"
            class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 transition-colors"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <!-- ...resto del código... -->
    </div>
</div>
@endif