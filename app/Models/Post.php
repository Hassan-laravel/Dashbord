<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Post extends Model implements TranslatableContract
{
    use Translatable;

    // Attributes to be translated
    public $translatedAttributes = ['title', 'content', 'slug', 'meta_title', 'meta_description'];

    // Added youtube_link to fillable attributes
    protected $fillable = ['user_id', 'image', 'youtube_link', 'status'];

    /**
     * Define the relationship with categories (Many-to-Many).
     */
    public function categories()
    {
        // This must be a belongsToMany relationship
        return $this->belongsToMany(Category::class, 'category_post');
    }

    /**
     * Define the relationship with the author.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship for gallery/secondary images.
     */
    public function images()
    {
        return $this->hasMany(PostImage::class);
    }
}
