<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Category;

class Categories extends Component
{
    public $categories;

    public function mount()
    {
        $this->categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.categories');
    }
}
