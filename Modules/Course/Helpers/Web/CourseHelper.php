<?php

namespace Modules\Course\Helpers\Web;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Cms\Entities\ContentCategory;
use Modules\Cms\Entities\Language;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseCategory;
use Modules\Course\Entities\MainModule;
use Modules\Course\Entities\Syllabus;
use Modules\Course\Entities\SyllabusLocal;
use Modules\Course\Entities\TrainingCalendar;
use Modules\Course\Entities\Venue;

class CourseHelper
{
    public function getCourseCategory()
    {
        return CourseCategory::with('course', 'defaultLocale')->where('status', 'active')->get();
    }

    public function getCategoryHasCourse()
    {
        return CourseCategory::whereHas('course', function ($query) {
            $query->where('status', 'publish');
        })->get()->sortBy(fn($category) => strtolower($category->defaultLocale->title))
        ->values();;
    }

    public function getOfflineCategory()
    {
        return CourseCategory::whereHas('course', function ($query) {
                $query->whereJsonContains('mode_of_learning', 'offline')
                    ->where('status', 'publish');
            })
            ->with(['course.defaultLocale'])
            ->where('status', 'active')
            ->get()
            ->sortBy(fn($category) => strtolower($category->defaultLocale->title))
            ->values();
    }

    public function getWholeCategory()
    {
        return CourseCategory::whereHas('course', function ($query) {
            $query->where('status', 'publish');
        })->with(['course.defaultLocale'])->get();
    }


    public function getOnlineCategory()
    {
        return CourseCategory::whereHas('course', function ($query) {
            $query->whereJsonContains('mode_of_learning', 'online')
                ->where('status', 'publish');
        })->with(['course.defaultLocale'])->get();
    }

    public function getCourseFromSlug($slug)
    {
        return Course::where('slug', $slug)->with('locales', 'items', 'defaultLocale', 'batches', 'syllabuses', 'seo')->first();
    }

    public function getCourseSyllubus($id)
    {
        $defaultLanguageId = Language::where('code', config('app.locale'))->value('id');

        return SyllabusLocal::with(['mainContent' => function ($query) {
            $query->select('id', 'course_id', 'sort_order'); // Ensure sort_order is selected
        }, 'mainContent.defaultLocale', 'language'])
            ->whereHas('mainContent', function ($query) use ($id) {
                $query->where('course_id', $id);
            })
            ->where('language_id', $defaultLanguageId)
            ->get()
            ->sortBy(function ($item) {
                return $item->mainContent->sort_order;
            })
            ->groupBy(function ($item) {
                return $item->mainContent->defaultLocale->title;
            });
    }


    public function getAllCourses()
    {
        return Course::orderBy('created_at', 'desc')
            ->where('status', 'publish')->get();
    }

    public function getDurations($type)
    {
        return Course::where('duration_type', $type)
            ->orderBy('duration', 'asc')
            ->pluck('duration');
    }

    public function getYearsOfCalender()
    {
        return TrainingCalendar::distinct()
            ->select(DB::raw('YEAR(start_date) as year'))
            ->orderBy('year', 'asc')
            ->pluck('year');
    }

    public function getYears()
    {
        return Course::distinct()
            ->select(DB::raw('YEAR(start_date) as year'))
            ->orderBy('year', 'asc')
            ->pluck('year');
    }

    public function getIdFromCategorySlug($slug)
    {
        return CourseCategory::whereSlug($slug)->first()->id;
    }

    public function getElearning()
    {
        return Course::where('mode_of_learning', 'online')->get();
    }

    public function getIdFromCourseSlug($slug)
    {
        return Course::whereSlug($slug)->first()->id;
    }

    public function getCategoryCourse($id)
    {
        return Course::with('venues', 'categories')->where('category_id', $id)->get();
    }

    public function getCourse($id)
    {
        return Course::with('venues', 'categories')->where('id', $id)->first();
    }

    public function getCalenderFromCourse($id)
    {
        return TrainingCalendar::with('venues', 'courses')->where('course_id', $id)->get();
    }

    public function getAllVenues()
    {
        return Venue::with('course')->with('status', 'active')->get();
    }

    public function getSuggestedCourse($term)
    {
        $data['search_text'] = $term;
        $course = Course::with(['locales'])->where('status', 'publish');

        if (!empty($data['search_text'])) {
            $searchTerms = explode(' ', $data['search_text']);

            $course = $course->where(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->orWhereHas('locales', function ($query) use ($term) {
                        $query->where('title', 'like', "%{$term}%");
                    });
                }
            });
        }

        $courses = $course->select('id', 'slug')->get();

        return $courses->map(function ($course) {
            return [
                'id' => $course->id,
                'slug' => $course->slug,
                'title' => $course->title,
                'link' => route('web_course_detail', ['course' => $course->slug, 'locale' => app()->getLocale()])
            ];
        })->toArray();
    }

    public function getMainModules($id)
    {
        return Syllabus::where('course_id', $id)->get();
    }

    public function getCalender($id)
    {
        return TrainingCalendar::where('id', $id)->first();
    }

    public function getCalenderCourses()
    {
        $trainings = TrainingCalendar::where('start_date', '>=', Carbon::today())
            ->with('courses.defaultLocale', 'defaultLocale') // Load the related course details
            ->orderBy('start_date')
            ->get()
            ->groupBy('course_id');

        return $trainings;
    }

    public function getTopCourseCategories($limit = 10)
    {
        $categories = CourseCategory::with(['course' => function ($query) {
            $query->orderBy('created_at', 'desc'); // Example ordering for courses within categories
        }])
            ->withCount('course')
            ->has('course')
            ->orderByDesc('course_count')
            ->take($limit)
            ->get();
        return $categories;
    }

    public function getPopularCourses($limit = 10)
    {
        $courses = Course::where('popular_course', 'yes')
            ->where('status', 'publish')
            ->limit($limit)
            ->get();

        return $courses;
    }


    public function get($id)
    {
        return Course::where('id', $id)->first();
    }
    public function getCoursesWhereInCategory($categoryIds, $search, $data)
    {
        $offset = ($data['page'] - 1) * $data['limit'];

        $query = Course::orderBy('name', 'asc')->with('defaultLocale', 'categories')
            ->where('status', 'publish');

        if (!empty($categoryIds)) {
            $query->whereIn('category_id', $categoryIds);
        }

        if (!empty($search)) {
            $locale = config('app.locale');
            $languageId = config("app.local_languages.$locale");

            $query->whereHas('locales', function ($query) use ($search, $languageId) {
                $query->where('language_id', $languageId)
                    ->where('title', 'like', "%{$search}%");
            });
        }

        // Clone the query to get total count before pagination
        $totalCount = (clone $query)->count();

        $courses = $query->offset($offset)->limit($data['limit'])->get();

        return ['courses' => $courses, 'totalCount' => $totalCount];
    }
}
