<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Composition;
use Illuminate\Http\Request;

class CompositionController extends Controller
{
    public function index()
    {
        return Composition::with('category')->get();
    }

    public function byCategory($category)
    {
        // Buscar por ID de categoría o por nombre de categoría
        if (is_numeric($category)) {
            return Composition::where('category_id', $category)->with('category')->get();
        } else {
            return Composition::whereHas('category', function($query) use ($category) {
                $query->where('name', $category);
            })->with('category')->get();
        }
    }
}
