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
        // 1. Add YouTube field and remove the old category_id (switching to Many-to-Many)
        Schema::table('posts', function (Blueprint $table) {
            $table->string('youtube_link')->nullable()->after('image');

            // Drop the old foreign key because we are moving to a pivot table
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        // 2. Create the pivot table (Many-to-Many) between Posts and Categories
        Schema::create('category_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Prevent duplicate category assignments for the same post
            $table->unique(['post_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_post');

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('youtube_link');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
};
