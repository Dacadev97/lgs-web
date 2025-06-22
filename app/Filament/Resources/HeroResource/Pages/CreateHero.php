<?php

namespace App\Filament\Resources\HeroResource\Pages;

use App\Filament\Resources\HeroResource;
use App\Models\Hero;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateHero extends CreateRecord
{
    protected static string $resource = HeroResource::class;

    public function mount(): void
    {
        // If a hero already exists, redirect to edit page
        if (Hero::exists()) {
            $hero = Hero::first();
            Notification::make()
                ->title('Hero already exists')
                ->body('Only one hero can exist. Redirecting to edit page.')
                ->warning()
                ->send();
            
            $this->redirect(HeroResource::getUrl('edit', ['record' => $hero]));
        }
        
        parent::mount();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
