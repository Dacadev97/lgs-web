<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Livewire\Frontend\FloatingLatestComposition;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $publicStorage = public_path('storage');
        $storageAppPublic = storage_path('app/public');
        if (!file_exists($publicStorage)) {
            @symlink($storageAppPublic, $publicStorage);
        }

        Livewire::component('frontend.floating-latest-composition', FloatingLatestComposition::class);
    }
}
