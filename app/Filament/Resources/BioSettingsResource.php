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
    protected static ?string $navigationLabel = 'Bio Page';
    protected static ?string $modelLabel = 'Configuración de Biografía';
    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Principal Section')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('subtitle')
                            ->label('Subtitle')
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make('Info Artist')
                    ->schema([
                        Forms\Components\TextInput::make('artist_name')
                            ->label('Artist Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('artist_role')
                            ->label('Artist Role')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description_1')
                            ->label('First Paragraph')
                            ->required()
                            ->rows(4),
                        Forms\Components\Textarea::make('description_2')
                            ->label('Second Paragraph')
                            ->required()
                            ->rows(4),
                    ]),

                Forms\Components\Section::make('Stats Section')
                    ->schema([
                        Forms\Components\TextInput::make('years_experience')
                            ->label('Years of Experience')
                            ->required(),
                        Forms\Components\TextInput::make('compositions_count')
                            ->label('Compositions Count')
                            ->required(),
                        Forms\Components\TextInput::make('performances_count')
                            ->label('Performances Count')
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Philosophy Section')
                    ->schema([
                        Forms\Components\TextInput::make('philosophy_title')
                            ->label('Philosophy Title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('philosophy_quote')
                            ->label('Philosophy Quote')
                            ->required()
                            ->rows(4),
                    ]),

                Forms\Components\Section::make('Call to Action Section')
                    ->schema([
                        Forms\Components\TextInput::make('cta_title')
                            ->label('Títle CTA')
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
