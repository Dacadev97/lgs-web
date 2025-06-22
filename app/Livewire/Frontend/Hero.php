<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Hero as HeroModel;

class Hero extends Component
{
    public $image;
    public $text;

    public function mount()
    {
        $hero = HeroModel::first();
        if ($hero) {
            $this->image = $hero->image;
            $this->text = $hero->text;
        }
    }

    public function render()
    {
        return view('livewire.frontend.hero');
    }
}
