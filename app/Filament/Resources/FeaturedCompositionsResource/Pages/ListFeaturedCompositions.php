<?php

namespace App\Filament\Resources\FeaturedCompositionsResource\Pages;

use App\Filament\Resources\FeaturedCompositionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeaturedCompositions extends ListRecords
{
    protected static string $resource = FeaturedCompositionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
