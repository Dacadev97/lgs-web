<?php

namespace App\Filament\Pages;

use App\Models\FloatingComposition;
use Filament\Pages\Page;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;

class ManageFloatingComposition extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Floating Composition';
    protected static ?string $title = 'Floating Composition Settings';
    protected static ?string $slug = 'floating-composition-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = FloatingComposition::first() ?? FloatingComposition::create(['is_active' => false]);
        $this->form->fill([
            'is_active' => $settings->is_active,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Toggle::make('is_active')
                    ->label('Show Latest Composition')
                    ->helperText('When enabled, shows the latest composition in a floating element on the homepage')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $settings = FloatingComposition::first() ?? new FloatingComposition();
        $settings->is_active = $this->form->getState()['is_active'];
        $settings->save();

        Notification::make()
            ->success()
            ->title('Settings saved successfully')
            ->send();
    }
}
