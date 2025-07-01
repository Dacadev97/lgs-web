<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;

class Composition extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'pdf',
        'mp3',
        'category_id',
        'format',
        'composer',
        'description',
        'is_active',
        'downloads',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('pdfs')
            ->acceptsMimeTypes(['application/pdf']);

        $this->addMediaCollection('audio')
            ->acceptsMimeTypes(['audio/mpeg', 'audio/mp3', 'audio/wav']);

        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    // Métodos para obtener URLs de archivos
    public function getPdfUrl()
    {
        if ($this->getFirstMediaUrl('pdfs')) {
            return $this->getFirstMediaUrl('pdfs');
        }
        return $this->pdf ? asset('storage/' . $this->pdf) : null;
    }

    public function getAudioUrl()
    {
        // Primero intentamos obtener desde Media Library
        if ($mediaUrl = $this->getFirstMediaUrl('audio')) {
            return $mediaUrl;
        }

        // Luego intentamos desde el campo mp3
        if ($this->mp3) {
            // Verificar si existe el archivo
            if (\Storage::disk('public')->exists($this->mp3)) {
                return asset('storage/' . $this->mp3);
            }
        }

        // Si llegamos aquí, usamos la ruta del controlador
        return route('serve.audio', $this->id);
    }

    public function getThumbnailUrl()
    {
        return $this->getFirstMediaUrl('images') ?: null;
    }

    // Verificar si tiene archivos
    public function hasPdf()
    {
        return $this->getFirstMediaUrl('pdfs') || ($this->pdf && \Storage::disk('public')->exists($this->pdf));
    }

    public function hasAudio()
    {
        return $this->getFirstMediaUrl('audio') || ($this->mp3 && \Storage::disk('public')->exists($this->mp3));
    }

    public function hasFiles()
    {
        return $this->hasPdf() || $this->hasAudio();
    }

    // Método para incrementar descargas
    public function incrementDownloads()
    {
        $this->increment('downloads');
    }
}
