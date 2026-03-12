<?php

namespace Modules\Course\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Cms\Entities\Language;
use Modules\Course\Entities\CalenderLocal;
use Modules\Course\Helpers\BatchHelper;
use Modules\Course\Helpers\CourseHelper;
use Modules\Course\Helpers\LocalHelper;
use Modules\Course\Helpers\TrainingCalendarHelper;
use Modules\Course\Helpers\VenueHelper;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Course\Http\Requests\Admin\TrainingCalendar\TrainingCalendarCreateRequest;
use Modules\Course\Http\Requests\Admin\TrainingCalendar\TrainingCalendarDeleteRequest;
use Modules\Course\Http\Requests\Admin\TrainingCalendar\TrainingCalendarEditRequest;
use Modules\Course\Http\Requests\Admin\TrainingCalendar\TrainingCalendarListDataRequest;
use Modules\Course\Http\Requests\Admin\TrainingCalendar\TrainingCalendarUpdateRequest;
use Modules\Course\Traits\TabViewHandler;
use PHPUnit\Framework\MockObject\Stub\ReturnReference;
use Yajra\DataTables\DataTables;

class TrainingCalendarController extends Controller
{
    use TabViewHandler;
    protected $breadcrumbs = [];
    protected $courseHelper, $trainingCalendarHelper, $localHelper,$batchHelper, $venueHelper, $settingsHelper;


    public function __construct(CourseHelper $courseHelper, LocalHelper $localHelper, SettingsHelper $settingsHelper, TrainingCalendarHelper $trainingCalendarHelper, VenueHelper $venueHelper, BatchHelper $batchHelper)
    {
        $this->courseHelper = $courseHelper;
        $this->trainingCalendarHelper = $trainingCalendarHelper;
        $this->venueHelper = $venueHelper;
        $this->batchHelper = $batchHelper;
        $this->settingsHelper = $settingsHelper;
        $this->localHelper = $localHelper;
    }

    public function trainingCalendarListData(TrainingCalendarListDataRequest $request, $course_id)
    {
        $trainingCalendars = $this->trainingCalendarHelper->getTrainingCalendarDatatable($request->all(), $course_id);
        $dataTableJSON = DataTables::of($trainingCalendars)
            ->addIndexColumn()
            ->editColumn('title', function ($trainingCalendar) use ($course_id) {
                $data['text'] = $trainingCalendar->courses->slug;

                return view('elements.listLink', compact('data'));
            })
            ->addColumn('status', function ($trainingCalendar) {
                return view('elements.listStatus')->with('data', $trainingCalendar);
            })
            ->addColumn('action', function ($trainingCalendar) use ($request, $course_id) {
                $data['edit_url'] = route('course_training_calendar_edit', ['id' => $trainingCalendar->id, 'course_id' => $course_id]);
                $data['delete_url'] = route('course_training_calendar_delete', ['id' => $trainingCalendar->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }

    public function saveTrainingCalendar(TrainingCalendarCreateRequest $request)
    {
        try {
            $inputData = [
                'course_id' => $request->course_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
                'days' => json_encode($request->days),
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'batch_id' => 1
            ];

            $calander = $this->trainingCalendarHelper->save($inputData);

            $languageCodes = array_keys($request->input('venue'));

            foreach ($languageCodes as $languageCode) {

                $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);

                if ($languageId) {
                    $localeData = [
                        'language_id' => $languageId,
                        'calander_id' => $calander->id,
                        'venue' => $request->input('venue')[$languageCode] ?? null,
                        'language' => $request->input('language')[$languageCode] ?? null,
                    ];
                    $this->localHelper->saveCalenderLocal($localeData);
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('course_training_calendar_list', ['id' => $request->course_id])
            ->with('success', 'Training Calendar added successfully');
    }

    public function editTrainingCalendar(TrainingCalendarEditRequest $request, $course_id)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_list', 'name' => 'Course', 'permission' => 'course_read'],
            ['name' => 'Edit Training Calendar'],
        ];
        $course = $this->courseHelper->getCourse($course_id);
        $trainingCalendar = $this->trainingCalendarHelper->getTrainingCalendar($request->id);
        $selectedDays = json_decode($trainingCalendar->days, true);
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $languages = $this->settingsHelper->getLanguages();
        $calenderLocale = $this->courseHelper->getCalenderLocal($request->id);

        return view('course::admin.course.tabEdits.editCourseTrainingCalendar', compact('course', 'calenderLocale', 'languages', 'selectedDays', 'days', 'breadcrumbs', 'trainingCalendar'));
    }

    public function updateTrainingCalendar(TrainingCalendarUpdateRequest $request)
    {
        try {

            $inputData = [
                'id' => $request->id,
                'course_id' => $request->course_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
                'days' => json_encode($request->days),
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'batch_id' => 1
            ];

            $calander = $this->trainingCalendarHelper->update($inputData);

            $languageCodes = array_keys($request->input('venue'));

            foreach ($languageCodes as $languageCode) {
                $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);

                if ($languageId) {
                    $localeData = [
                        'language_id' => $languageId,
                        'calander_id' => $calander->id,
                        'venue' => $request->input('venue')[$languageCode] ?? null,
                        'language' => $request->input('language')[$languageCode] ?? null,
                    ];

                    $courseLocale = $this->localHelper->getCalenderLocalWithLanguage($calander->id, $languageId);
     

                    if ($courseLocale) {
                        $courseLocale->update($localeData);
                    } else {
                        $this->localHelper->saveCalenderLocal($localeData);
                    }
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('course_training_calendar_list', ['id' => $request->course_id])
            ->with('success', 'Training Calendar updated successfully');
    }

    public function deleteTrainingCalendar(TrainingCalendarDeleteRequest $request)
    {
        if ($this->trainingCalendarHelper->delete($request->id)) {
            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'Training Calendar deleted successfully']);
            } else {
                return redirect()->back()->with('success', 'Training Calendar deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('course_category_list')->with('success', 'Failed to delete');
        }
    }

    public function list(TrainingCalendarListDataRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Training Calendar'],
        ];

        return view('course::admin.trainingCalendar.listCalendar', compact('breadcrumbs'));
    }

    public function calendarListData(TrainingCalendarListDataRequest $request)
    {
        $calendars = $this->trainingCalendarHelper->getCalendarDatatable($request->all());
        $dataTableJSON = DataTables::of($calendars)
            ->addIndexColumn()
            ->editColumn('title', function ($calendar) {
                return $calendar->title;
            })

            ->editColumn('course', function ($calendar) {
                $courseTitle = $calendar->courses->locales->first();
                $data['url'] = route('course_view', ['id' => $calendar->course_id]);
                $data['text'] = $courseTitle->title;

                return view('elements.listLink', compact('data'));
            })

            ->editColumn('batch', function ($calendar) {
                if (!$calendar->batch_id) {
                    return '2019-2022';
                }
                return $calendar->batches->name;
            })

            ->editColumn('start_date', function ($calendar) {
                return $calendar->start_date;
            })

            ->editColumn('end_date', function ($calendar) {
                return $calendar->end_date;
            })

            ->addColumn('status', function ($code) {
                return view('elements.listStatus')->with('data', $code);
            })
            ->make();

        return $dataTableJSON;
    }
}
