<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Composition;
use App\Models\FloatingComposition;
use Illuminate\Support\Facades\Log;

class FloatingLatestComposition extends Component
{
    public $latestComposition;
    public $visible = true;

    public function mount()
    {
        $settings = FloatingComposition::first();

        if ($settings && $settings->is_active) {
            // Buscar la composición más reciente con relaciones necesarias
            $this->latestComposition = Composition::with(['category', 'media'])
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            // Solo mostrar si encontramos una composición
            $this->visible = $this->latestComposition !== null;

            Log::info('FloatingLatestComposition montado:', [
                'composition_id' => $this->latestComposition?->id,
                'title' => $this->latestComposition?->title,
                'has_audio' => $this->latestComposition ? $this->latestComposition->hasAudio() : false,
                'audio_url' => $this->latestComposition ? $this->latestComposition->getAudioUrl() : null,
                'visible' => $this->visible,
                'settings_active' => $settings->is_active
            ]);
        } else {
            $this->visible = false;
        }
    }

    public function close()
    {
        $this->visible = false;
    }

    public function render()
    {
        Log::info('FloatingLatestComposition renderizando', [
            'visible' => $this->visible,
            'has_composition' => isset($this->latestComposition)
        ]);

        return view('livewire.frontend.floating-latest-composition');
    }
}
