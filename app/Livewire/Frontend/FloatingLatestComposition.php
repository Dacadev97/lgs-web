<?php


namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Composition;

class FloatingLatestComposition extends Component
{
    public $latestComposition;
    public $visible = true;

    public function mount()
    {
        $this->latestComposition = Composition::latest()->first();
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
