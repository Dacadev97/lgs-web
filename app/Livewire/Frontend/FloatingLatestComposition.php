<?php


namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Composition;
use App\Models\FloatingComposition;

class FloatingLatestComposition extends Component
{
    public $latestComposition;
    public $show = false;

    public function mount()
    {
        $settings = FloatingComposition::first();
        if ($settings && $settings->is_active) {
            $this->latestComposition = Composition::latest()->first();
            $this->show = true;
        }
    }

    public function render()
    {
        return view('livewire.frontend.floating-latest-composition');
    }
}
