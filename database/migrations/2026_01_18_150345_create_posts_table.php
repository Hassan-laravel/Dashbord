<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Main Posts Table
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Author
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Category
            $table->string('image')->nullable();
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->timestamps();
        });

        // 2. Post Translations Table
        Schema::create('post_translations', function (Blueprint $table) {
            $table->id();
            // Important change: post_id instead of article_id
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();

            // Translated Data
            $table->string('title');
            $table->text('content');

            // SEO Fields and Slugs
            $table->string('slug')->nullable()->index();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->unique(['post_id', 'locale']);
            $table->unique(['slug', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_translations');
        Schema::dropIfExists('posts');
    }
};
