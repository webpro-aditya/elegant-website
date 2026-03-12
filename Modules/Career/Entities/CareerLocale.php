<?php

namespace Modules\Career\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Career\Database\factories\CareerLocaleFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cms\Entities\Language;

class CareerLocale extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['career_id', 'job_profile', 'language_id','name', 'location', 'skill'];
    
    protected $table = 'career_locales';

       /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function newFactory(): CareerLocaleFactory
    {
        //return CareerLocaleFactory::new();
    }

        /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function mainContent()
    {
        return $this->belongsTo(Career::class, 'career_id');
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
