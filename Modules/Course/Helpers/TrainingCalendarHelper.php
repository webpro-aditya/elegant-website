<?php

namespace Modules\Course\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Course\Entities\TrainingCalendar;

class TrainingCalendarHelper
{
    protected $trainingCalendar;

    public function __construct(TrainingCalendar $trainingCalendar)
    {
        $this->trainingCalendar = $trainingCalendar;
    }

    /*
    |--------------------------------------------------------------------------
    | CRUD FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function save(array $input)
    {
        if ($calendar = $this->trainingCalendar->create($input)) {
            return $calendar;
        }

        return false;
    }

    public function delete($calendarId)
    {
        try {
            $calendar = $this->trainingCalendar->findOrFail($calendarId);
            $calendar->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function update($data)
    {
        $calendar = $this->trainingCalendar->find($data['id']);

        if ($calendar->update($data)) {
            return $calendar;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getTrainingCalendarDatatable($data, $courseId)
    {
        $trainingCalendars = $this->trainingCalendar->where('course_id', $courseId)->with('courses')->get();

        if (isset($data['status'])) { 
            $trainingCalendars = $trainingCalendars->where('status', $data['status']);
        }
 
        return $trainingCalendars;
    }

    public function getTrainingCalendar($id)
    {
        return $this->trainingCalendar->find($id);
    }

    public function getAllTrainingCalendar()
    {
        return $this->trainingCalendar->all();
    }

    /*
    |--------------------------------------------------------------------------
    | ADDITIONAL FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function searchTrainingCalendar($keyword)
    {
        $calendars = $this->trainingCalendar->where('title', 'like', "%{$keyword}%");

        return $calendars->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function getCalendarDatatable($data)
    {
        $calendar = TrainingCalendar::select(app(TrainingCalendar::class)->getTable() . '.*')->with('courses.locales', 'batches');

        if (isset($data['status'])) {
            $calendar->where('status', $data['status']);
        }

        return $calendar;
    }
}
