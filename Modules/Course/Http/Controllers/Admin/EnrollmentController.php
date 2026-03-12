<?php

namespace Modules\Course\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Course\Helpers\CourseHelper;
use Modules\Course\Helpers\EnrollmentHelper;
use Modules\Course\Http\Requests\Admin\Enrollment\EnrollmentAddRequest;
use Modules\Course\Http\Requests\Admin\Enrollment\EnrollmentCreateRequest;
use Modules\Course\Http\Requests\Admin\Enrollment\EnrollmentDeleteRequest;
use Modules\Course\Http\Requests\Admin\Enrollment\EnrollmentEditRequest;
use Modules\Course\Http\Requests\Admin\Enrollment\EnrollmentListDataRequest;
use Modules\Course\Http\Requests\Admin\Enrollment\EnrollmentListRequest;
use Modules\Course\Http\Requests\Admin\Enrollment\EnrollmentUpdateRequest;
use Modules\User\Helpers\UserHelper;
use Yajra\DataTables\DataTables;

class EnrollmentController extends Controller
{
    protected $enrollmentHelper;

    protected $courseHelper;

    protected $userHelper;

    public function __construct(EnrollmentHelper $enrollmentHelper, CourseHelper $courseHelper, UserHelper $userHelper)
    {
        $this->enrollmentHelper = $enrollmentHelper;

        $this->courseHelper = $courseHelper;

        $this->userHelper = $userHelper;

    }

    public function listEnrollment(EnrollmentListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Enrollment'],
        ];
        $courses = $this->courseHelper->getAllCourse();
        $users = $this->userHelper->getAllUsers();

        return view('course::admin.enrollment.listEnrollment', compact('breadcrumbs', 'users', 'courses'));
    }

    public function enrollmentListData(EnrollmentListDataRequest $request)
    {
        $enrollments = $this->enrollmentHelper->getEnrollmentDatatable($request->all());
        $dataTableJSON = DataTables::of($enrollments)
            ->addIndexColumn()
            ->editColumn('course', function ($enrollment) {
                return ($enrollment->course) ? $enrollment->course->title : '';
            })
            ->editColumn('user', function ($enrollment) {
                return ($enrollment->user) ? $enrollment->user->name : '';
            })
            ->addColumn('action', function ($enrollment) use ($request) {
                $data['delete_url'] = route('enrollment_delete', ['id' => $enrollment->id]);
                $data['view_url'] = route('enrollment_view', ['id' => $enrollment->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }

    public function viewEnrollment(EnrollmentListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'enrollment_list', 'name' => 'Enrollment', 'permission' => 'enrollment_read'],
            ['name' => 'View Enrollment'],
        ];
        $enrollment = $this->enrollmentHelper->getEnrollment($request->id);

        return view('course::admin.enrollment.viewEnrollment', compact('enrollment', 'breadcrumbs'));
    }

    public function addEnrollment(EnrollmentAddRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'enrollment_list', 'name' => 'Enrollment', 'permission' => 'enrollment_read'],
            ['name' => 'Add Enrollment'],
        ];
        $courses = $this->courseHelper->getAllCourse();

        return view('course::admin.enrollment.addEnrollment', compact('breadcrumbs', 'courses'));
    }

    public function createEnrollment(EnrollmentCreateRequest $request)
    {
        $inputData = [
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
        ];
        $enrollment = $this->enrollmentHelper->save($inputData);

        activity()->performedOn($enrollment)->event('Enrollment Created')->withProperties(['id' => $enrollment->id, 'data' => $inputData])->log('Enrollment Created');

        return redirect()
            ->route('enrollment_list')
            ->with('success', 'Enrollment added successfully');
    }

    public function editEnrollment(EnrollmentEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'enrollment_list', 'name' => 'Enrollment', 'permission' => 'enrollment_read'],
            ['name' => 'Enrollment Details'],
        ];
        $enrollment = $this->enrollmentHelper->getEnrollment($request->id);
        $courses = $this->courseHelper->getAllCourse();

        return view('course::admin.enrollment.listEnrollment', compact('enrollment', 'breadcrumbs', 'courses'));
    }

    public function updateEnrollment(EnrollmentUpdateRequest $request)
    {
        $inputData = [
            'id' => $request->id,
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
        ];

        $enrollment = $this->enrollmentHelper->update($inputData);

        activity()->performedOn($enrollment)->event('Enrollment Updated')->withProperties(['id' => $enrollment->id, 'data' => $inputData])->log('Enrollment Created');

        return redirect()
            ->route('enrollment_list')
            ->with('success', 'Enrollment updated successfully');
    }

    public function deleteEnrollment(EnrollmentDeleteRequest $request)
    {
        if ($this->enrollmentHelper->delete($request->id)) {
            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'Enrollment deleted successfully']);
            } else {
                return redirect()->route('enrollment_list')->with('success', 'Enrollment deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('enrollment_list')->with('success', 'Failed to delete');
        }
    }
}
