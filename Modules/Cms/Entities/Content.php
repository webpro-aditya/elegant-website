<?php

namespace Modules\Cms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cms\Database\factories\ContentFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Course\Entities\Course;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Builder;
use Modules\Seo\Entities\Seo;

class Content extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = ['content_category_id', 'course_id', 'slug','phone_number', 'email', 'description','short_description', 'file', 'link', 'thumbnail', 'thumbnail_alt', 'image_title', 'status', 'page_slug', 'is_deletable', 'section'];

    protected $table = 'contents';

    /*
   |--------------------------------------------------------------------------
   | FUNCTIONS
   |--------------------------------------------------------------------------
   */
    protected static function newFactory(): ContentFactory
    {
        //return ContentFactory::new();
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function category()
    {
        return $this->hasMany(Content::class, 'slug', 'content_category_id');
    }

    public function items()
    {
        return $this->hasMany(ContentItem::class, 'content_id', 'id');
    }

    public function contentCategory()
    {
        return $this->belongsTo(ContentCategory::class, 'content_category_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function locales()
    {
        return $this->hasMany(ContentLocale::class, 'content_id', 'id');
    }
    public function defaultLocale()
    {
        $locale = config('app.locale');

        $languageId = config("app.local_languages.$locale");

        return $this->hasOne(ContentLocale::class, 'content_id', 'id')->where('language_id', $languageId);
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

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('section', function (Builder $builder) {
            $builder->where('section', 'web');
        });
    }

    public function getContentAttribute()
    {
        return (app()->getLocale() == 'ar') ? $this->content_ar : $this->content_en;
    }


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
