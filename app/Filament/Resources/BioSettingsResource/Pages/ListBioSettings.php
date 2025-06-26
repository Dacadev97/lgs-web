<?php

namespace App\Filament\Resources\BioSettingsResource\Pages;

use App\Filament\Resources\BioSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBioSettings extends ListRecords
{
    protected static string $resource = BioSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
