<?php

namespace Modules\Course\Traits;

use Modules\Course\Helpers\CourseHelper;
use Modules\Course\Helpers\VenueHelper;
use Modules\Course\Http\Requests\Admin\Batch\BatchListRequest;
use Modules\Course\Http\Requests\Admin\Course\CourseListRequest;
use Modules\User\Helpers\UserHelper;
use Illuminate\Http\Request;

trait TabViewHandler
{
    protected $courseHelper;

    protected $userHelper;

    protected $venueHelper;

    public function __construct(CourseHelper $courseHelper, UserHelper $userHelper, VenueHelper $venueHelper)
    {
        $this->courseHelper = $courseHelper;
        $this->userHelper = $userHelper;
        $this->venueHelper = $venueHelper;
    }

    public function courseSettingsView(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_list', 'name' => 'Course', 'permission' => 'course_read'],
            ['name' => 'View Course'],
        ];
        $course = $this->courseHelper->getCourse($request->id);
        $mentors = $this->userHelper->getAllMentors();
        $venues = $this->venueHelper->getAllVenue();

        return view('course::admin.course.tabViews.courseSettings', compact('course', 'breadcrumbs', 'mentors', 'venues'));
    }

    public function courseMainModuleView(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_list', 'name' => 'Course', 'permission' => 'course_read'],
            ['name' => 'View Course'],
        ];
        $course = $this->courseHelper->getCourse($request->id);
        $languages = $this->settingsHelper->getLanguages();
        $titles = $this->courseHelper->getTitles();


        return view('course::admin.course.tabViews.courseSyllabus', compact('course', 'titles', 'languages', 'breadcrumbs'));
    }

    public function courseTrainingCalendarView(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_list', 'name' => 'Course', 'permission' => 'course_read'],
            ['name' => 'View Course'],
        ];
        $course = $this->courseHelper->getCourse($request->id);
        $venues = $this->venueHelper->getAllVenue();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $languages = $this->settingsHelper->getLanguages();

        return view('course::admin.course.tabViews.courseTrainingCalendars', compact('course', 'languages', 'venues', 'days', 'breadcrumbs'));
    }

    public function courseTrainingOverView(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_list', 'name' => 'Course', 'permission' => 'course_read'],
            ['name' => 'Overview Course'],
        ];
        $course = $this->courseHelper->getCourse($request->id);
        if ($course->mode_of_learning) {
            $course->mode_of_learning = json_decode($course->mode_of_learning);
        }
        $venues = $this->venueHelper->getAllVenue();

        $coursesLocale = $this->courseHelper->getLocaleContents($request->id);
        $englishLocale = $coursesLocale['en']->first();
        $englishName = $englishLocale->name;
        $languages = $this->contentHelper->getAllLanguages();
        $seo = $this->seoHelper->getSeoByModelId($request->id);
        $mainModuleCount = 0;


        return view('course::admin.course.tabViews.courseOverview', compact('course', 'seo', 'languages', 'coursesLocale', 'englishName', 'venues', 'breadcrumbs'));
    }

    public function listCourseBatch(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Batch'],
        ];

        $course = $this->courseHelper->getCourse($request->id);

        return view('course::admin.course.tabViews.courseBatch', compact('breadcrumbs', 'course'));
    }

    public function listCourseJoinNow(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Batch'],
        ];

        $course = $this->courseHelper->getCourse($request->id);

        return view('course::admin.course.tabViews.courseJoinNow', compact('breadcrumbs', 'course'));
    }
}
