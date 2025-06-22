<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Gallery as GalleryModel;

class Gallery extends Component
{
    use WithPagination;

    public function getGalleryItemsProperty()
    {
        return GalleryModel::where('is_active', true)
            ->with('media')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
    }

    public function render()
    {
        return view('livewire.frontend.gallery');
    }
}
