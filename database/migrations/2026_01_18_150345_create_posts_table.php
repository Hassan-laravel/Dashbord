<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. الجدول الأساسي للمنشورات
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // الكاتب
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // التصنيف
            $table->string('image')->nullable();
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->timestamps();
        });

        // 2. جدول ترجمة المنشورات
        Schema::create('post_translations', function (Blueprint $table) {
            $table->id();
            // هنا التغيير المهم: post_id بدلاً من article_id
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();

            // البيانات المترجمة
            $table->string('title');
            $table->text('content');

            // حقول SEO والروابط
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
