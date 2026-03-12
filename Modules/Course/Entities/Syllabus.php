<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Course\Database\factories\SyllabusFactory;

class Syllabus extends Model
{
    use HasFactory;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $guarded = [];

    protected $table = 'syllabuses';
    protected $fillable = ['id', 'course_id', 'batch_id', 'status', 'sort_order'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function newFactory(): SyllabusFactory
    {
        return SyllabusFactory::new();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function locales()
    {
        return $this->hasMany(SyllabusLocal::class, 'syllabus_id', 'id');
    }

    public function defaultLocale()
    {
        $locale = config('app.locale');

        $languageId = config("app.local_languages.$locale");

        return $this->hasOne(SyllabusLocal::class, 'syllabus_id', 'id')->where('language_id', $languageId);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    public function getTitleAttribute()
    {
        return $this->defaultLocale ? ($this->defaultLocale->title ?? '') : '';
    }

    public function getHeadingAttribute()
    {
        return $this->defaultLocale ? ($this->defaultLocale->heading ?? '') : '';
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
