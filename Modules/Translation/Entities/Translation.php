<?php

namespace Modules\Translation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Translation\Database\factories\TranslationFactory;

class Translation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key', 'value_en', 'value_ar'
    ];
    
    protected $table = 'translations';

}
