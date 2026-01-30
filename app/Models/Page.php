<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Page extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['title', 'content', 'slug', 'meta_title', 'meta_description'];

    protected $fillable = ['image', 'status', 'user_id'];

    // علاقة مع الكاتب
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
