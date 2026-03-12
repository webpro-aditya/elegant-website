<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Seo\Entities\Seo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $guarded = [];

    protected $enumStatus = ['publish', 'draft', 'suspend', 'outdate'];

    protected $fillable = ['id', 'name', 'code', 'rating', 'thumbnail_alt', 'image_title', 'discount', 'discount_fee', 'popular_course', 'certificate', 'career_package', 'parent_category_id', 'pricing_format', 'duration_type', 'duration', 'section', 'curriculum_url', 'brochure_url', 'slug', 'thumbnail_url', 'start_date', 'category_id', 'featured', 'mode_of_learning', 'fee', 'demo_video_url', 'short_description', 'description', 'status'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {

        static::creating(function ($course) {
            $date = Carbon::today();
            $monthAndDate = $date->format('nj');
    
            $randomString = Str::upper(Str::random(8)); // 8-letter uppercase random string
    
            $course->attributes['code'] = 'CRS_' . $randomString . '_' . $monthAndDate;
        });

        // Store old slug if slug changes
        static::updating(function ($course) {
            if ($course->isDirty('slug')) {
                $oldSlug = $course->getOriginal('slug');

                // Only create if not already present for this course
                $exists = CourseSlugHistory::where('slug', $oldSlug)
                    ->where('course_id', $course->id)
                    ->exists();

                if (!$exists) {
                    CourseSlugHistory::create([
                        'course_id' => $course->id,
                        'slug' => $oldSlug,
                    ]);
                }
            }
        });


        static::addGlobalScope('slug_not_null', function (Builder $builder) {
            $builder->whereNotNull('slug');
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');

    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }


    public function categories()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id', 'id');
    }



    public function syllabuses()
    {
        return $this->hasMany(Syllabus::class);
    }

    public function locales()
    {
        return $this->hasMany(CourseLocale::class, 'course_id', 'id');
    }

    public function defaultLocale()
    {
        $locale = config('app.locale');

        $languageId = config("app.local_languages.$locale");

        return $this->hasOne(CourseLocale::class, 'course_id', 'id')->where('language_id', $languageId);
    }


    public function englishLocale()
    {
        $englishLanguageId = config("app.local_languages.en"); // Adjust as per your config

        return $this->hasOne(CourseLocale::class, 'course_id', 'id')
            ->where('language_id', $englishLanguageId);
    }

    public function items()
    {
        return $this->hasMany(CourseItem::class, 'course_id', 'id');
    }


    public function seo()
    {
        return $this->morphOne(Seo::class, 'modelable', 'model', 'model_id');
    }

    public function slugHistory()
    {
        return $this->hasMany(CourseSlugHistory::class);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePublish($query)
    {
        return $query->where('status', 'publish');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSuspend($query)
    {
        return $query->where('status', 'suspend');
    }

    public function scopeOutdate($query)
    {
        return $query->where('status', 'outdate');
    }

    public function scopeByStatus($query, array $statuses)
    {
        return $query->whereIn('status', $statuses);
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
