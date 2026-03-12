<?php

namespace Modules\Author\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Author\Database\factories\AuthorFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Blog\Entities\Blog;

class Author extends Model
{
    use HasFactory;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
   
    protected $fillable = ['thumbnail', 'thumbnail_alt', 'facebook', 'twitter', 'instagram','slug', 'status' ];
    
    protected $table = 'authors';

        /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function newFactory(): AuthorFactory
    {
        //return AuthorFactory::new();
    }

        /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
     // Author has many localized contents
     public function locales()
     {
         return $this->hasMany(AuthorLocal::class, 'author_id', 'id');
     }
    public function defaultLocale()
    {
        $locale = config('app.locale');

        $languageId = config("app.local_languages.$locale");

        return $this->hasOne(AuthorLocal::class, 'author_id', 'id')->where('language_id', $languageId);
    }
    
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id', 'id');
    }

  /*
   |--------------------------------------------------------------------------
   | SCOPES
   |--------------------------------------------------------------------------
   */

   public function getNameAttribute()
   {
       return $this->defaultLocale->name;
   }


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
