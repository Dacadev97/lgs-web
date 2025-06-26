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
        Schema::create('bio_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('About the Artist');
            $table->string('subtitle')->default('Discover the story behind the music');
            $table->string('artist_name')->default('Jaime Romero');
            $table->string('artist_role')->default('Classical and Latin Guitar Virtuoso');
            $table->text('description_1');
            $table->text('description_2');
            $table->string('years_experience')->default('20+');
            $table->string('compositions_count')->default('100+');
            $table->string('performances_count')->default('50+');
            $table->string('philosophy_title')->default('Musical Philosophy');
            $table->text('philosophy_quote');
            $table->string('cta_title')->default('Explore the Musical Journey');
            $table->timestamps();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bio_settings');
    }
};
