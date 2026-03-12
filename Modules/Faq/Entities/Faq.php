<?php

namespace Modules\Faq\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Entities\Course;
use Modules\Faq\Database\factories\FaqFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = ['model', 'model_id', 'course_id', 'status'];
    
    protected $table = 'faqs';


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function newFactory(): FaqFactory
    {
        //return FaqFactory::new();
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function course(){
        $this->belongsTo(Course::class, 'course_id', 'id');
    }


    public function locales()
    {
        return $this->hasMany(FaqLocal::class, 'faq_id', 'id');
    }

    public function defaultLocale()
    {
        $locale = config('app.locale');

        $languageId = config("app.local_languages.$locale");

        return $this->hasOne(FaqLocal::class, 'faq_id', 'id')->where('language_id', $languageId);
    }


        /*
   |--------------------------------------------------------------------------
   | SCOPES
   |--------------------------------------------------------------------------
   */

   public function getQuestionAttribute()
    {
        return $this->defaultLocale->question;
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
