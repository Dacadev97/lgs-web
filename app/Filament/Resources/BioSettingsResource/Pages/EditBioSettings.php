<?php


namespace App\Filament\Resources\BioSettingsResource\Pages;

use App\Filament\Resources\BioSettingsResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\BioSettings;

class EditBioSettings extends EditRecord
{
    protected static string $resource = BioSettingsResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $settings = BioSettings::firstOrCreate(
            [],
            [
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
            ]
        );

        $this->record = $settings;

        return $data;
    }
}
