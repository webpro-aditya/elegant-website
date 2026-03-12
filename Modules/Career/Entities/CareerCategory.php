<?php

namespace Modules\Career\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Career\Database\factories\CareerCategoryFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareerCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name_en',
        'name_sp',
        'name_ar',
        'name_fr',
        'slug',
        'section',
        'status'
    ];

    protected $table = 'career_categories';

    /*
   |--------------------------------------------------------------------------
   | FUNCTIONS
   |--------------------------------------------------------------------------
   */

    protected static function newFactory(): CareerCategoryFactory
    {
        //return CareerCategoryFactory::new();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function careers()
    {
        return $this->hasMany(Career::class, 'category_id', 'id');
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
