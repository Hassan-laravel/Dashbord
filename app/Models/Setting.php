<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Setting extends Model implements TranslatableContract
{
    use Translatable;

    // الحقول المترجمة (التي توجد في جدول Translations)
    public $translatedAttributes = ['site_name', 'site_description', 'copyright'];

    // الحقول الثابتة (التي توجد في جدول Settings)
    protected $fillable = ['site_email', 'site_logo', 'maintenance_mode'];
}
