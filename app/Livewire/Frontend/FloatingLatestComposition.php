<?php


namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Composition;
use Illuminate\Support\Facades\Log;

class FloatingLatestComposition extends Component
{
    public $latestComposition;
    public $visible = true;

    public function mount()
    {
        $this->latestComposition = Composition::latest()->first();
        Log::info('Composition loaded:', ['composition' => $this->latestComposition]); // Debug
    }

    public function close()
    {
        $this->visible = false;
    }

    public function render()
    {
        return view('livewire.frontend.floating-latest-composition');
    }
}
