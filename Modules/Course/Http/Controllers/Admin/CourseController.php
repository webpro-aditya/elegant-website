<?php

namespace Modules\Course\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\Cms\Entities\Language;
use Modules\Course\Entities\CourseLocale;
use Modules\Course\Helpers\CourseCategoryHelper;
use Modules\Course\Helpers\CourseHelper;
use Modules\Course\Helpers\SyllabusHelper;
use Modules\Course\Helpers\VenueHelper;
use Modules\Course\Http\Requests\Admin\Course\CourseAddRequest;
use Modules\Course\Http\Requests\Admin\Course\CourseCreateRequest;
use Modules\Course\Http\Requests\Admin\Course\CourseDeleteRequest;
use Modules\Course\Http\Requests\Admin\Course\CourseEditRequest;
use Modules\Course\Http\Requests\Admin\Course\CourseListDataRequest;
use Modules\Course\Http\Requests\Admin\Course\CourseListRequest;
use Modules\Course\Http\Requests\Admin\Course\CourseUpdateRequest;
use Modules\Course\Traits\TabViewHandler;
use Modules\User\Helpers\UserHelper;
use Yajra\DataTables\DataTables;
use ZipArchive;
use Modules\Seo\Helpers\SeoHelper;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Course\Entities\Course;
use Modules\Course\Helpers\LocalHelper;
use Modules\Faq\Helpers\FaqHelper;
use Modules\Course\Http\Controllers\Admin\Includes\Image;

class CourseController extends Controller
{
    use TabViewHandler;

    use Image;
    protected $breadcrumbs = [];
    protected $localHelper, $faqHelper, $courseCategoryHelper, $courseHelper, $userHelper, $venueHelper, $syllabusHelper, $settingsHelper, $seoHelper, $contentHelper;
    public function __construct(LocalHelper $localHelper, CourseCategoryHelper $courseCategoryHelper, FaqHelper $faqHelper, SettingsHelper $settingsHelper, SeoHelper $seoHelper, CourseHelper $courseHelper, UserHelper $userHelper, VenueHelper $venueHelper, SyllabusHelper $syllabusHelper, ContentHelper $contentHelper)
    {
        $this->courseHelper = $courseHelper;
        $this->userHelper = $userHelper;
        $this->syllabusHelper = $syllabusHelper;
        $this->venueHelper = $venueHelper;
        $this->settingsHelper = $settingsHelper;
        $this->seoHelper = $seoHelper;
        $this->contentHelper = $contentHelper;
        $this->faqHelper = $faqHelper;
        $this->courseCategoryHelper = $courseCategoryHelper;
        $this->localHelper = $localHelper;
    }

    public function listCourse(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Course'],
        ];

        return view('course::admin.course.listCourse', compact('breadcrumbs'));
    }

    public function courseListData(Request $request)
    {
        $courses = $this->courseHelper->getCourseDatatable($request->all());
        $dataTableJSON = DataTables::of($courses)
            ->addIndexColumn()
            ->editColumn('title', function ($course) {
                $data['url'] = route('course_view', ['id' => $course->id]);
                $data['text'] = $course->title;
                return view('elements.listLink', compact('data'));
            })
            ->editColumn('start_date', function ($course) {
                return $course->start_date ?? 'Not Assigned';
            })

            ->addColumn('status', function ($course) {
                return view('elements.listStatus')->with('data', $course);
            })

            ->addColumn('action', function ($course) use ($request) {
                $data['delete_url'] = route('course_delete', ['id' => $course->id]);
                $data['view_url'] = route('course_view', ['id' => $course->id]);
                $data['edit_url'] = route('course_edit', ['id' => $course->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }

    public function viewCourse(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_list', 'name' => 'Course', 'permission' => 'course_read'],
            ['name' => 'View Course'],
        ];
        $course = $this->courseHelper->getCourse($request->id);
        $mainModuleCount = 0;

        return view('course::admin.course.viewCourse', compact('course', 'breadcrumbs', 'mainModuleCount'));
    }

    public function addCourse(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_list', 'name' => 'Course', 'permission' => 'course_read'],
            ['name' => 'Add Course'],
        ];
        $languages = $this->settingsHelper->getLanguages();

        return view('course::admin.course.addCourse', compact('breadcrumbs', 'languages'));
    }

    public function createCourse(Request $request)
    {
        $englishTitle = $request->input('title')['en'];

        // Validate unique name per category
        $categoryId = $request->category_id;

        $request->validate([
            'title.en' => [
                'required',
                function ($attribute, $value, $fail) use ($categoryId) {
                    $exists = Course::where('name', $value)
                        ->where('category_id', $categoryId)
                        ->exists();
                    if ($exists) {
                        $fail('A course with this name already exists in the selected category.');
                    }
                }
            ],
            'category_id' => 'required|integer|exists:course_categories,id'
        ]);

        if ($request->has('category_id')) {
            $category = $this->courseHelper->getCategory($request->category_id);

            if ($category && $category->parent_category_id) {
                $parentCategoryId = $category->parent_category_id; // Parent category ID
                $categoryId = $category->id; // Current category ID
            } else {
                $parentCategoryId = null;
                $categoryId = $category ? $category->id : null;
            }
        } else {
            $categoryId = $request->parent_category_id ? $request->parent_category_id : null;
            $parentCategoryId = null;
        }

        $inputData = [
            'name' => $englishTitle,
            'section' => 'web',
            'status' => 'draft',
            'category_id' => $categoryId,
            'parent_category_id' => $parentCategoryId,
        ];
        $inputData['mode_of_learning'] = json_encode($request->mode_of_learning);

        $course = $this->courseHelper->save($inputData);

        // Handle language-specific titles
        $languageCodes = array_keys($request->input('title'));

        foreach ($languageCodes as $languageCode) {

            $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);

            if ($languageId) {
                $title = $request->input('title')[$languageCode];

                $localeData = [
                    'language_id' => $languageId,
                    'course_id' => $course->id,
                    'title' => $title,
                ];

                if (!empty($title)) {
                    $this->localHelper->saveCourseLocale($localeData);
                }
            }
        }

        activity()->performedOn($course)->event('Course Created')->withProperties(['id' => $course->id, 'data' => $inputData])->log('Course Course Created');

        return redirect()
            ->route('course_list')
            ->with('success', 'Course added successfully');
    }

    public function editCourse(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_list', 'name' => 'Course', 'permission' => 'course_read'],
            ['name' => 'Course Details'],
        ];
        $course = $this->courseHelper->getCourse($request->id);

        if ($course->mode_of_learning) {
            $course->mode_of_learning = json_decode($course->mode_of_learning);
        }

        if (old('category_id', $course->category_id)) {
            $old['category_id'] = $this->courseCategoryHelper->getCategoryWithTitle($course->category_id);
        }

        $coursesLocale = $this->courseHelper->getLocaleContents($request->id);
        $languages = $this->settingsHelper->getLanguages();
        $title = $coursesLocale['en']->first()->title;

        $seo = $this->seoHelper->getSeoByModelIdAndModel($course->id, 'Modules\Course\Entities\Course');

        $faq = $this->faqHelper->getFaqByCourseId($request->id) ?? null;


        return view('course::admin.course.editCourse', compact('course', 'faq', 'seo', 'languages', 'title', 'coursesLocale', 'breadcrumbs', 'old'));
    }

    public function updateCourse(Request $request)
    {
        $englishTitle = $request->input('title')['en'];
        $categoryId = $request->category_id;
        $courseId = $request->id;

        Validator::make($request->all(), [
            'title.en' => [
                'required',
                function ($attribute, $value, $fail) use ($courseId, $categoryId) {
                    $exists = Course::where('name', $value)
                        ->where('category_id', $categoryId)
                        ->where('id', '!=', $courseId)
                        ->exists();
                    if ($exists) {
                        $fail('A course with this name already exists in the selected category.');
                    }
                }
            ],
            'category_id' => 'required|integer|exists:course_categories,id'
        ])->validate();

        if ($request->has('category_id')) {
            $category = $this->courseHelper->getCategory($request->category_id);

            if ($category && $category->parent_category_id) {
                $parentCategoryId = $category->parent_category_id; // Parent category ID
                $categoryId = $category->id; // Current category ID
            } else {
                $parentCategoryId = null;
                $categoryId = $category ? $category->id : null;
            }
        } else {
            $categoryId = $request->parent_category_id ? $request->parent_category_id : null;
            $parentCategoryId = null;
        }

        $inputData = [
            'id' => $courseId,
            'name' => $englishTitle,
            'section' => 'web',
            'status' => $request->status,
            'category_id' => $categoryId,
            'parent_category_id' => $parentCategoryId,
            'pricing_format' => $request->pricing_format,
            'career_package' => $request->career_package,
            'popular_course' => $request->popular_course,
            'start_date' => $request->start_date,
            'started' => $request->started,
            'fee' => $request->pricing_format == 'free' ? 0 : ($request->fee ? $request->fee : 0),
            'language' => $request->language,
            'demo_video_url' => $request->demo_video_url,
            'featured' => $request->featured,
            'duration_type' => $request->duration_type,
            'duration' => $request->duration,
            'rating' => $request->rating ?? 1,
            'discount' => $request->discount,
            'discount_fee' => $request->discount_fee,
            'thumbnail_alt' => $request->thumbnail_alt,
            'image_title' => $request->image_title,
        ];

        $inputData['mode_of_learning'] = json_encode($request->mode_of_learning);

        if ($request->hasFile('thumbnail_picture')) {
            $filePath = 'course/image';
            $fileName = Storage::disk('elegant')->putFile($filePath, $request->file('thumbnail_picture'));
            $inputData['thumbnail_url'] = $fileName;
        } elseif ($request->thumbnail_picture_remove == 1) {
            $inputData['thumbnail_url'] = '';
        }

        if ($request->hasFile('curriculum_url')) {
            $filePath = 'course/curriculum';
            $fileName = Storage::disk('elegant')->putFile($filePath, $request->file('curriculum_url'));
            $inputData['curriculum_url'] = $fileName;
        } elseif ($request->has('curriculum_remove') && $request->curriculum_remove) {
            $inputData['curriculum_url'] = '';
        }

        if ($request->hasFile('brochure_url')) {
            $filePath = 'course/brochure';
            $fileName = Storage::disk('elegant')->putFile($filePath, $request->file('brochure_url'));
            $inputData['brochure_url'] = $fileName;
        } elseif ($request->has('brochure_url_remove') && $request->brochure_url_remove) {
            $inputData['brochure_url'] = '';
        }

        $course = $this->courseHelper->update($inputData);


        $data = [
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_contents' => $request->meta_contents,
            'model' => $request->model,
            'canonical_tag_url' => $request->canonical_tag_url,
            'model_id' => $course->id,
        ];

        if ($data['meta_title'] !== null || $data['meta_description'] !== null || $data['meta_contents'] !== null  || $data['canonical_tag_url'] !== null) {
            $this->seoHelper->customSave($data, $course);
        }

        if (isset($request->images) && $request->images) {
            $courseItemIds = [];
            if ($request->has('images')) {
                foreach ($request->images as $id => $file) {
                    $inputImageData = [
                        'id' => $id,
                        'course_id' => $course->id,
                        'image_path' => $file,
                    ];

                    $courseItem = $this->courseHelper->saveImage($inputImageData);
                    $courseItemIds[] = $courseItem->id;
                }
            }
            $this->courseHelper->deleteCourseImage($course->id, $notIn = $courseItemIds);
        }

        $languageCodes = array_keys($request->input('title'));

        foreach ($languageCodes as $languageCode) {
            $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);

            if ($languageId) {
                $title = $request->input('title')[$languageCode];

                $localeData = [
                    'language_id' => $languageId,
                    'course_id' => $course->id,
                    'title' => $title,
                    'short_description' => $request->input('short_desc')[$languageCode] ?? null,
                    'description' => $request->input('description')[$languageCode] ?? null,
                ];

                if (!empty($title)) {
                    $courseLocale = CourseLocale::where('course_id', $course->id)
                        ->where('language_id', $languageId)
                        ->first();

                    if ($courseLocale) {
                        $courseLocale->update($localeData);
                    } else {
                        $this->localHelper->saveCourseLocale($localeData);
                    }
                }
            }
        }

        activity()->performedOn($course)->event('Course Updated')->withProperties(['id' => $course->id, 'data' => $inputData])->log('Course Course Created');

        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_list', 'name' => 'Course', 'permission' => 'course_read'],
            ['name' => 'View Course'],
        ];
        $mainModuleCount = 0;

        return view('course::admin.course.viewCourse', compact('course', 'breadcrumbs', 'mainModuleCount'))->with('success', 'Course updated successfully');
    }

    public function deleteCourse(Request $request)
    {
        if ($this->courseHelper->delete($request->id)) {
            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'Course deleted successfully']);
            } else {
                return redirect()->route('course_list')->with('success', 'Course deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('course_list')->with('success', 'Failed to delete');
        }
    }

    public function courseOptions(Request $request)
    {
        $term = trim($request->search);
        $categories = $this->courseHelper->searchCourse($term);
        $categoriesOptions = [];

        foreach ($categories as $course) {
            $categoriesOptions[] = ['id' => $course->id, 'text' => $course->name];
        }

        return response()->json($categoriesOptions);
    }
    public function sectionWiseCategories(Request $request)
    {
        $term = trim($request->search);
        $categories = $this->courseHelper->searchSectionWiseCategory($term);
        $categoryOption = [];

        // Prepend default "No Parent" option
        $categoryOption[] = ['id' => ' ', 'text' => '-- No Parent (Make Root Category) --'];

        foreach ($categories as $category) {
            $categoryOption[] = ['id' => $category->id, 'text' => $category->name];
        }

        return response()->json($categoryOption);
    }

    public function optionsSubCategories(Request $request)
    {

        $categories = $this->courseHelper->getSubCategories($request->category_id);
        $categoryOption = [];

        foreach ($categories as $category) {
            $categoryOption[] = ['id' => $category->id, 'text' => $category->name];
        }

        return response()->json($categoryOption);
    }

    public function optionsSearchCourse(Request $request)
    {
        $term = trim($request->search);
        $courses = $this->courseHelper->searchCourse($term);
        $courseOption = [];

        foreach ($courses as $course) {
            $courseOption[] = ['id' => $course->id, 'text' => $course->title];
        }
        return response()->json($courseOption);
    }
    public function activeCourses(Request $request)
    {
        $term = trim($request->search);
        $categoryId = $request->category_id ? $request->category_id : null;
        $courses = $this->courseHelper->searchActiveCourse($term, $categoryId);
        $courseOption = [];

        foreach ($courses as $course) {
            $courseOption[] = ['id' => $course->id, 'text' => $course->title];
        }

        return response()->json($courseOption);
    }
    public function getCoursesFromCategory(Request $request)
    {
        $term = trim($request->search);
        $categoryId = $request->category_id;

        $query = $this->courseHelper->getCoursesFromCategory($categoryId, $term);

        return response()->json(
            $query->select('id', 'name as text')->limit(20)->get()
        );
    }


    public function saveSettings(Request $request)
    {
        try {
            $saveData = $request->all();

            if ($request->hasFile('thumbnail_url')) {
                $filePath = 'course/thumbnail';
                $fileName = Storage::disk('elegant')->putFile($filePath, $request->file('thumbnail_url'));
                $saveData['thumbnail_url'] = $fileName;
            } elseif ($request->image_remove == 1) {
                $saveData['thumbnail_url'] = '';
            }

            if ($request->hasFile('brochure_url')) {
                $filePath = 'course/brochure';
                $fileName = Storage::disk('elegant')->putFile($filePath, $request->file('brochure_url'));
                $saveData['brochure_url'] = $fileName;
            }

            if ($request->hasFile('demo_video_url')) {
                $video = $request->file('demo_video_url');
                $videoPath = 'course/video';
                $videoName = Storage::disk('elegant')->putFile($videoPath, $video);
                $saveData['demo_video_url'] = $videoName;
            }

            $this->courseHelper->update($saveData);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Course Settings updated successfully');
    }

    //     if ($zip->open($filePath) === true) {
    //         // Attempt to locate and extract the document.xml file
    //         if (($index = $zip->locateName('word/document.xml')) !== false) {
    //             $data = $zip->getFromIndex($index);

    //             // Load the document.xml file into a SimpleXML object
    //             $xml = new \SimpleXMLElement($data);

    //             // Register namespaces for the XML document
    //             $xml->registerXPathNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

    //             // Extract text from all <w:t> elements
    //             $textElements = $xml->xpath('//w:t');
    //             foreach ($textElements as $element) {
    //                 $text .= (string) $element . ' ';
    //             }
    //         }
    //         $zip->close();
    //     }

    //     return $text;
    // }

    public function optionsAllCategories()
    {
        $categories = $this->courseHelper->getAllCategories();
        $categoryOption = [];

        foreach ($categories as $category) {
            $categoryOption[] = ['id' => $category->id, 'text' => $category->name];
        }

        return response()->json($categoryOption);
    }


    public function listCourseCurriculum()
    {
        return view('course::admin.courseCurriculum.listCourseCurriculum');
    }

    public function listCourseCurriculumData(Request $request)
    {
        $curriculum = $this->courseHelper->getCurriculumDatatable($request->all());
        $dataTableJSON = DataTables::of($curriculum)
            ->addIndexColumn()
            ->editColumn('name', function ($curriculum) {
                return $curriculum->name;
            })

            ->editColumn('email', function ($curriculum) {
                return $curriculum->email;
            })

            ->editColumn('type', function ($curriculum) {
                return view('elements.listStatus')->with('data', $curriculum);
            })

            ->addColumn('created_at', function ($curriculum) {
                return $curriculum->created_at;
            })

            ->addColumn('action', function ($curriculum) use ($request) {
                $data['view_url'] = route('course_curriculum_detail', ['id' => $curriculum->id]);
                $data['delete_url'] = route('course_curriculum_delete', ['id' => $curriculum->id]);

                return '<div class="export-none">' . view('elements.listAction', compact('data')) . '</div>';
            })
            ->make();

        return $dataTableJSON;
    }

    public function courseCurriculumDetail(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_curriculum_list', 'name' => 'Curriculum'],
            ['name' => 'Course Curriculum Details'],
        ];
        $curriculum = $this->courseHelper->getCourseCurriculum($request->id);

        return view('course::admin.courseCurriculum.detailCourseCurriculum', compact('curriculum', 'breadcrumbs'));
    }

    public function deleteCourseCurriculum(Request $request)
    {
        $curriculum = $this->courseHelper->getCourseCurriculum($request->id);

        if ($this->courseHelper->deleteCourseCurriculum($request->id)) {

            if ($curriculum) {

                activity()->performedOn($curriculum)->event('curriculum Deleted')->withProperties(['curriculum_id' => $curriculum->id])->log('curriculum Deleted');

                return response()->json(['status' => 1, 'message' => 'curriculum deleted successfully']);
            } else {

                return redirect()->route('course_curriculum_list')->with('success', 'curriculum deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('enquiry_list')->with('success', 'Failed to delete');
        }
    }
}
