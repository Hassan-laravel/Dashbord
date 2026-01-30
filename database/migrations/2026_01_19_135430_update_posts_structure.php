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
    // 1. إضافة حقل يوتيوب وإزالة category_id القديم (لأننا سنستخدم Many-to-Many)
    Schema::table('posts', function (Blueprint $table) {
        $table->string('youtube_link')->nullable()->after('image');
        // سنحذف المفتاح الأجنبي القديم لأننا سنستخدم جدول وسيط
        $table->dropForeign(['category_id']);
        $table->dropColumn('category_id');
    });

    // 2. إنشاء الجدول الوسيط (Many-to-Many) بين المقالات والتصنيفات
    Schema::create('category_post', function (Blueprint $table) {
        $table->id();
        $table->foreignId('post_id')->constrained()->onDelete('cascade');
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        // لمنع تكرار نفس التصنيف لنفس المقال
        $table->unique(['post_id', 'category_id']);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
