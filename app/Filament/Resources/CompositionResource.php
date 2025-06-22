<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompositionResource\Pages;
use App\Filament\Resources\CompositionResource\RelationManagers;
use App\Models\Composition;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompositionResource extends Resource
{
    protected static ?string $model = Composition::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required(),

                Forms\Components\FileUpload::make('pdf')
                    ->label('PDF File')
                    ->required()
                    ->directory('compositions/pdf')
                    ->disk('public')
                    ->acceptedFileTypes(['application/pdf']),

                Forms\Components\FileUpload::make('mp3')
                    ->label('MP3 File')
                    ->required(false)
                    ->directory('compositions/mp3')
                    ->disk('public')
                    ->acceptedFileTypes(['audio/mpeg']),

                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->required()
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable(),

                Forms\Components\TextInput::make('format')
                    ->label('Format')
                    ->helperText('Optional: Specify format for special compositions'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('format')
                    ->label('Format')
                    ->placeholder('N/A')
                    ->sortable(),

                Tables\Columns\IconColumn::make('has_pdf')
                    ->label('PDF')
                    ->boolean()
                    ->trueIcon('heroicon-o-document')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->getStateUsing(fn($record) => !empty($record->pdf))
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('has_mp3')
                    ->label('MP3')
                    ->boolean()
                    ->trueIcon('heroicon-o-musical-note')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->getStateUsing(fn($record) => !empty($record->mp3))
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->preload(),
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
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListCompositions::route('/'),
            'create' => Pages\CreateComposition::route('/create'),
            'edit' => Pages\EditComposition::route('/{record}/edit'),
        ];
    }
}
