<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TranslationController extends Controller
{
    private $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Traduce un texto simple
     */
    public function translateText(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string',
            'target_language' => 'required|string|in:en,es',
            'source_language' => 'string|in:auto,en,es'
        ]);

        $text = $request->input('text');
        $targetLanguage = $request->input('target_language');
        $sourceLanguage = $request->input('source_language', 'auto');

        try {
            $translation = $this->translationService->translate($text, $targetLanguage, $sourceLanguage);

            return response()->json([
                'success' => true,
                'original_text' => $text,
                'translated_text' => $translation,
                'source_language' => $sourceLanguage,
                'target_language' => $targetLanguage
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Translation failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Traduce contenido HTML completo
     */
    public function translateHtml(Request $request): JsonResponse
    {
        $request->validate([
            'html' => 'required|string',
            'target_language' => 'required|string|in:en,es',
            'source_language' => 'string|in:auto,en,es'
        ]);

        $html = $request->input('html');
        $targetLanguage = $request->input('target_language');
        $sourceLanguage = $request->input('source_language', 'auto');

        try {
            $translatedHtml = $this->translationService->translateHtml($html, $targetLanguage, $sourceLanguage);

            return response()->json([
                'success' => true,
                'original_html' => $html,
                'translated_html' => $translatedHtml,
                'source_language' => $sourceLanguage,
                'target_language' => $targetLanguage
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'HTML translation failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Traduce una página completa basada en selectores CSS
     */
    public function translatePage(Request $request): JsonResponse
    {
        $request->validate([
            'elements' => 'required|array',
            'elements.*.selector' => 'required|string',
            'elements.*.text' => 'required|string',
            'target_language' => 'required|string|in:en,es',
            'source_language' => 'string|in:auto,en,es'
        ]);

        $elements = $request->input('elements');
        $targetLanguage = $request->input('target_language');
        $sourceLanguage = $request->input('source_language', 'auto');

        try {
            $translations = [];

            foreach ($elements as $element) {
                $selector = $element['selector'];
                $text = $element['text'];
                
                $translation = $this->translationService->translate($text, $targetLanguage, $sourceLanguage);
                
                $translations[] = [
                    'selector' => $selector,
                    'original_text' => $text,
                    'translated_text' => $translation
                ];
            }

            return response()->json([
                'success' => true,
                'translations' => $translations,
                'source_language' => $sourceLanguage,
                'target_language' => $targetLanguage
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Page translation failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Limpia la cache de traducciones
     */
    public function clearCache(): JsonResponse
    {
        try {
            $this->translationService->clearCache();
            
            return response()->json([
                'success' => true,
                'message' => 'Translation cache cleared successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Cache clear failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
