<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Composition;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;

class DownloadController extends Controller
{
    public function package($id)
    {
        $composition = Composition::with('category')->findOrFail($id);
        
        // Verificar que tenga al menos un archivo
        if (!$composition->hasFiles()) {
            abort(404, 'No hay archivos disponibles para descargar.');
        }

        $zipFileName = $this->sanitizeFilename($composition->title) . '_' . $composition->id . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // Crear carpeta temporal si no existe
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new ZipArchive;
        $filesAdded = 0;
        
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Agregar PDF desde Media Library o storage
            if ($composition->hasPdf()) {
                $pdfAdded = $this->addPdfToZip($zip, $composition);
                if ($pdfAdded) $filesAdded++;
            }
            
            // Agregar MP3 desde Media Library o storage
            if ($composition->hasAudio()) {
                $audioAdded = $this->addAudioToZip($zip, $composition);
                if ($audioAdded) $filesAdded++;
            }
            
            // Agregar archivo README con información
            $this->addReadmeToZip($zip, $composition);
            
            $zip->close();
        } else {
            abort(500, 'No se pudo crear el archivo ZIP.');
        }
        
        if ($filesAdded === 0) {
            // Limpiar archivo ZIP vacío
            if (file_exists($zipPath)) {
                unlink($zipPath);
            }
            abort(404, 'No se encontraron archivos válidos para descargar.');
        }

        // Incrementar contador de descargas
        $composition->incrementDownloads();

        // Descargar y eliminar el archivo temporal después
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
    
    /**
     * Agregar PDF al ZIP
     */
    private function addPdfToZip(ZipArchive $zip, Composition $composition): bool
    {
        // Intentar desde Media Library primero
        $pdfMedia = $composition->getFirstMedia('pdfs');
        if ($pdfMedia && file_exists($pdfMedia->getPath())) {
            $fileName = $this->sanitizeFilename($composition->title) . '.pdf';
            return $zip->addFile($pdfMedia->getPath(), $fileName);
        }
        
        // Intentar desde storage tradicional
        if ($composition->pdf && Storage::disk('public')->exists($composition->pdf)) {
            $fileName = $this->sanitizeFilename($composition->title) . '.pdf';
            return $zip->addFile(storage_path('app/public/' . $composition->pdf), $fileName);
        }
        
        return false;
    }
    
    /**
     * Agregar audio al ZIP
     */
    private function addAudioToZip(ZipArchive $zip, Composition $composition): bool
    {
        // Intentar desde Media Library primero
        $audioMedia = $composition->getFirstMedia('audio');
        if ($audioMedia && file_exists($audioMedia->getPath())) {
            $fileName = $this->sanitizeFilename($composition->title) . '.mp3';
            return $zip->addFile($audioMedia->getPath(), $fileName);
        }
        
        // Intentar desde storage tradicional
        if ($composition->mp3 && Storage::disk('public')->exists($composition->mp3)) {
            $fileName = $this->sanitizeFilename($composition->title) . '.mp3';
            return $zip->addFile(storage_path('app/public/' . $composition->mp3), $fileName);
        }
        
        return false;
    }
    
    /**
     * Agregar README con información de la composición
     */
    private function addReadmeToZip(ZipArchive $zip, Composition $composition): void
    {
        $readme = "COMPOSICIÓN: {$composition->title}\n";
        $readme .= "COMPOSITOR: {$composition->composer}\n";
        if ($composition->category) {
            $readme .= "CATEGORÍA: {$composition->category->name}\n";
        }
        if ($composition->description) {
            $readme .= "DESCRIPCIÓN: {$composition->description}\n";
        }
        $readme .= "\nFECHA DE DESCARGA: " . now()->format('d/m/Y H:i:s') . "\n";
        $readme .= "\nGracias por descargar desde Latin Guitar Scores!\n";
        
        $zip->addFromString('README.txt', $readme);
    }
    
    /**
     * Limpiar nombre de archivo
     */
    private function sanitizeFilename(string $filename): string
    {
        // Remover caracteres especiales y espacios
        $filename = preg_replace('/[^a-zA-Z0-9\s\-_]/', '', $filename);
        $filename = preg_replace('/\s+/', '_', $filename);
        return trim($filename, '_');
    }
    
    /**
     * Vista previa de PDF
     */
    public function previewPdf($id)
    {
        $composition = Composition::with('category')->findOrFail($id);
        
        if (!$composition->hasPdf()) {
            abort(404, 'PDF no encontrado.');
        }
        
        $pdfUrl = $composition->getPdfUrl();
        if (!$pdfUrl) {
            abort(404, 'PDF no disponible.');
        }
        
        // Si es una URL de Media Library, redirigir directamente
        if (filter_var($pdfUrl, FILTER_VALIDATE_URL)) {
            return redirect($pdfUrl);
        }
        
        // Si es archivo local, servirlo con headers apropiados
        $pdfMedia = $composition->getFirstMedia('pdfs');
        if ($pdfMedia && file_exists($pdfMedia->getPath())) {
            return response()->file($pdfMedia->getPath(), [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $pdfMedia->file_name . '"'
            ]);
        }
        
        // Archivo tradicional en storage
        if ($composition->pdf && Storage::disk('public')->exists($composition->pdf)) {
            $path = storage_path('app/public/' . $composition->pdf);
            return response()->file($path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($composition->pdf) . '"'
            ]);
        }
        
        abort(404, 'PDF no encontrado.');
    }
    
    /**
     * Servir archivo de audio
     */
    public function serveAudio($id)
    {
        $composition = Composition::with('category')->findOrFail($id);
        
        if (!$composition->hasAudio()) {
            abort(404, 'Audio no encontrado.');
        }
        
        $audioUrl = $composition->getAudioUrl();
        if (!$audioUrl) {
            abort(404, 'Audio no disponible.');
        }
        
        // Si es una URL de Media Library, redirigir directamente
        if (filter_var($audioUrl, FILTER_VALIDATE_URL)) {
            return redirect($audioUrl);
        }
        
        // Si es archivo local, servirlo con headers apropiados para streaming
        $audioMedia = $composition->getFirstMedia('audio');
        if ($audioMedia && file_exists($audioMedia->getPath())) {
            return response()->file($audioMedia->getPath(), [
                'Content-Type' => 'audio/mpeg',
                'Accept-Ranges' => 'bytes',
                'Content-Disposition' => 'inline; filename="' . $audioMedia->file_name . '"'
            ]);
        }
        
        // Archivo tradicional en storage
        if ($composition->mp3 && Storage::disk('public')->exists($composition->mp3)) {
            $path = storage_path('app/public/' . $composition->mp3);
            return response()->file($path, [
                'Content-Type' => 'audio/mpeg',
                'Accept-Ranges' => 'bytes',
                'Content-Disposition' => 'inline; filename="' . basename($composition->mp3) . '"'
            ]);
        }
        
        abort(404, 'Audio no encontrado.');
    }
}
