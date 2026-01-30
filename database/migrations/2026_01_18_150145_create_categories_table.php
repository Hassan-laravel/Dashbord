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
        // 1. الجدول الأساسي
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(true); // مفعل أو لا
            $table->timestamps();
        });

        // 2. جدول الترجمة
        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();

            $table->string('name');

            // --- الإضافات الجديدة ---
            $table->string('slug')->nullable()->index(); // Index لتسريع البحث
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->unique(['category_id', 'locale']);
            $table->unique(['slug', 'locale']); // لضمان عدم تكرار الرابط في نفس اللغة
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
