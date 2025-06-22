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
            ['url' => '#', 'icon' => 'facebook'],
            ['url' => '#', 'icon' => 'instagram'],
            ['url' => '#', 'icon' => 'twitter'],
            ['url' => '#', 'icon' => 'youtube'],
        ]);

        return view('livewire.frontend.footer', [
            'categories' => $categories,
            'socialLinks' => $socialLinks,
        ]);
    }
}
