<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. الإعدادات الثابتة (مشتركة لكل اللغات)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_email')->nullable();
            $table->string('site_logo')->nullable();
            $table->boolean('maintenance_mode')->default(false);
            $table->timestamps();
        });

        // 2. ترجمة الإعدادات (متغيرة حسب اللغة)
        Schema::create('setting_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->constrained('settings')->cascadeOnDelete();
            $table->string('locale')->index();

            $table->string('site_name')->nullable();
            $table->text('site_description')->nullable();
            $table->string('copyright')->nullable();

            $table->unique(['setting_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setting_translations');
        Schema::dropIfExists('settings');
    }
};
