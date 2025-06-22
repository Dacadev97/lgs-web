<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Composition;

class CompositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $compositions = [
            [
                'title' => 'Asturias (Leyenda)',
                'category' => 'Guitar',
                'format' => 'PDF',
                'pdf' => 'asturias.pdf',
                'mp3' => 'asturias.mp3',
            ],
            [
                'title' => 'Recuerdos de la Alhambra',
                'category' => 'Guitar',
                'format' => 'PDF',
                'pdf' => 'recuerdos.pdf',
                'mp3' => 'recuerdos.mp3',
            ],
            [
                'title' => 'El Cóndor Pasa',
                'category' => 'Andean Colombian Trio',
                'format' => 'PDF',
                'pdf' => 'condor.pdf',
                'mp3' => 'condor.mp3',
            ],
            [
                'title' => 'Bambuco en Mi menor',
                'category' => 'Andean Colombian Quartet',
                'format' => 'PDF',
                'pdf' => 'bambuco.pdf',
                'mp3' => 'bambuco.mp3',
            ],
            [
                'title' => 'Lágrima',
                'category' => 'Other Formats',
                'format' => 'PDF',
                'pdf' => 'lagrima.pdf',
                'mp3' => 'lagrima.mp3',
            ],
            [
                'title' => 'Concierto de Aranjuez (Adagio)',
                'category' => 'Symphony Orchestra',
                'format' => 'PDF',
                'pdf' => 'aranjuez.pdf',
                'mp3' => 'aranjuez.mp3',
            ],
        ];

        foreach ($compositions as $composition) {
            Composition::create($composition);
        }
    }
}
