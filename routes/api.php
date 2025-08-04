<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TranslationController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/compositions', function () {
    return ['message' => 'Lista de composiciones'];
});

// Rutas de traducción
Route::prefix('translate')->group(function () {
    Route::post('/text', [TranslationController::class, 'translateText']);
    Route::post('/html', [TranslationController::class, 'translateHtml']);
    Route::post('/page', [TranslationController::class, 'translatePage']);
    Route::delete('/cache', [TranslationController::class, 'clearCache']);
});
