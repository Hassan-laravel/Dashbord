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
        // 1. Main Table
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable(); // Featured Image
            $table->enum('status', ['published', 'draft'])->default('published');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Author
            $table->timestamps();
        });

        // 2. Translation Table
        Schema::create('page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade');
            $table->string('locale')->index();

            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('slug')->unique(); // URL Slug
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            $table->unique(['page_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('pages');
    }
};
