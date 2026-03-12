<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Database\factories\CurriculumFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curriculum extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'email', 'type', 'phone', 'location_id', 'number_of_participants', 'section','subject', 'message', 'course_id', 'country_code'];
    
    protected $table = 'curriculum';

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id' , 'id');
    }
}
