<?php

namespace App\Filament\Resources\CompositionResource\Pages;

use App\Filament\Resources\CompositionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComposition extends EditRecord
{
    protected static string $resource = CompositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
