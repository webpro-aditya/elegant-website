<?php

namespace Modules\Career\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Career\Database\factories\CareerFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Career extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = ['category_id', 'title', 'vaccancy', 'employment',  'experience', 'slug', 'status'];

    protected $table = 'careers';

      /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function newFactory(): CareerFactory
    {
        //return CareerFactory::new();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title', 
                'onUpdate' => false     
            ]
        ];
    }

            /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(CareerCategory::class, 'category_id', 'id');
    }
    public function locales()
    {
        return $this->hasMany(CareerLocale::class, 'career_id', 'id');
    }

    public function defaultLocale()
    {
        $locale = config('app.locale');

        $languageId = config("app.local_languages.$locale");

        return $this->hasOne(CareerLocale::class, 'career_id', 'id')->where('language_id', $languageId);
    }

    /*
   |--------------------------------------------------------------------------
   | SCOPES
   |--------------------------------------------------------------------------
   */
  public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
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
