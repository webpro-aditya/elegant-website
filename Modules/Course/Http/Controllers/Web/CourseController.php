<?php

namespace Modules\Course\Http\Controllers\Web;

use App\Events\EnquiryReceived;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Course\Helpers\Web\CourseHelper;
use Modules\Course\Helpers\Web\CurriculumHelper;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Faq\Helpers\FaqHelper;
use Modules\Enquiry\Helpers\Web\EnquiryHelper;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Translation\Helpers\TranslationHelper;
use App\Jobs\SendEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Modules\Course\Entities\CourseSlugHistory;

class CourseController extends Controller
{
    protected $courseHelper;
    protected $contentHelper;
    protected $faqHelper;
    protected $enquiryHelper;
    protected $settingsHelper;
    protected $curriculumHelper;
    protected $translationHelper;
    protected $cmsHelper;


    public function __construct(
        ContentHelper $cmsHelper,
        CourseHelper $courseHelper,
        ContentHelper $contentHelper,
        FaqHelper $faqHelper,
        EnquiryHelper $enquiryHelper,
        SettingsHelper $settingsHelper,
        TranslationHelper $translationHelper,
        CurriculumHelper $curriculumHelper

    ) {
        $this->courseHelper = $courseHelper;
        $this->contentHelper = $contentHelper;
        $this->cmsHelper = $cmsHelper;
        $this->faqHelper = $faqHelper;
        $this->enquiryHelper = $enquiryHelper;
        $this->settingsHelper = $settingsHelper;
        $this->translationHelper = $translationHelper;
        $this->curriculumHelper = $curriculumHelper;
    }

    public function courseList(Request $request, $locale, $categorySlug = null)
    {
        $categories = $this->courseHelper->getCategoryHasCourse();

        $categoryId = null;
        if ($categorySlug) {
            $categoryId = $this->courseHelper->getIdFromCategorySlug($categorySlug);
        }

        $contents = $this->cmsHelper->getContentByKey();

        return view('course::web.course.courseList', compact('categories', 'categoryId', 'contents'));
    }

    public function courseCard(Request $request)
    {
        $formData = $request->all();
        $categoryIds = $request->input('categories', []); // Retrieve the category IDs from the request
        $search = $request->input('search'); // Retrieve the category IDs from the request
        $formData['offset'] = ($request['page'] - 1) * $request['limit'];
        $listCourses = $this->courseHelper->getCoursesWhereInCategory($categoryIds, $search, $formData);
        $courses = $listCourses['courses'];
        $listAvailable = $listCourses['totalCount'];

        $response['listAvailable'] = $listAvailable;
        $response['totalCourse'] = count($courses);

        $fetched = $formData['offset'] + count($courses); // count actual fetched courses
        if ($listAvailable > $fetched) {
            $response['more'] = true;
        } else {
            $response['more'] = false;
        }
        $response['fetched'] = $fetched;
        $response['page'] = $formData['page'];
        $response['limit'] = $formData['limit'];
        $response['view'] = (string) view('course::web.course.include.courses', compact('courses'));
        return response()->json($response); // Ensure the response is returned as JSON
    }



    public function courseDetail($locale, $course)
    {
        $courseData = $this->courseHelper->getCourseFromSlug($course);

        if (!$courseData) {
            $oldSlug = CourseSlugHistory::where('slug', $course)->first();
            if ($oldSlug && $oldSlug->course) {
                return redirect()->route('web_course_detail', [
                    'locale' => $locale,
                    'course' => $oldSlug->course->slug,
                ], 302);
            }
            abort(404);
        }

        $syllubuses = $this->courseHelper->getCourseSyllubus($courseData->id);
        $features = $this->contentHelper->getCourseFeatures($courseData->id);
        $contents = $this->contentHelper->getContentByKey();
        $testimonials = $this->contentHelper->getCourseTestimonials($courseData->id);
        $faqs = $this->faqHelper->getFaqsByCourseId($courseData->id);
        $joinNow = $this->contentHelper->courseJoinNow($courseData->id);
        $locations = $this->contentHelper->getContactInformation();
        $codes = $this->settingsHelper->getCodes();
        $translations = $this->translationHelper->getKeyValue();
        $countries = $this->settingsHelper->getAllCountry();
        $companies = $this->contentHelper->getCourseCompanies($courseData->id);
        return view('course::web.course.courseDetail', compact('contents', 'locations', 'joinNow', 'faqs', 'codes', 'testimonials', 'courseData', 'syllubuses', 'features', 'translations', 'countries', 'companies'));
    }

    public function searchCourse(Request $request)
    {
        $courses = $this->courseHelper->getSuggestedCourse($request->text);

        return $courses;
    }


    public function trainingCalender(Request $request)
    {

        return view('course::web.training-calender.training-calender');
    }

    public function selfPaced(Request $request)
    {

        return view('course::web.self-paced.self-paced');
    }

    public function orderSummary(Request $request)
    {
        return view('course::web.course.orderSummary');
    }

    public function calender(Request $request)
    {
        $courses = $this->courseHelper->getCalenderCourses();
        $codes = $this->settingsHelper->getCodes();
        $translations = $this->translationHelper->getKeyValue();
        $countries = $this->settingsHelper->getAllCountry();

        return view('course::web.training-calender.training-calender', compact('courses', 'countries', 'codes', 'translations'));
    }
    public function saveCourseEnquiry(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email',
            'number' => 'required',
            'message' => 'required',
        ]);
        
        $inputData = [
            'name' => $request->name ?? 'no name',
            'email' => $request->email ?? 'no email',
            'phone' => $request->number ?? 'no phone',
            'message' => $request->message ?? 'no message',
            'country_code' => $request->country_code,
            'course_id' => $request->courseId ?? 0,
            'type' => $request->type ?? 'type not given',
            'subject' => $request->subject ?? 'no subject',
            'location_id' => $request->location_id ?? 0,
            'section' => 'web'
        ];

        $enquiryData = $this->enquiryHelper->save($inputData);
        $data = $enquiryData->toArray();
        $courseName = null;
        if (!empty($enquiryData->course_id)) {
            $course = $this->courseHelper->get($enquiryData->course_id);

            $courseName = $course->defaultLocale->title ?? null;
            $data['course_name'] = $courseName;
        }

        try {
            event(new EnquiryReceived((object) $data));

        } catch (\Exception $e) {
            Log::error('Mail Issue : ' . $e);
        }

        if ($request->type == 'course_brochure') {
            $brochurePath = Storage::disk('elegant')->path($course->brochure_url);
            return response()->download($brochurePath);
        }
        
        return view('course::web.thank-you');

        // return redirect()->back()->with('success', 'Your Enquiry has been saved!');
    }

    public function courseFinder(Request $request)
    {
        return view('course::web.course.courseFinder');
    }

    public function saveCourseCurriculm(Request $request)
    {
        $inputData = [
            'name' => $request->name ?? 'no name',
            'email' => $request->email ?? 'no email',
            'phone' => $request->number ?? 'no phone',
            'message' => $request->message ?? 'no message',
            'country_code' => $request->country_code,
            'course_id' => $request->courseId ?? 0,
            'type' => $request->type ?? 'type not given',
            'subject' => $request->subject ?? 'no subject',
            'location_id' => $request->location_id ?? 0,
            'section' => 'web'
        ];

        try {
            $curriculum = $this->curriculumHelper->save($inputData);
            $course = $this->courseHelper->get($request->courseId);

            $user_data_array = [
                'email' => $request->email,
                'curriculum_id' => $curriculum->id,
                'company_name' => $this->settingsHelper->getByKey('company_name_en')->value,
                'mail_from_address' => $this->settingsHelper->getByKey('mail_from_address')->value,
                'course' => $course,
                'curriculum' => $curriculum,
            ];

            if (!empty($user_data_array['mail_from_address'])) {
                $adminEmail = $this->settingsHelper->getByKey('email')->value;

                SendEmail::dispatch($user_data_array, $request->email, 'send_curriculum_download_email')
                    ->delay(now()->addSeconds(10))
                    ->afterResponse();

                SendEmail::dispatch($user_data_array, $adminEmail, 'send_curriculum_admin_email')
                    ->delay(now()->addSeconds(12))
                    ->afterResponse();
            }

            $filePath = Storage::disk('elegant')->path($course->curriculum_url);

            return response()->download($filePath, 'curriculum.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing your request. Please try again later.');
        }
    }
}
