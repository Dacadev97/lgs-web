<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BioSettingsResource\Pages;
use App\Models\BioSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class BioSettingsResource extends Resource
{
    protected static ?string $model = BioSettings::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Página de Biografía';
    protected static ?string $modelLabel = 'Configuración de Biografía';
    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Sección Principal')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('subtitle')
                            ->label('Subtítulo')
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make('Información del Artista')
                    ->schema([
                        Forms\Components\TextInput::make('artist_name')
                            ->label('Nombre del Artista')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('artist_role')
                            ->label('Rol del Artista')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description_1')
                            ->label('Primer Párrafo')
                            ->required()
                            ->rows(4),
                        Forms\Components\Textarea::make('description_2')
                            ->label('Segundo Párrafo')
                            ->required()
                            ->rows(4),
                    ]),

                Forms\Components\Section::make('Estadísticas')
                    ->schema([
                        Forms\Components\TextInput::make('years_experience')
                            ->label('Años de Experiencia')
                            ->required(),
                        Forms\Components\TextInput::make('compositions_count')
                            ->label('Número de Composiciones')
                            ->required(),
                        Forms\Components\TextInput::make('performances_count')
                            ->label('Número de Presentaciones')
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Sección de Filosofía')
                    ->schema([
                        Forms\Components\TextInput::make('philosophy_title')
                            ->label('Título de Filosofía')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('philosophy_quote')
                            ->label('Cita Filosófica')
                            ->required()
                            ->rows(4),
                    ]),

                Forms\Components\Section::make('Llamado a la Acción')
                    ->schema([
                        Forms\Components\TextInput::make('cta_title')
                            ->label('Título CTA')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\EditBioSettings::route('/'),
        ];
    }
}
