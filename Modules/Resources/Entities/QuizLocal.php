<?php

namespace Modules\Resources\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cms\Entities\Language;
use Modules\Resources\Database\factories\QuizLocalFactory;

class QuizLocal extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = ['quiz_id', 'language_id', 'question', 'options', 'answer'];
    protected $table = 'quiz_locals';

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function newFactory(): QuizLocalFactory
    {
        //return QuizLocalFactory::new();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function mainContent()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
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
