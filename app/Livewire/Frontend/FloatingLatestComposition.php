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
            $this->latestComposition = Composition::latest()->first();
            $this->visible = true;

            Log::info('FloatingLatestComposition montado:', [
                'composition_id' => $this->latestComposition?->id,
                'title' => $this->latestComposition?->title,
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
