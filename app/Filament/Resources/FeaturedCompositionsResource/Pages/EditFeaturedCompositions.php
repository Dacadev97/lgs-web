<?php

namespace App\Filament\Resources\FeaturedCompositionsResource\Pages;

use App\Filament\Resources\FeaturedCompositionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeaturedCompositions extends EditRecord
{
    protected static string $resource = FeaturedCompositionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
