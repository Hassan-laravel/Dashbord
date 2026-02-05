<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Setting extends Model implements TranslatableContract
{
    use Translatable;

    // Translated attributes (stored in the Translations table)
    public $translatedAttributes = ['site_name', 'site_description', 'copyright'];

    // Static attributes (stored in the Settings table)
    protected $fillable = ['site_email', 'site_logo', 'maintenance_mode'];
}
