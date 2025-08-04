<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::view('/gallery', 'gallery.index')->name('gallery');

Route::view('/bio', 'bio.index')->name('bio');

Route::view('/compositions', 'compositions.index')->name('compositions.byCategory');

Route::get('/download-package/{id}', [\App\Http\Controllers\DownloadController::class, 'package'])->name('download.package');
Route::get('/preview-pdf/{id}', [\App\Http\Controllers\DownloadController::class, 'previewPdf'])->name('preview.pdf');
Route::get('/serve-audio/{id}', [\App\Http\Controllers\DownloadController::class, 'serveAudio'])->name('serve.audio');
