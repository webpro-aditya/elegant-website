<?php

namespace Modules\Resources\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cms\Entities\Language;
use Modules\Resources\Database\factories\ResourceContentFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceContent extends Model
{
    use HasFactory;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = ['id','resource_id', 'status', 'link', 'deleted_at'];
    protected $table = 'resource_contents';

        /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function newFactory(): ResourceContentFactory
    {
        //return ResourceContentFactory::new();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function resource()
    {
        return $this->hasMany(ResourceContent::class, 'resource_id', 'id');
    }
    public function locales()
    {
        return $this->hasMany(ResourceContentLocal::class, 'content_id', 'id');
    }
    public function defaultLocale()
    {
        $locale = app()->getLocale();
        $languageId = config("app.local_languages.$locale");
    
        return $this->hasOne(ResourceContentLocal::class, 'content_id', 'id')->where('language_id', $languageId);
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
