<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Composition;

class CategoryCompositions extends Component
{
    use WithPagination;

    public $selectedCategory;
    public $search = '';
    public $sortBy = 'title';
    public $invalidCategory = false;

    public function mount($category = null)
    {
        // Si no se proporciona categoría, mostrar todas
        if (!$category) {
            $this->selectedCategory = null;
            $this->invalidCategory = false;
            return;
        }

        // Buscar categoría por ID o por nombre
        $categoryModel = null;
        
        // Si es numérico, buscar por ID
        if (is_numeric($category)) {
            $categoryModel = Category::where('id', $category)
                ->where('is_active', true)
                ->first();
        } else {
            // Si no es numérico, buscar por nombre (case insensitive)
            $categoryModel = Category::where('name', 'LIKE', $category)
                ->where('is_active', true)
                ->first();
        }
        
        if ($categoryModel) {
            $this->selectedCategory = $categoryModel->id;
            $this->invalidCategory = false;
        } else {
            $this->selectedCategory = null;
            $this->invalidCategory = true;
        }
    }

    public function getCategoriesProperty()
    {
        return Category::where('is_active', true)
            ->withCount('compositions')
            ->orderBy('name')
            ->get();
    }

    public function getSelectedCategoryModelProperty()
    {
        return $this->selectedCategory ? Category::find($this->selectedCategory) : null;
    }

    public function getCompositionsProperty()
    {
        $query = Composition::where('is_active', true)
            ->with(['category', 'media']);

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('composer', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        return $query->orderBy($this->sortBy, $this->sortBy === 'created_at' ? 'desc' : 'asc')
            ->paginate(12);
    }

    public function render()
    {
        return view('livewire.frontend.category-compositions');
    }
}
