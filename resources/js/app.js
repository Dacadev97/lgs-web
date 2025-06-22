import './bootstrap';

// Configuración global para reproductores de audio
document.addEventListener('DOMContentLoaded', function() {
    // Pausar otros audios cuando uno empiece a reproducir
    const audioElements = document.querySelectorAll('audio');
    
    audioElements.forEach(audio => {
        audio.addEventListener('play', function() {
            audioElements.forEach(otherAudio => {
                if (otherAudio !== audio) {
                    otherAudio.pause();
                }
            });
        });
        
        // Mejorar styling del control
        audio.setAttribute('controlsList', 'nodownload');
        audio.setAttribute('preload', 'metadata');
    });
    
    // Re-ejecutar cuando Livewire actualice el DOM
    document.addEventListener('livewire:navigated', function() {
        const newAudioElements = document.querySelectorAll('audio');
        newAudioElements.forEach(audio => {
            if (!audio.hasAttribute('data-audio-setup')) {
                audio.setAttribute('data-audio-setup', 'true');
                audio.addEventListener('play', function() {
                    document.querySelectorAll('audio').forEach(otherAudio => {
                        if (otherAudio !== audio) {
                            otherAudio.pause();
                        }
                    });
                });
                audio.setAttribute('controlsList', 'nodownload');
                audio.setAttribute('preload', 'metadata');
            }
        });
    });
});
