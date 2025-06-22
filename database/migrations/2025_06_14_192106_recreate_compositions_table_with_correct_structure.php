<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primero, guardamos cualquier dato existente
        $compositions = DB::table('compositions')->get();
        
        // Eliminamos la tabla existente
        Schema::dropIfExists('compositions');
        
        // Recreamos la tabla con la estructura correcta
        Schema::create('compositions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('pdf')->nullable();
            $table->string('mp3')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('format')->nullable();
            $table->string('composer')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Restauramos los datos (si los había)
        foreach ($compositions as $composition) {
            DB::table('compositions')->insert([
                'id' => $composition->id,
                'title' => $composition->title,
                'pdf' => $composition->pdf,
                'mp3' => $composition->mp3,
                'category_id' => null, // Como antes era string, lo ponemos null
                'format' => $composition->format,
                'composer' => null,
                'description' => null,
                'is_active' => true,
                'created_at' => $composition->created_at,
                'updated_at' => $composition->updated_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Para revertir, volvemos a la estructura original
        $compositions = DB::table('compositions')->get();
        
        Schema::dropIfExists('compositions');
        
        Schema::create('compositions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('pdf')->nullable();
            $table->string('mp3')->nullable();
            $table->string('category')->nullable();
            $table->string('format')->nullable();
            $table->timestamps();
        });
        
        foreach ($compositions as $composition) {
            DB::table('compositions')->insert([
                'id' => $composition->id,
                'title' => $composition->title,
                'pdf' => $composition->pdf,
                'mp3' => $composition->mp3,
                'category' => null,
                'format' => $composition->format,
                'created_at' => $composition->created_at,
                'updated_at' => $composition->updated_at,
            ]);
        }
    }
};
