<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::post('/set-locale', function () {
    $locale = request('locale');
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return back();
})->name('set.locale');

Route::view('/gallery', 'gallery.index')->name('gallery');

Route::view('/bio', 'bio.index')->name('bio');

Route::view('/compositions', 'compositions.index')->name('compositions.byCategory');

// Ruta de prueba para el sistema de traducción (solo para desarrollo)
Route::get('/translation-test', function () {
    return view('translation-test');
})->name('translation.test');

Route::get('/download-package/{id}', [\App\Http\Controllers\DownloadController::class, 'package'])->name('download.package');
Route::get('/preview-pdf/{id}', [\App\Http\Controllers\DownloadController::class, 'previewPdf'])->name('preview.pdf');
Route::get('/serve-audio/{id}', [\App\Http\Controllers\DownloadController::class, 'serveAudio'])->name('serve.audio');
