<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixStorageLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnosticar y corregir problemas de storage en cPanel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== DIAGNÓSTICO DE STORAGE ===');
        
        // Verificar rutas
        $storagePath = storage_path('app/public');
        $publicPath = public_path('storage');
        
        $this->info('Storage path: ' . $storagePath);
        $this->info('Public path: ' . $publicPath);
        
        // Verificar si existe storage/app/public
        if (File::exists($storagePath)) {
            $this->info('✅ storage/app/public existe');
            
            // Listar archivos en hero
            $heroPath = $storagePath . '/hero';
            if (File::exists($heroPath)) {
                $files = File::files($heroPath);
                $this->info('Archivos en hero: ' . count($files));
                foreach ($files as $file) {
                    $this->info('- ' . $file->getFilename());
                }
            } else {
                $this->error('❌ Carpeta hero no existe');
            }
        } else {
            $this->error('❌ storage/app/public no existe');
        }
        
        // Verificar enlace simbólico
        if (File::exists($publicPath)) {
            if (is_link($publicPath)) {
                $this->info('✅ Enlace simbólico existe');
                $this->info('Apunta a: ' . readlink($publicPath));
            } else {
                $this->warn('⚠️ public/storage existe pero no es un enlace simbólico');
                // Intentar eliminar y recrear
                if (File::isDirectory($publicPath)) {
                    File::deleteDirectory($publicPath);
                    $this->info('Eliminada carpeta incorrecta');
                }
            }
        } else {
            $this->error('❌ public/storage no existe');
        }
        
        // Intentar crear enlace simbólico
        $this->info('\n=== CREANDO ENLACE SIMBÓLICO ===');
        
        try {
            // Método 1: symlink nativo
            if (function_exists('symlink')) {
                $target = '../storage/app/public';
                if (!File::exists($publicPath)) {
                    if (symlink($target, $publicPath)) {
                        $this->info('✅ Enlace simbólico creado con symlink()');
                    } else {
                        $this->error('❌ Error creando enlace con symlink()');
                    }
                }
            } else {
                $this->warn('⚠️ función symlink() no disponible');
            }
            
            // Método 2: Laravel storage:link
            $this->call('storage:link');
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
        
        // Verificar resultado final
        $this->info('\n=== VERIFICACIÓN FINAL ===');
        if (File::exists($publicPath)) {
            $this->info('✅ public/storage existe');
            
            // Verificar archivo específico
            $testFile = $publicPath . '/hero';
            if (File::exists($testFile)) {
                $this->info('✅ public/storage/hero accesible');
            } else {
                $this->error('❌ public/storage/hero no accesible');
            }
        } else {
            $this->error('❌ public/storage sigue sin existir');
            
            // Método de emergencia: copiar archivos
            $this->info('Intentando método de emergencia...');
            if (File::exists($storagePath)) {
                File::copyDirectory($storagePath, $publicPath);
                $this->info('✅ Archivos copiados directamente');
            }
        }
        
        return 0;
    }
}
