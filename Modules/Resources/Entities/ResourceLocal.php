<?php

namespace Modules\Resources\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cms\Entities\Language;
use Modules\Resources\Database\factories\ResourceLocalFactory;

class ResourceLocal extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = ['resource_id', 'language_id', 'name', 'status', 'short_description', 'description'];

    protected $table = 'resource_locals';
    
     /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function newFactory(): ResourceLocalFactory
    {
        //return ResourceLocalFactory::new();
    }

        /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function mainContent()
    {
        return $this->belongsTo(FreeResource::class, 'resource_id');
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
