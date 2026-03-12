<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Author\Entities\Author;
use Modules\Blog\Database\factories\BlogFactory;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Seo\Entities\Seo;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = ['thumbnail', 'name', 'thumbnail_alt', 'image_title', 'career_guidance', 'author_id', 'category_id','slug', 'section', 'is_popular', 'status' ];
    
    protected $table = 'blogs';

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function newFactory(): BlogFactory
    {
        //return BlogFactory::new();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name', 
                'onUpdate' => false     
            ]
        ];
    }

        /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id'); 
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id'); 
    }

    public function locales()
    {
        return $this->hasMany(BlogLocale::class, 'blog_id', 'id');
    }

    public function defaultLocale()
    {
        $locale = config('app.locale');

        $languageId = config("app.local_languages.$locale");

        return $this->hasOne(BlogLocale::class, 'blog_id', 'id')->where('language_id', $languageId);
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'modelable', 'model', 'model_id');
    }
    
    /*
   |--------------------------------------------------------------------------
   | SCOPES
   |--------------------------------------------------------------------------
   */

   public function getTitleAttribute()
   {
       return $this->defaultLocale->title;
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
