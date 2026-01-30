<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    // لا نحتاج timestamps في جدول الترجمة
    public $timestamps = false;

    // الحقول المسموح بتعبئتها (يجب أن تطابق الحقول في الماغريشن)
    protected $fillable = ['name', 'slug', 'meta_title', 'meta_description'];
}
