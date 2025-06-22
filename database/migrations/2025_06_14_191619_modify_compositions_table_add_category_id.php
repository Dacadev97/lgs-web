<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('compositions', function (Blueprint $table) {
            // Eliminar la columna category (string)
            $table->dropColumn('category');
            // Agregar la columna category_id como foreign key
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compositions', function (Blueprint $table) {
            // Revertir: eliminar la foreign key y agregar la columna string
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->string('category')->nullable();
        });
    }
};
