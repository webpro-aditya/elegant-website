<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Database\factories\CourseSlugHistoryFactory;

class CourseSlugHistory extends Model
{

    protected $fillable = ['course_id', 'slug'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
