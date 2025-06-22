<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\SocialLink;

class Navbar extends Component
{
    public function render()
    {


        $socialLinks = SocialLink::all()->map(function ($link) {
            return [
                'url' => $link->url,
                'icon' => $link->platform,
            ];
        });

        return view('livewire.frontend.navbar', [
            'socialLinks' => $socialLinks,
        ]);
    }
}
