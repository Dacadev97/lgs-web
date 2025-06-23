<div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-100">
    <!-- Hero Section -->
    <section class="pt-20 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">{{ __('About the Artist') }}</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">{{ __('Discover the story behind the music') }}</p>
            </div>
            
            <!-- Artist Profile Card -->
            <div class="bg-white rounded-3xl shadow-2xl border border-amber-100 overflow-hidden max-w-5xl mx-auto">
                <div class="p-8 lg:p-12">
                    <div class="grid lg:grid-cols-5 gap-8 lg:gap-12 items-center">
                        <!-- Artist Photo -->
                        <div class="lg:col-span-2 text-center">
                            <div class="relative inline-block">
                                <img src="{{ asset('images/photo-bio.jpg') }}" 
                                     alt="Artist Photo" 
                                     class="w-80 h-80 lg:w-full lg:h-auto object-cover rounded-2xl shadow-2xl border-4 border-amber-200">
                                <div class="absolute -bottom-4 -right-4 w-16 h-16 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-guitar text-white text-2xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Artist Info -->
                        <div class="lg:col-span-3 space-y-6">
                            <div>
                                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">{{ __('Jaime Romero') }}</h2>
                                <p class="text-xl text-amber-600 font-semibold mb-6">
                                    {{ __('Classical and Latin Guitar Virtuoso') }}
                                </p>
                            </div>
                            
                            <div class="space-y-4 text-gray-700 leading-relaxed">
                                <p class="text-lg">
                                    {{ __('With over two decades of experience in classical and Latin guitar, our featured artist has dedicated their life to preserving and sharing the rich musical heritage of Latin America. Through careful study and interpretation of traditional compositions, as well as the creation of contemporary works, they continue to expand the repertoire of Latin guitar music.') }}
                                </p>
                                
                                <p class="text-lg">
                                    {{ __('Their performances have graced concert halls across the Americas and Europe, bringing the passionate and intricate melodies of Latin guitar to audiences worldwide. Each composition in this collection has been carefully selected and arranged to showcase the diverse styles and emotions that define Latin guitar music.') }}
                                </p>
                            </div>
                            
                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-6 pt-6">
                                <div class="text-center">
                                    <div class="text-3xl lg:text-4xl font-bold text-amber-600 mb-2">20+</div>
                                    <div class="text-sm lg:text-base text-gray-600 font-medium">{{ __('Years Experience') }}</div>
                                </div>
                                <div class="text-center border-x border-gray-200">
                                    <div class="text-3xl lg:text-4xl font-bold text-amber-600 mb-2">100+</div>
                                    <div class="text-sm lg:text-base text-gray-600 font-medium">{{ __('Compositions') }}</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl lg:text-4xl font-bold text-amber-600 mb-2">50+</div>
                                    <div class="text-sm lg:text-base text-gray-600 font-medium">{{ __('Performances') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Musical Philosophy Section -->
    <section class="py-16 bg-white/50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-12">{{ __('Musical Philosophy') }}</h3>
            
            <div class="bg-white rounded-2xl shadow-xl border border-amber-100 p-8 lg:p-12 relative">
                <!-- Quote marks -->
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <div class="w-8 h-8 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-quote-left text-white text-sm"></i>
                    </div>
                </div>
                
                <blockquote class="text-xl lg:text-2xl text-gray-700 italic leading-relaxed mb-8">
                    {{ __('Music is the universal language that transcends borders and cultures. Through the guitar, we can tell stories of love, passion, joy, and sorrow that resonate with the human soul regardless of where we come from.') }}
                </blockquote>
                
                <footer class="border-t border-gray-200 pt-6">
                    <cite class="text-lg font-semibold text-amber-600">{{ __('Jaime Romero') }}</cite>
                </footer>
            </div>
        </div>
    </section>
    
    <!-- Call to Action Section -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-8">{{ __('Explore the Musical Journey') }}</h3>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('compositions.byCategory') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold text-lg rounded-xl hover:from-amber-600 hover:to-orange-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <i class="fas fa-music mr-3"></i>
                    {{ __('Explore Compositions') }}
                </a>
                
                <a href="{{ route('gallery') }}" 
                   class="inline-flex items-center px-8 py-4 bg-white text-amber-600 font-semibold text-lg rounded-xl border-2 border-amber-300 hover:bg-amber-50 hover:border-amber-400 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <i class="fas fa-images mr-3"></i>
                    {{ __('View Gallery') }}
                </a>
            </div>
        </div>
    </section>
    
    <!-- Decorative Elements -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-amber-200/30 rounded-full blur-xl"></div>
    <div class="absolute top-40 right-10 w-32 h-32 bg-orange-200/30 rounded-full blur-xl"></div>
    <div class="absolute bottom-20 left-1/4 w-16 h-16 bg-amber-300/20 rounded-full blur-xl"></div>
</div>
