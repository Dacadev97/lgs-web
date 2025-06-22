<?php

namespace App\Filament\Resources\HeroResource\Pages;

use App\Filament\Resources\HeroResource;
use App\Models\Hero;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHeroes extends ListRecords
{
    protected static string $resource = HeroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => Hero::count() === 0),
        ];
    }

    public function getTitle(): string
    {
        return Hero::exists() ? 'Hero Configuration' : 'Create Hero';
    }

    public function getSubheading(): ?string
    {
        return Hero::exists() 
            ? 'Only one hero configuration is allowed. You can edit the existing one below.'
            : 'Create your hero section configuration.';
    }
}
