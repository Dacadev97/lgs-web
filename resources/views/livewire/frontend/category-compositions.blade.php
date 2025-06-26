<div>
    <div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-100">
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="lg:w-1/4">
                        <!-- Categories Sidebar -->
                        <div class="bg-white rounded-xl shadow-lg border border-amber-200">
                            <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-4 rounded-t-xl">
                                <h5 class="text-white font-semibold text-lg flex items-center">
                                    <i class="fas fa-list mr-2"></i>
                                    {{ __('Categories') }}
                                </h5>
                            </div>
                            <div class="p-0">
                                <div class="divide-y divide-amber-100">
                                    <a href="{{ route('compositions.byCategory') }}" 
                                       class="block px-4 py-3 text-sm hover:bg-amber-50 transition-colors duration-200 {{ !$selectedCategory ? 'bg-amber-100 text-amber-800 font-medium border-r-4 border-amber-500' : 'text-gray-700' }}">
                                        {{ __('All Categories') }}
                                    </a>
                                    @foreach($this->categories as $category)
                                        <a href="{{ route('compositions.byCategory', ['category' => $category->name]) }}" 
                                           class="block px-4 py-3 text-sm hover:bg-amber-50 transition-colors duration-200 {{ $selectedCategory == $category->id ? 'bg-amber-100 text-amber-800 font-medium border-r-4 border-amber-500' : 'text-gray-700' }}">
                                            <div class="flex justify-between items-center">
                                                <span>{{ $category->name }}</span>
                                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">({{ $category->compositions_count }})</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:w-3/4">
                        <!-- Invalid Category Alert -->
                        @if($invalidCategory)
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-yellow-400 mr-3"></i>
                                    <div class="flex-1">
                                        <p class="text-yellow-800 text-sm font-medium">
                                            {{ __('The requested category was not found. Showing all compositions instead.') }}
                                        </p>
                                    </div>
                                    <button wire:click="$set('invalidCategory', false)" class="text-yellow-400 hover:text-yellow-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Page Header -->
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 space-y-4 sm:space-y-0">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">
                                    @if($selectedCategory && $this->selectedCategoryModel)
                                        {{ $this->selectedCategoryModel->name }}
                                    @else
                                        {{ __('All Compositions') }}
                                    @endif
                                </h1>
                                <p class="text-gray-600 mt-1">
                                    {{ $this->compositions->total() }} {{ __('compositions found') }}
                                </p>
                            </div>
                            
                            <!-- Search -->
                            <div class="flex flex-col sm:flex-row gap-3">
                                <input type="text" wire:model.live="search" 
                                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200" 
                                       placeholder="{{ __('Search compositions...') }}">
                                <select wire:model.live="sortBy" 
                                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200">
                                    <option value="title">{{ __('Title') }}</option>
                                    <option value="created_at">{{ __('Date Added') }}</option>
                                    <option value="downloads">{{ __('Downloads') }}</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Compositions Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse($this->compositions as $composition)
                                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-amber-100">
                                    <div class="flex h-full">
                                        <div class="w-32 flex-shrink-0">
                                            @if($composition->getFirstMediaUrl('thumbnail'))
                                                <img src="{{ $composition->getFirstMediaUrl('thumbnail') }}" 
                                                     class="w-full h-full object-cover rounded-l-xl" 
                                                     alt="{{ $composition->title }}">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-amber-100 to-orange-200 rounded-l-xl flex items-center justify-center">
                                                    <i class="fas fa-music text-4xl text-amber-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 p-4 flex flex-col">
                                            <h6 class="font-semibold text-gray-900 mb-2 text-lg">{{ $composition->title }}</h6>
                                            @if($composition->category)
                                                <span class="inline-block bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full mb-2 self-start">
                                                    {{ $composition->category->name }}
                                                </span>
                                            @endif

                                            <!-- Controles de audio si tiene MP3 -->
                                            @if($composition->hasAudio())
                                                <div class="mb-3">
                                                    <audio controls class="w-full h-8 rounded-lg">
                                                        <source src="{{ route('serve.audio', $composition->id) }}" type="audio/mpeg">
                                                        Su navegador no soporta audio HTML5.
                                                    </audio>
                                                </div>
                                            @endif
                                            
                                            <div class="flex justify-between items-center mt-auto">
                                                <div class="flex items-center gap-3">
                                                    {{-- Downloads counter --}}
                                                    <div class="flex items-center text-gray-500 text-sm">
                                                        <i class="fas fa-download mr-1"></i> 
                                                        <span>{{ $composition->downloads ?? 0 }}</span>
                                                    </div>

                                                    {{-- Share button --}}
                                                    <div x-data="{ 
                                                        showTooltip: false,
                                                        compositionTitle: '{{ $composition->title }}',
                                                        copyLink() {
                                                            const baseUrl = 'https://www.latinguitarscores.com/compositions';
                                                            const searchParam = encodeURIComponent(this.compositionTitle);
                                                            const url = `${baseUrl}?search=${searchParam}`;
                                                            navigator.clipboard.writeText(url);
                                                            this.showTooltip = true;
                                                            setTimeout(() => this.showTooltip = false, 2000);
                                                        }
                                                    }" 
                                                    class="relative">
                                                        <button 
                                                            @click="copyLink()"
                                                            class="inline-flex items-center p-1.5 text-gray-500 hover:text-amber-600 transition-colors rounded-full hover:bg-amber-50"
                                                            title="{{ __('Share') }}"
                                                        >
                                                            <i class="fas fa-share-alt"></i>
                                                        </button>
                                                        
                                                        {{-- Tooltip --}}
                                                        <div 
                                                            x-show="showTooltip"
                                                            x-transition:enter="transition ease-out duration-200"
                                                            x-transition:enter-start="opacity-0 translate-y-1"
                                                            x-transition:enter-end="opacity-100 translate-y-0"
                                                            x-transition:leave="transition ease-in duration-150"
                                                            x-transition:leave-start="opacity-100 translate-y-0"
                                                            x-transition:leave-end="opacity-0 translate-y-1"
                                                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap"
                                                            style="display: none;"
                                                        >
                                                            {{ __('Link copied!') }}
                                                        </div>
                                                    

                                                <div class="flex gap-2">
                                                    @if($composition->hasPdf())
                                                        <a href="{{ route('preview.pdf', $composition->id) }}" 
                                                           target="_blank"
                                                           class="inline-flex items-center px-3 py-2 bg-amber-100 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-200 transition-all duration-200"
                                                           title="{{ __('Preview PDF') }}">
                                                            <i class="fas fa-eye mr-1"></i>
                                                            <span class="hidden sm:inline">{{ __('Preview') }}</span>
                                                        </a>
                                                    @endif
                                                    
                                                    @if($composition->hasFiles())
                                                        <a href="{{ route('download.package', $composition->id) }}" 
                                                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-medium rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all duration-200">
                                                            <i class="fas fa-download mr-2"></i>
                                                            {{ __('Download') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2">
                                    <div class="text-center py-16">
                                        <div class="mb-8">
                                            <i class="fas fa-music text-6xl text-gray-300"></i>
                                        </div>
                                        <h4 class="text-2xl font-semibold text-gray-700 mb-4">{{ __('No compositions found') }}</h4>
                                        <p class="text-gray-500 mb-6 max-w-md mx-auto">
                                            @if($search)
                                                {{ __('No compositions match your search criteria.') }}
                                            @else
                                                {{ __('No compositions available in this category.') }}
                                            @endif
                                        </p>
                                        @if($search)
                                            <button wire:click="$set('search', '')" 
                                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-medium rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all duration-200">
                                                <i class="fas fa-eraser mr-2"></i>
                                                {{ __('Clear Search') }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        
                        <!-- Pagination -->
                        @if($this->compositions->hasPages())
                            <div class="mt-12 flex justify-center">
                                {{ $this->compositions->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>