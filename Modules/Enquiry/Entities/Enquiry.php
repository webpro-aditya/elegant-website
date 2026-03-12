<?php

namespace Modules\Enquiry\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\TrainingCalendar;
use Modules\Enquiry\Database\factories\EnquiryFactory;

class Enquiry extends Model
{
    use HasFactory;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = ['name', 'email', 'type', 'phone', 'location_id', 'number_of_participants', 'section','subject', 'message', 'course_id', 'country_code'];

    protected $table = 'enquiries';

    /*
   |--------------------------------------------------------------------------
   | FUNCTIONS
   |--------------------------------------------------------------------------
   */

    protected static function newFactory(): EnquiryFactory
    {
        //return EnquiryFactory::new();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id' , 'id');
    }

    public function calender()
    {
        return $this->belongsTo(TrainingCalendar::class);
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
