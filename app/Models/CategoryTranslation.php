<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    // Timestamps are not required in the translation table
    public $timestamps = false;

    // Mass assignable attributes (must match the fields in the migration)
    protected $fillable = ['name', 'slug', 'meta_title', 'meta_description'];
}
