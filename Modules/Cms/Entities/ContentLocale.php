<?php

namespace Modules\Cms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cms\Database\factories\ContentLocaleFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class ContentLocale extends Model
{
    use HasFactory;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
   
    protected $fillable = ['content_id', 'language_id','name','title', 'short_description', 'description', 'content'];
    
    protected $table = 'content_locales';


     /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
  
    protected static function newFactory(): ContentLocaleFactory
    {
        //return ContentLocaleFactory::new();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function mainContent()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

       /*
   |--------------------------------------------------------------------------
   | SCOPES
   |--------------------------------------------------------------------------
   */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
