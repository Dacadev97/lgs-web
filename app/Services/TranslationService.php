<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    private $translator;
    private $cachePrefix = 'translation_';
    private $cacheTime = 86400; // 24 hours

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
    }

    /**
     * Traduce un texto al idioma especificado
     */
    public function translate(string $text, string $targetLanguage, string $sourceLanguage = 'auto'): string
    {
        // Si el idioma objetivo es el mismo que el idioma por defecto, no traducir
        if ($targetLanguage === 'en') {
            return $text; // Asumir que el contenido original está en inglés
        }

        // Crear clave de cache única
        $cacheKey = $this->cachePrefix . md5($text . $sourceLanguage . $targetLanguage);

        // Intentar obtener de cache primero
        $cachedTranslation = Cache::get($cacheKey);
        if ($cachedTranslation) {
            return $cachedTranslation;
        }

        try {
            // Configurar idiomas
            $this->translator->setSource($sourceLanguage);
            $this->translator->setTarget($targetLanguage);

            // Realizar traducción
            $translation = $this->translator->translate($text);

            // Guardar en cache
            Cache::put($cacheKey, $translation, $this->cacheTime);

            Log::info("Traducción realizada: {$text} -> {$translation}");

            return $translation;

        } catch (\Exception $e) {
            Log::error("Error en traducción: " . $e->getMessage());
            // En caso de error, devolver texto original
            return $text;
        }
    }

    /**
     * Traduce un array de textos
     */
    public function translateArray(array $texts, string $targetLanguage, string $sourceLanguage = 'auto'): array
    {
        $translations = [];
        
        foreach ($texts as $key => $text) {
            if (is_string($text) && !empty(trim($text))) {
                $translations[$key] = $this->translate($text, $targetLanguage, $sourceLanguage);
            } else {
                $translations[$key] = $text;
            }
        }

        return $translations;
    }

    /**
     * Traduce contenido HTML preservando las etiquetas
     */
    public function translateHtml(string $html, string $targetLanguage, string $sourceLanguage = 'auto'): string
    {
        if ($targetLanguage === 'en') {
            return $html; // Contenido original en inglés
        }

        // Crear clave de cache
        $cacheKey = $this->cachePrefix . 'html_' . md5($html . $sourceLanguage . $targetLanguage);
        
        $cachedTranslation = Cache::get($cacheKey);
        if ($cachedTranslation) {
            return $cachedTranslation;
        }

        try {
            // Extraer texto de HTML para traducir
            $textContent = strip_tags($html);
            
            if (empty(trim($textContent))) {
                return $html;
            }

            // Traducir solo el texto
            $translatedText = $this->translate($textContent, $targetLanguage, $sourceLanguage);
            
            // Reemplazar el contenido de texto en el HTML original
            $translatedHtml = str_replace($textContent, $translatedText, $html);

            Cache::put($cacheKey, $translatedHtml, $this->cacheTime);

            return $translatedHtml;

        } catch (\Exception $e) {
            Log::error("Error en traducción HTML: " . $e->getMessage());
            return $html;
        }
    }

    /**
     * Limpia la cache de traducciones
     */
    public function clearCache(): void
    {
        // Esto limpiará todas las traducciones en cache
        Cache::flush();
    }
}
