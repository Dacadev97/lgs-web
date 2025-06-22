<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class MigrateGalleryImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gallery:migrate-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate gallery images from traditional storage to Media Library';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting gallery images migration...');
        
        $galleries = Gallery::whereNotNull('image')->get();
        
        if ($galleries->isEmpty()) {
            $this->info('No galleries with images found.');
            return;
        }
        
        $this->info("Found {$galleries->count()} galleries with images.");
        
        $migrated = 0;
        $failed = 0;
        
        foreach ($galleries as $gallery) {
            try {
                $imagePath = $gallery->image;
                $fullPath = storage_path('app/public/' . $imagePath);
                
                if (!file_exists($fullPath)) {
                    $this->warn("Image file not found for gallery '{$gallery->title}': {$fullPath}");
                    $failed++;
                    continue;
                }
                
                // Check if already has media
                if ($gallery->getFirstMedia('images')) {
                    $this->info("Gallery '{$gallery->title}' already has media, skipping.");
                    continue;
                }
                
                // Add file to media library
                $gallery->addMedia($fullPath)
                    ->toMediaCollection('images');
                
                $this->info("✓ Migrated image for gallery: {$gallery->title}");
                $migrated++;
                
            } catch (\Exception $e) {
                $this->error("Failed to migrate image for gallery '{$gallery->title}': {$e->getMessage()}");
                $failed++;
            }
        }
        
        $this->info("\nMigration completed:");
        $this->info("✓ Successfully migrated: {$migrated}");
        
        if ($failed > 0) {
            $this->warn("✗ Failed to migrate: {$failed}");
        }
        
        if ($migrated > 0) {
            $this->info("\nYou can now remove the 'image' column from the galleries table if desired.");
        }
    }
}
