<div>
@if($compositions->count())
<section class="py-12 bg-[#fffaf6]">
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8 text-center">
            Featured Compositions
        </h2>
        <div 
            x-data="{
                compositions: @js($compositions),
                current: 0,
                audio: null,
                playing: false,
                duration: 0,
                currentTime: 0,
                seeking: false,
                init() {
                    this.$nextTick(() => {
                        this.audio = this.$refs.audio;
                        this.audio.addEventListener('loadedmetadata', () => {
                            this.duration = this.audio.duration;
                        });
                        this.audio.addEventListener('timeupdate', () => {
                            if (!this.seeking) {
                                this.currentTime = this.audio.currentTime;
                            }
                        });
                        this.audio.addEventListener('ended', () => {
                            this.playing = false;
                        });
                    });
                },
                play() {
                    this.audio.play();
                    this.playing = true;
                },
                pause() {
                    this.audio.pause();
                    this.playing = false;
                },
                seek(e) {
                    let clientX;
                    if (e.type.startsWith('touch')) {
                        clientX = e.touches[0].clientX;
                    } else {
                        clientX = e.clientX;
                    }
                    const rect = e.currentTarget.getBoundingClientRect();
                    const percent = Math.min(Math.max((clientX - rect.left) / rect.width, 0), 1);
                    this.audio.currentTime = percent * this.duration;
                    this.currentTime = this.audio.currentTime;
                },
                startSeek(e) {
                    this.seeking = true;
                    this.seek(e);
                },
                moveSeek(e) {
                    if (this.seeking) {
                        this.seek(e);
                    }
                },
                stopSeek(e) {
                    if (this.seeking) {
                        this.seek(e);
                        this.seeking = false;
                    }
                },
                select(idx) {
                    this.current = idx;
                    this.$nextTick(() => {
                        this.audio.load();
                        this.play();
                    });
                },
                prev() {
                    if (this.current > 0) {
                        this.select(this.current - 1);
                    }
                },
                next() {
                    if (this.current < this.compositions.length - 1) {
                        this.select(this.current + 1);
                    }
                }
            }"
            x-init="init"
            class="flex flex-col md:flex-row gap-8"
        >
            {{-- Reproductor principal --}}
            <div class="flex-1 bg-white/90 border border-amber-100 rounded-xl shadow p-4 sm:p-8 flex flex-col items-center min-w-[0]">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2 text-center" x-text="compositions[current].title"></h3>
                <template x-if="compositions[current].genre">
                    <span class="mb-4 px-3 py-1 rounded-full border border-amber-200 bg-amber-50 text-amber-700 text-xs font-semibold shadow-sm" x-text="compositions[current].genre"></span>
                </template>
                <div class="flex items-center justify-center gap-4 sm:gap-6 my-6">
                    {{-- Prev --}}
                    <button 
                        @click="prev" 
                        :disabled="current === 0" 
                        class="text-amber-600 hover:text-amber-700 text-xl sm:text-2xl disabled:opacity-30 bg-transparent rounded-full p-2 transition flex items-center justify-center"
                        aria-label="Anterior"
                    >
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polygon points="11 19 2 12 11 5 11 19" fill="currentColor" />
                            <rect x="13" y="5" width="3" height="14" rx="1" fill="currentColor" />
                        </svg>
                    </button>
                    {{-- Play/Pause --}}
                    <button 
                        @click="playing ? pause() : play()" 
                        class="bg-amber-600 hover:bg-amber-700 text-white rounded-full w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center text-2xl sm:text-3xl shadow transition"
                        aria-label="Play/Pause"
                    >
                        <template x-if="!playing">
                            <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="white" viewBox="0 0 24 24">
                                <polygon points="6,4 20,12 6,20" />
                            </svg>
                        </template>
                        <template x-if="playing">
                            <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="white" viewBox="0 0 24 24">
                                <rect x="6" y="4" width="4" height="16" rx="1"/>
                                <rect x="14" y="4" width="4" height="16" rx="1"/>
                            </svg>
                        </template>
                    </button>
                    {{-- Next --}}
                    <button 
                        @click="next" 
                        :disabled="current === compositions.length - 1" 
                        class="text-amber-600 hover:text-amber-700 text-xl sm:text-2xl disabled:opacity-30 bg-transparent rounded-full p-2 transition flex items-center justify-center"
                        aria-label="Siguiente"
                    >
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polygon points="13 5 22 12 13 19 13 5" fill="currentColor" />
                            <rect x="8" y="5" width="3" height="14" rx="1" fill="currentColor" />
                        </svg>
                    </button>
                </div>
                {{-- Barra de progreso --}}
                <div class="w-full flex items-center gap-2 mb-2 select-none">
                    <span class="text-xs text-gray-500" x-text="new Date(currentTime * 1000).toISOString().substr(14, 5)"></span>
                    <div 
                        class="flex-1 h-2 bg-gray-200 rounded cursor-pointer relative"
                        @mousedown="startSeek($event)"
                        @mousemove.window="moveSeek($event)"
                        @mouseup.window="stopSeek($event)"
                        @mouseleave.window="seeking = false"
                        @touchstart="startSeek($event)"
                        @touchmove="moveSeek($event)"
                        @touchend="stopSeek($event)"
                    >
                        <div class="h-2 bg-amber-500 rounded" :style="'width:' + (duration ? (currentTime/duration)*100 : 0) + '%'"></div>
                    </div>
                    <span class="text-xs text-gray-500" x-text="duration ? new Date(duration * 1000).toISOString().substr(14, 5) : '0:00'"></span>
                </div>
                {{-- Audio oculto --}}
                <audio x-ref="audio" class="hidden" :src="'/storage/' + compositions[current].mp3" preload="metadata"></audio>
            </div>
            {{-- Lista de composiciones comprimida con scroll interno --}}
            <div class="w-full md:w-64 flex-shrink-0">
                <div style="height:220px; max-height:220px;">
                    <ul class="h-full overflow-y-auto" style="padding:0; margin:0;">
                        <template x-for="(comp, idx) in compositions" :key="comp.id">
                            <li style="height:44px; padding:0; margin:0;" :class="{'border-b border-amber-100': idx !== compositions.length - 1}">
                                <button
                                    @click="select(idx); play()"
                                    :class="{
                                        'bg-amber-100 border-amber-400 text-amber-900': idx === current,
                                        'bg-white border-transparent text-gray-700 hover:bg-amber-50': idx !== current
                                    }"
                                    class="w-full text-left px-4 rounded transition font-medium h-full flex items-center border-0"
                                    style="height:44px; min-height:44px; max-height:44px; padding-top:0; padding-bottom:0;"
                                >
                                    <span x-text="comp.title"></span>
                                    <span class="ml-2 text-xs text-amber-700" x-text="comp.genre"></span>
                                </button>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
</div>