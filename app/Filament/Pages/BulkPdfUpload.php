<?php

namespace App\Filament\Pages;

use App\Models\Composition;
use App\Models\Category;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;

class BulkPdfUpload extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';
    protected static string $view = 'filament.pages.bulk-pdf-upload';
    protected static ?string $title = 'Subir PDFs masivamente';
    protected static ?string $slug = 'bulk-pdf-upload'; // Añade esto

    public $pdfs = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\FileUpload::make('pdfs')
                ->label('PDFs')
                ->multiple()
                ->acceptedFileTypes(['application/pdf'])
                ->required(),
        ];
    }

    public function submit()
    {
        $data = $this->form->getState();
        $category = Category::where('name', 'Other')->first();

        foreach ($data['pdfs'] ?? [] as $pdfPath) {
            // Obtener el nombre del archivo de la ruta
            $filename = basename($pdfPath);
            $title = pathinfo($filename, PATHINFO_FILENAME);

            Composition::create([
                'title' => $title,
                'category_id' => $category ? $category->id : null,
                'format' => 'PDF',
                'pdf' => $pdfPath, // Ya tenemos la ruta del archivo
                'mp3' => null,
            ]);
        }

        Notification::make()
            ->title('¡PDFs subidos y composiciones creadas!')
            ->success()
            ->send();

        $this->form->fill();
    }
}
