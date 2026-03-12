<?php

namespace Modules\Resources\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cms\Entities\Language;
use Modules\Resources\Database\factories\ResourceContentLocalFactory;

class ResourceContentLocal extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = ['id', 'content_id', 'language_id', 'question', 'answer'];

    protected $table = 'resource_content_locals';

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function newFactory(): ResourceContentLocalFactory
    {
        //return ResourceContentLocalFactory::new();
    }

    /*
|--------------------------------------------------------------------------
| RELATIONS
|--------------------------------------------------------------------------
*/


    public function mainContent()
    {
        return $this->belongsTo(ResourceContent::class, 'content_id', 'id');
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

    public function getEnglishQuestionAttribute()
    {
        if ($this->language_id == Language::where('code', 'en')->first()->id) {
            return $this->question;
        }
        return null; // Adjust this logic based on your specific requirement
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
