<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{
    use Translatable;

    // الحقول التي ستتم ترجمتها (تخزن في جدول الترجمة)
    public $translatedAttributes = ['name', 'slug', 'meta_title', 'meta_description'];

    // الحقول القابلة للتعبئة في الجدول الأساسي
    protected $fillable = ['status'];
public function posts()
    {
        // خطأ شائع: return $this->hasMany(Post::class);

        // الصحيح هو:
        return $this->belongsToMany(Post::class, 'category_post');
    }
}
