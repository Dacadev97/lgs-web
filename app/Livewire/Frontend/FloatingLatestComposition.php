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
            // Buscar la composición más reciente por fecha de creación
            $this->latestComposition = Composition::orderBy('created_at', 'desc')
                ->orderBy('id', 'desc') // Ordenar por ID como desempate
                ->first();

            // Solo mostrar si encontramos una composición
            $this->visible = $this->latestComposition !== null;

            Log::info('FloatingLatestComposition montado:', [
                'composition_id' => $this->latestComposition?->id,
                'title' => $this->latestComposition?->title,
                'created_at' => $this->latestComposition?->created_at,
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
