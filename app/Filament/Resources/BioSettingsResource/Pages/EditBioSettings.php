<?php

namespace App\Filament\Resources\BioSettingsResource\Pages;

use App\Filament\Resources\BioSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBioSettings extends EditRecord
{
    protected static string $resource = BioSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
