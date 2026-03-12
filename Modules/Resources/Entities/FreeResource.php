<?php

namespace Modules\Resources\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Resources\Database\factories\FreeResourceFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class FreeResource extends Model
{
    use Sluggable;
    use HasFactory;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = ['id', 'name', 'type', 'slug', 'thumbnail', 'image_title', 'time','thumbnail_alt', 'is_popular', 'section', 'status'];
    protected $table = 'free_resources';
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function newFactory(): FreeResourceFactory
    {
        //return FreeResourceFactory::new();
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

    public function locales()
    {
        return $this->hasMany(ResourceLocal::class, 'resource_id', 'id');
    }

    public function contents()
    {
        return $this->hasMany(ResourceContent::class, 'resource_id', 'id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'resource_id', 'id');
    }

    public function defaultLocale()
    {
        $locale = config('app.locale');

        $languageId = config("app.local_languages.$locale");

        return $this->hasOne(ResourceLocal::class, 'resource_id', 'id')->where('language_id', $languageId);
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
