<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Classical',
                'description' => 'Traditional classical guitar compositions from the masters',
                'icon' => 'fas fa-music',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Flamenco',
                'description' => 'Passionate flamenco pieces with authentic Spanish flavor',
                'icon' => 'fas fa-fire',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Bossa Nova',
                'description' => 'Smooth Brazilian bossa nova rhythms and melodies',
                'icon' => 'fas fa-cocktail',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Tango',
                'description' => 'Dramatic Argentine tango compositions',
                'icon' => 'fas fa-heart',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Folk',
                'description' => 'Traditional folk songs from Latin America',
                'icon' => 'fas fa-mountain',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Contemporary',
                'description' => 'Modern compositions and arrangements',
                'icon' => 'fas fa-star',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Symphony Orchestra',
                'description' => 'Grand orchestral arrangements for symphony orchestra',
                'icon' => 'fas fa-music',
                'sort_order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
