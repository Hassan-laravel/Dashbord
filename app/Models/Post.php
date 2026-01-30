<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Post extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['title', 'content', 'slug', 'meta_title', 'meta_description'];

    // أضفنا youtube_link
    protected $fillable = ['user_id', 'image', 'youtube_link', 'status'];

    // العلاقة أصبحت BelongsToMany
public function categories()
    {
        // العلاقة يجب أن تكون belongsToMany
        return $this->belongsToMany(Category::class, 'category_post');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // علاقة الصور الفرعية
    public function images()
    {
        return $this->hasMany(PostImage::class);
    }
}
