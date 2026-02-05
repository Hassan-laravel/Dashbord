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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(true); // Active or inactive
            $table->timestamps();
        });

        // 2. Translation Table
        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();

            $table->string('name');

            // --- New Additions ---
            $table->string('slug')->nullable()->index(); // Index to speed up search queries
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->unique(['category_id', 'locale']);
            $table->unique(['slug', 'locale']); // To ensure unique slugs per locale
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_translations');
        Schema::create('categories');
    }
};
