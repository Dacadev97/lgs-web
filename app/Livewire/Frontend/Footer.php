<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\SocialLink;

class Footer extends Component
{
    public function render()
    {
        $categories = [
            'Guitar',
            'Andean Colombian Trio',
            'Andean Colombian Quartet',
            'Other Formats',
        ];

        $socialLinks = collect([
            ['url' => 'https://www.facebook.com/jaimeromerousa', 'icon' => 'facebook'],

        ]);

        return view('livewire.frontend.footer', [
            'categories' => $categories,
            'socialLinks' => $socialLinks,
        ]);
    }
}
