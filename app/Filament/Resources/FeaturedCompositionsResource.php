<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeaturedCompositionsResource\Pages;
use App\Filament\Resources\FeaturedCompositionsResource\RelationManagers;
use App\Models\FeaturedCompositions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeaturedCompositionsResource extends Resource
{
    protected static ?string $model = FeaturedCompositions::class;

    protected static ?string $navigationIcon = 'heroicon-o-musical-note';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('mp3')
                    ->label('MP3')
                    ->disk('public')
                    ->directory('featured-compositions')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/mp3'])
                    ->required()
                    ->helperText('Upload an MP3 file for the composition.'),

                Forms\Components\TextInput::make('order')
                    ->label('Order')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->helperText('Order of appearance in the list. Lower numbers appear first.')
                    ->minValue(0),
            ])->columns([
                'sm' => 1,
                'md' => 2,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('Order')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                
                Tables\Columns\IconColumn::make('has_mp3')
                    ->label('MP3 File')
                    ->boolean()
                    ->trueIcon('heroicon-o-musical-note')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->getStateUsing(fn ($record) => !empty($record->mp3))
                    ->alignCenter(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc');
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeaturedCompositions::route('/'),
            'create' => Pages\CreateFeaturedCompositions::route('/create'),
            'edit' => Pages\EditFeaturedCompositions::route('/{record}/edit'),
        ];
    }
}
