<?php

namespace Modules\Career\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Career\Database\factories\CareerApplicantFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareerApplicant extends Model
{
    use HasFactory;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = ['career_id', 'name', 'email', 'phone', 'linkedin_profile', 'job_profile', 'resume', 'status'];
    protected $table = 'career_applicants';


     /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function newFactory(): CareerApplicantFactory
    {
        //return CareerApplicantsFactory::new();
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function career()
    {
        return $this->belongsTo(Career::class, 'career_id', 'id'); 
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
