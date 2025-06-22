<div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-100">
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{ __('Gallery') }}</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">{{ __('Explore our visual collection of Latin guitar music and performances') }}</p>
            </div>
            
            <!-- Bento Grid Layout -->
            <div class="bento-grid">
                @forelse($this->galleryItems as $index => $item)
                    @php
                        // Create Bento pattern - varying sizes for visual interest
                        $sizes = [
                            'col-span-1 row-span-1', // small
                            'col-span-2 row-span-1', // wide
                            'col-span-1 row-span-2', // tall
                            'col-span-2 row-span-2', // large
                        ];
                        $sizeClass = $sizes[$index % 4];
                        
                        // Adjust height based on size
                        $heightClass = match($sizeClass) {
                            'col-span-1 row-span-1' => 'h-64',   // small
                            'col-span-2 row-span-1' => 'h-64',   // wide
                            'col-span-1 row-span-2' => 'h-96',   // tall
                            'col-span-2 row-span-2' => 'h-96',   // large
                            default => 'h-64'
                        };
                    @endphp
                    
                    <div class="bento-item {{ $sizeClass }} group cursor-pointer" 
                         onclick="openLightbox('{{ $item->getFirstMediaUrl('images') }}', '{{ $item->title }}', '{{ $item->description }}')">
                        <div class="relative {{ $heightClass }} w-full bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-amber-100 group-hover:border-amber-300">
                            @if($item->getFirstMediaUrl('images'))
                                <img src="{{ $item->getFirstMediaUrl('images') }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                                     alt="{{ $item->title }}">
                                
                                <!-- Overlay with gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                
                                <!-- Content overlay -->
                                <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                    <h3 class="text-xl font-bold mb-2 drop-shadow-lg">{{ $item->title }}</h3>
                                    @if($item->description)
                                        <p class="text-sm opacity-90 drop-shadow-md">{{ Str::limit($item->description, 80) }}</p>
                                    @endif
                                </div>
                                
                                <!-- Zoom icon -->
                                <div class="absolute top-4 right-4 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <i class="fas fa-search-plus text-white text-sm"></i>
                                </div>
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-amber-100 to-orange-200 flex items-center justify-center">
                                    <div class="text-center">
                                        <i class="fas fa-image text-6xl text-amber-400 mb-4"></i>
                                        <h3 class="text-xl font-semibold text-gray-700">{{ $item->title }}</h3>
                                        @if($item->description)
                                            <p class="text-gray-600 mt-2">{{ Str::limit($item->description, 60) }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3">
                        <div class="text-center py-20">
                            <div class="mb-8">
                                <i class="fas fa-images text-8xl text-gray-300"></i>
                            </div>
                            <h3 class="text-3xl font-semibold text-gray-700 mb-4">{{ __('Gallery Coming Soon') }}</h3>
                            <p class="text-gray-500 mb-8 max-w-2xl mx-auto text-lg leading-relaxed">
                                {{ __('Our photo gallery is being prepared. Check back soon for beautiful images of performances, instruments, and musical moments.') }}
                            </p>
                            <a href="{{ route('welcome') }}" 
                               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-medium text-lg rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all duration-200 transform hover:scale-105">
                                <i class="fas fa-home mr-3"></i>
                                {{ __('Return Home') }}
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
            
            @if($this->galleryItems->count() > 0)
                <div class="flex justify-center mt-12">
                    {{ $this->galleryItems->links() }}
                </div>
            @endif
        </div>
    </section>
    
    <!-- Lightbox Modal -->
    <div id="lightbox" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeLightbox()" 
                    class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-colors">
                <i class="fas fa-times"></i>
            </button>
            
            <img id="lightbox-image" 
                 class="max-w-full max-h-[80vh] object-contain rounded-lg" 
                 alt="">
            
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 rounded-b-lg">
                <h3 id="lightbox-title" class="text-2xl font-bold text-white mb-2"></h3>
                <p id="lightbox-description" class="text-gray-200"></p>
            </div>
        </div>
    </div>
    
    <style>
    /* Bento Grid Styles */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        grid-auto-rows: 250px;
    }

    @media (min-width: 768px) {
        .bento-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (min-width: 1024px) {
        .bento-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .bento-item {
        transition: all 0.3s ease;
    }

    .bento-item:hover {
        transform: translateY(-4px);
    }

    /* Responsive adjustments for grid spans */
    @media (max-width: 767px) {
        .bento-item {
            grid-column: span 1 !important;
            grid-row: span 1 !important;
        }
    }

    /* Smooth animations */
    .bento-item img {
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .bento-item:hover img {
        transform: scale(1.05);
    }

    /* Lightbox styles */
    #lightbox {
        backdrop-filter: blur(4px);
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    #lightbox img {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
    </style>

    <script>
    function openLightbox(imageSrc, title, description) {
        const lightbox = document.getElementById('lightbox');
        const image = document.getElementById('lightbox-image');
        const titleEl = document.getElementById('lightbox-title');
        const descEl = document.getElementById('lightbox-description');
        
        if (imageSrc) {
            image.src = imageSrc;
            image.alt = title;
            titleEl.textContent = title;
            descEl.textContent = description || '';
            
            lightbox.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close lightbox on escape key or background click
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });

    document.getElementById('lightbox').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLightbox();
        }
    });
    </script>
</div>
