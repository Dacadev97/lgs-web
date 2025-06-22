<div>
    @if($categories->count())
    <section class="py-16 bg-[#fef5ee]">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-12 text-center">
                Explore by Category
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    @php
                        $count = $category->compositions()->count();
                        $icon = match(strtolower($category->name)) {
                            'guitar' => 'guitar',
                            'andean colombian trio' => 'trio',
                            'andean colombian quartet' => 'quartet',
                            'symphonic orchestra' => 'orchestra',
                            'other formats' => 'other',
                            default => 'other',
                        };
                        $displayName = $category->name;
                    @endphp
                    <div class="bg-white border border-amber-100 rounded-xl shadow p-8 flex flex-col items-center text-center hover:shadow-lg transition">
                        <div class="mb-4">
                            @if($icon === 'guitar')
                                {{-- Ícono guitarra --}}
                                <svg class="w-12 h-12 text-amber-500 mx-auto" viewBox="0 0 491.048 491.048" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M484.359,77l-71-71c-8-8-21-8-29,0s-8,21,0,29l21,21l-13.9,13.9l-21-21c-8-8-21-8-29,0s-8,21,0,29l21,21l-66.6,66.6
                                        c-65.7-51.4-136.4-22.4-162,3.2c-6.4,6.4-12,13.6-16.5,21.4c-30.4,3.2-58.1,16.1-78.9,37c-39.5,39.5-65.4,133.7,12.9,212
                                        c34.1,41.6,138.9,86,212,12.9c20.9-20.9,33.7-48.5,37-78.9c7.8-4.6,15-10.1,21.4-16.5c28.3-28.3,55.8-96.1,3.2-162.1l66.6-66.6
                                        l21,21c8,8,21,8,29,0s8-21,0-29l-21-21l13.9-13.9l21,21c8,8,21,8,29,0C492.459,98,492.459,85,484.359,77z M292.659,327.6
                                        c-5.8,5.8-12.7,10.5-20.3,13.8c-7.4,3.2-12.2,10.4-12.3,18.4c-0.5,25-9.4,46.9-25.7,63.2c-38.9,38.9-108,33.1-154-12.9
                                        s-51.8-115.1-12.9-154c16.4-16.4,38.3-25.3,63.2-25.7c8-0.1,15.2-5,18.4-12.3c3.3-7.6,8-14.5,13.8-20.3c26-26,69.8-26,104.3-2.1
                                        l-98.3,98.3c-8.3,8.3-8.6,21.1,0,29.1c11.9,11.1,23.5,5.4,29.1,0l98-98C318.559,259.2,318.259,301.9,292.659,327.6z"/>
                                </svg>
                            @elseif($icon === 'trio')
                                {{-- Ícono trío (tres notas musicales) --}}
                                <span class="flex items-center justify-center gap-1">
                                    @for($i = 0; $i < 3; $i++)
                                        <svg class="w-7 h-7 text-amber-500" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M13.75 2C13.75 1.58579 13.4142 1.25 13 1.25C12.5858 1.25 12.25 1.58579 12.25 2V14.5359C11.4003 13.7384 10.2572 13.25 9 13.25C6.37665 13.25 4.25 15.3766 4.25 18C4.25 20.6234 6.37665 22.75 9 22.75C11.6234 22.75 13.75 20.6234 13.75 18V6.243C14.9875 7.77225 16.8795 8.75 19 8.75C19.4142 8.75 19.75 8.41421 19.75 8C19.75 7.58579 19.4142 7.25 19 7.25C16.1005 7.25 13.75 4.8995 13.75 2Z"/>
                                        </svg>
                                    @endfor
                                </span>
                            @elseif($icon === 'quartet')
                                {{-- Ícono cuarteto (cuatro notas musicales) --}}
                                <span class="flex items-center justify-center gap-1">
                                    @for($i = 0; $i < 4; $i++)
                                        <svg class="w-7 h-7 text-amber-500" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M13.75 2C13.75 1.58579 13.4142 1.25 13 1.25C12.5858 1.25 12.25 1.58579 12.25 2V14.5359C11.4003 13.7384 10.2572 13.25 9 13.25C6.37665 13.25 4.25 15.3766 4.25 18C4.25 20.6234 6.37665 22.75 9 22.75C11.6234 22.75 13.75 20.6234 13.75 18V6.243C14.9875 7.77225 16.8795 8.75 19 8.75C19.4142 8.75 19.75 8.41421 19.75 8C19.75 7.58579 19.4142 7.25 19 7.25C16.1005 7.25 13.75 4.8995 13.75 2Z"/>
                                        </svg>
                                    @endfor
                                </span>
                            @elseif($icon === 'orchestra')
                                {{-- Ícono orquesta sinfónica --}}
                                <svg class="w-12 h-12 text-amber-500 mx-auto" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 1L14.5 6H19L15.5 9.5L17 15L12 12L7 15L8.5 9.5L5 6H9.5L12 1Z"/>
                                </svg>
                            @elseif($icon === 'other')
                                {{-- Ícono otros formatos --}}
                                <svg class="w-12 h-12 text-amber-500 mx-auto" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 19.5C12 20.8807 10.8807 22 9.5 22C8.11929 22 7 20.8807 7 19.5C7 18.1193 8.11929 17 9.5 17C10.8807 17 12 18.1193 12 19.5Z" stroke="currentColor" stroke-width="1.5"></path>
                                    <path d="M22 17.5C22 18.8807 20.8807 20 19.5 20C18.1193 20 17 18.8807 17 17.5C17 16.1193 18.1193 15 19.5 15C20.8807 15 22 16.1193 22 17.5Z" stroke="currentColor" stroke-width="1.5"></path>
                                    <path d="M22 8L12 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path d="M14.4556 5.15803L14.7452 5.84987L14.4556 5.15803ZM16.4556 4.32094L16.1661 3.62909L16.4556 4.32094ZM21.1081 3.34059L20.6925 3.96496L20.6925 3.96496L21.1081 3.34059ZM21.25 12.0004C21.25 12.4146 21.5858 12.7504 22 12.7504C22.4142 12.7504 22.75 12.4146 22.75 12.0004H21.25ZM12.75 19.0004V8.84787H11.25V19.0004H12.75ZM14.7452 5.84987L16.7452 5.01278L16.1661 3.62909L14.1661 4.46618L14.7452 5.84987ZM22.75 8.01078C22.75 6.67666 22.752 5.59091 22.6304 4.76937C22.5067 3.93328 22.2308 3.18689 21.5236 2.71622L20.6925 3.96496C20.8772 4.08787 21.0473 4.31771 21.1466 4.98889C21.248 5.67462 21.25 6.62717 21.25 8.01078H22.75ZM16.7452 5.01278C18.0215 4.47858 18.901 4.11263 19.5727 3.94145C20.2302 3.77391 20.5079 3.84204 20.6925 3.96496L21.5236 2.71622C20.8164 2.24554 20.0213 2.2792 19.2023 2.48791C18.3975 2.69298 17.3967 3.114 16.1661 3.62909L16.7452 5.01278ZM12.75 8.84787C12.75 8.18634 12.751 7.74991 12.7875 7.41416C12.822 7.09662 12.8823 6.94006 12.9594 6.8243L11.7106 5.99325C11.4527 6.38089 11.3455 6.79864 11.2963 7.25218C11.249 7.68752 11.25 8.21893 11.25 8.84787H12.75ZM14.1661 4.46618C13.5859 4.70901 13.0953 4.91324 12.712 5.12494C12.3126 5.34549 11.9686 5.60562 11.7106 5.99325L12.9594 6.8243C13.0364 6.70855 13.1575 6.59242 13.4371 6.438C13.7328 6.27473 14.135 6.10528 14.7452 5.84987L14.1661 4.46618ZM22.75 12.0004V8.01078H21.25V12.0004H22.75Z" fill="currentColor"></path>
                                    <path d="M7 11V6.5V2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <circle cx="4.5" cy="10.5" r="2.5" stroke="currentColor" stroke-width="1.5"></circle>
                                    <path d="M10 5C8.75736 5 7 4.07107 7 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="font-semibold text-lg text-gray-900 mb-1">{{ $displayName }}</div>
                        <div class="text-gray-500 text-sm mb-4">{{ $count }}+ pieces</div>
                        <a href="{{ url('/compositions?category=' . urlencode($category->id)) }}"
                           class="text-amber-600 font-semibold text-sm hover:underline flex items-center gap-1">
                            Browse <span class="text-lg">&#8594;</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
