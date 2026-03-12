<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Course\Database\factories\CourseCategoryFactory;

class CourseCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'slug',
        'image',
        'section',
        'status',
        'parent_category_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function newFactory(): CourseCategoryFactory
    {
        return CourseCategoryFactory::new();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function course()
    {
        return $this->hasMany(Course::class, 'category_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(CourseCategory::class, 'parent_category_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(CourseCategory::class, 'parent_category_id', 'id');
    }

    public function locales()
    {
        return $this->hasMany(CourseCategoryLocal::class, 'category_id', 'id');
    }

    public function defaultLocale()
    {
        $locale = config('app.locale');

        $languageId = config("app.local_languages.$locale");

        return $this->hasOne(CourseCategoryLocal::class, 'category_id', 'id')->where('language_id', $languageId);
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
