<?php

namespace Modules\Course\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Course\Entities\Enrollment;

class EnrollmentHelper
{
    public function searchEnrollment($keyword)
    {
        $enrollments = Enrollment::where('title', 'like', "%{$keyword}%");

        return $enrollments->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function save(array $input)
    {
        if ($enrollment = Enrollment::create($input)) {
            return $enrollment;
        }

        return false;
    }

    public function getEnrollmentDatatable($data)
    {
        $enrollments = Enrollment::select(app(Enrollment::class)->getTable() . '.*')->with(['user', 'course']);

        if (isset($data['user_id'])) {
            $enrollments->where('user_id', $data['user_id']);
        }

        if (isset($data['course_id']) && ($data['course_id'])) {
            $enrollments->where('course_id', $data['course_id']);
        }

        if (isset($data['status']) && ($data['status'])) {
            $enrollments->where('status', $data['status']);
        }

        return $enrollments;
    }

    public function delete($enrollmentId)
    {
        try {
            $enrollment = Enrollment::findOrFail($enrollmentId);
            $enrollment->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getEnrollment($id)
    {
        return Enrollment::find($id);
    }

    public function update($data)
    {
        $enrollment = Enrollment::find($data['id']);

        if ($enrollment->update($data)) {
            return $enrollment;
        }

        return false;
    }

    public function getAllEnrollment()
    {
        return Enrollment::All();
    }

    public function getPendingEnrollment()
    {
        return Enrollment::with('course', 'user')->where('status', 'awaiting')->get();
    }
}
