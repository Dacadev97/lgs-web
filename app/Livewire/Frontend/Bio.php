<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\BioSettings;

class Bio extends Component
{
    public $settings;

    public function mount()
    {
        // Obtener la configuración de la biografía
        $this->settings = BioSettings::first() ?? BioSettings::create([
            'title' => 'About the Artist',
            'subtitle' => 'Discover the story behind the music',
            'artist_name' => 'Jaime Romero',
            'artist_role' => 'Classical and Latin Guitar Virtuoso',
            'description_1' => 'With over two decades of experience...',
            'description_2' => 'Their performances have graced...',
            'years_experience' => '20+',
            'compositions_count' => '100+',
            'performances_count' => '50+',
            'philosophy_title' => 'Musical Philosophy',
            'philosophy_quote' => 'Music is the universal language...',
            'cta_title' => 'Explore the Musical Journey'
        ]);
    }

    public function render()
    {
        return view('livewire.frontend.bio');
    }
}
