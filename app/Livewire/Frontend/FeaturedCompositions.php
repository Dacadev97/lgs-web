<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\FeaturedCompositions as FeaturedCompositionsModel;

class FeaturedCompositions extends Component
{
    public $compositions;

    public function mount()
    {
        $compositions = FeaturedCompositionsModel::orderBy('order')->get();

        $this->compositions = $compositions->unique('id');
    }

    public function render()
    {
        return view('livewire.frontend.featured-compositions');
    }
}
