<?php

namespace App\Filament\Pages;

use App\Models\Composition;
use App\Models\Category;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class BulkPdfUpload extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';
    protected static string $view = 'filament.pages.bulk-pdf-upload';
    protected static ?string $title = 'Subir PDFs masivamente';

    public $pdfs = [];

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
        $category = Category::where('name', 'Other')->first();

        foreach ($this->pdfs as $pdf) {
            $filename = $pdf->getClientOriginalName();
            $title = pathinfo($filename, PATHINFO_FILENAME);

            $pdfPath = $pdf->store('compositions/pdf', 'public');

            Composition::create([
                'title' => $title,
                'category_id' => $category ? $category->id : null,
                'format' => 'PDF',
                'pdf' => $pdfPath,
                'mp3' => null,
            ]);
        }

        Notification::make()
            ->title('¡PDFs subidos y composiciones creadas!')
            ->success()
            ->send();

        $this->pdfs = [];
    }
}
