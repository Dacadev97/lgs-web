<?php

namespace App\Filament\Resources\BioSettingsResource\Pages;

use App\Filament\Resources\BioSettingsResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\BioSettings;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;

class EditBioSettings extends EditRecord
{
    protected static string $resource = BioSettingsResource::class;

    // Define un título personalizado para la página
    public function getTitle(): string|Htmlable
    {
        return 'Edit Bio Settings';
    }

    public function mount($record = null): void
    {
        // Crear o recuperar el registro existente
        $settings = BioSettings::firstOrCreate(
            [], // Sin condiciones
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

        // Llamar al mount de la clase padre con el ID del registro
        parent::mount($settings->id);
    }

    // No redirigir después de guardar
    protected function getRedirectUrl(): ?string
    {
        return null;
    }

    // Mensaje de éxito personalizado
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Bio settings updated')
            ->body('The biography settings have been updated successfully.');
    }
}
