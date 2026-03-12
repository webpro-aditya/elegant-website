<?php

namespace Modules\Course\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Cms\Entities\Language;
use Modules\Course\Entities\CourseLocale;
use Modules\Course\Entities\SyllabusLocal;
use Modules\Course\Entities\Title;
use Modules\Course\Helpers\CourseHelper;
use Modules\Course\Helpers\SyllabusHelper;
use Modules\Course\Http\Requests\Admin\Syllabus\SyllabusCreateRequest;
use Modules\Course\Http\Requests\Admin\Syllabus\SyllabusDeleteRequest;
use Modules\Course\Http\Requests\Admin\Syllabus\SyllabusEditRequest;
use Modules\Course\Http\Requests\Admin\Syllabus\SyllabusListDataRequest;
use Modules\Course\Http\Requests\Admin\Syllabus\SyllabusUpdateRequest;
use Modules\Course\Traits\TabViewHandler;
use Yajra\DataTables\DataTables;
use Modules\Settings\Helpers\SettingsHelper;
use Illuminate\Http\Request;
use Modules\Course\Helpers\LocalHelper;

class SyllabusController extends Controller
{
    use TabViewHandler;

    protected $breadcrumbs = [];

    protected $courseHelper, $syllabusHelper, $settingsHelper, $localHelper;

    public function __construct(SettingsHelper $settingsHelper, CourseHelper $courseHelper, SyllabusHelper $syllabusHelper, LocalHelper $localHelper)
    {
        $this->courseHelper = $courseHelper;
        $this->syllabusHelper = $syllabusHelper;
        $this->settingsHelper = $settingsHelper;
        $this->localHelper = $localHelper;
    }

    public function syllabusListData(Request $request, $course_id)
    {
        $data = $request->all();
        $data['course_id'] = $course_id;
        $modules = $this->syllabusHelper->getSyllabusDatatable($data);
        $dataTableJSON = DataTables::of($modules)
            ->addIndexColumn()
            ->editColumn('title', function ($module) use ($course_id) {
                $data['url'] = route('course_main_module_edit', ['id' => $module->id, 'course_id' => $course_id]);
                $data['text'] = $module ? ($module->title ?? '') : '';

                return view('elements.listLink', compact('data'));
            })
            ->editColumn('heading', function ($module) use ($course_id) {
                $data['text'] = $module ? ($module->heading ?? '') : '';
                return view('elements.listLink', compact('data'));
            })
            ->addColumn('status', function ($module) {
                return view('elements.listStatus')->with('data', $module);
            })
            ->addColumn('action', function ($module) use ($request, $course_id) {
                $data['edit_url'] = route('course_main_module_edit', ['id' => $module->id, 'course_id' => $course_id]);
                $data['delete_url'] = route('course_main_module_delete', ['id' => $module->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }

    public function form(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_list', 'name' => 'Course', 'permission' => 'course_read'],
            ['name' => 'Add Main Module'],
        ];

        $course_id = $request->course_id;
        $languages = $this->settingsHelper->getLanguages();
        $titles = $this->courseHelper->getTitles();
        $course = $this->courseHelper->getCourse($course_id);

        // $responce['html'] = (string) view('course::admin.course.drawers.mainModuleForm', compact('course_id', 'languages', 'titles'));
        // $responce['scripts'][] = (string) mix('js/admin/course/mainModule/addMainModule.js');

        return view('course::admin.course.tabEdits.addCourseSyllabus', compact( 'course_id', 'course', 'languages', 'titles', 'breadcrumbs'));

        // return $responce;
    }


    public function saveSyllabus(Request $request)
    {
        try {
            $request->validate([
                'course_id' => 'required|integer',
                'title.*' => 'required|string',
                'heading.*' => 'required|string',
                'description.*' => 'required|string',
            ]);

            $inputData = [
                'course_id' => $request->course_id,
                'batch_id' => $request->batch_id ?? 0,
                'status' => $request->status,
                'sort_order' => $request->sort_order,
            ];

            $syllabus = $this->syllabusHelper->save($inputData);

            $languageCodes = array_keys($request->input('title'));

            foreach ($languageCodes as $languageCode) {
                $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);

                if ($languageId) {
                    $localeData = [
                        'syllabus_id' => $syllabus->id,
                        'language_id' => $languageId,
                        'title' => $request->input('title')[$languageCode],
                        'heading' => $request->input('heading')[$languageCode],
                        'description' => $request->input('description')[$languageCode],
                    ];
                    $this->localHelper->saveSyllabusLocal($localeData);

                    $existingTitle = $this->localHelper->getTitleWithLanguage($request->input('title')[$languageCode], $languageId);


                    if (!$existingTitle) {
                        $titleData = [
                            'language_id' => $languageId,
                            'title' => $request->input('title')[$languageCode],
                        ];
                        $this->localHelper->saveTitle($titleData);
                    }
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        // Redirect to the main module list with a success message
        return redirect()
            ->route('course_main_module_list', ['id' => $request->course_id])
            ->with('success', 'Main Module added successfully');
    }


    public function editSyllabus(Request $request, $course_id)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_list', 'name' => 'Course', 'permission' => 'course_read'],
            ['name' => 'Edit Main Module'],
        ];
        $course = $this->courseHelper->getCourse($course_id);
        $module = $this->syllabusHelper->getsyllabus($request->id);
        $syllabusLocales = $this->syllabusHelper->getLocaleSyllabus($request->id);
        $titles = $this->courseHelper->getTitles();
        $languages = $this->settingsHelper->getLanguages();

        return view('course::admin.course.tabEdits.editCourseSyllubus', compact('course', 'languages', 'titles', 'syllabusLocales', 'breadcrumbs', 'module'));
    }

    public function updatesyllabus(Request $request)
    {
        try {
            $request->validate([
                'course_id' => 'required|integer',
                'title.*' => 'required|string',
                'heading.*' => 'required|string',
                'description.*' => 'required|string',
            ]);

            $inputData = [
                'id' => $request->id,
                'course_id' => $request->course_id,
                'batch_id' => $request->batch_id ?? 0,
                'status' => $request->status,
                'sort_order' => $request->sort_order,
            ];

            $syllabus = $this->syllabusHelper->update($inputData);

            $languageCodes = array_keys($request->input('title'));

            foreach ($languageCodes as $languageCode) {
                $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);

                if ($languageId) {
                    $localeData = [
                        'syllabus_id' => $syllabus->id,
                        'language_id' => $languageId,
                        'title' => $request->input('title')[$languageCode],
                        'heading' => $request->input('heading')[$languageCode],
                        'description' => $request->input('description')[$languageCode],
                    ];

                    $this->localHelper->updateOrCreateSyllabusLocal(
                        ['syllabus_id' => $syllabus->id, 'language_id' => $languageId],
                        $localeData
                    );
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('course_main_module_list', ['id' => $request->course_id])
            ->with('success', 'Main Module updated successfully');
    }

    public function deletesyllabus(Request $request)
    {
        if ($this->syllabusHelper->delete($request->id)) {
            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'Main Module deleted successfully']);
            } else {
                return redirect()->back()->with('success', 'Main Module deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('course_category_list')->with('success', 'Failed to delete');
        }
    }
}
