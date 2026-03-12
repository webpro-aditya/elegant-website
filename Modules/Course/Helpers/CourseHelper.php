<?php

namespace Modules\Course\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Modules\Cms\Entities\Language;
use Modules\Course\Entities\CalenderLocal;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseCategory;
use Modules\Course\Entities\CourseItem;
use Modules\Course\Entities\CourseLocale;
use Modules\Course\Entities\Title;
use Modules\Enquiry\Entities\Enquiry;
use Illuminate\Support\Facades\Storage;
use Modules\Course\Entities\Curriculum;
use Modules\Settings\Entities\Country;

class CourseHelper
{
    protected $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    /*
    |--------------------------------------------------------------------------
    | CRUD FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function save(array $input)
    {
        if ($category = $this->course->create($input)) {
            return $category;
        }

        return false;
    }

    public function getCoursesFromCategory($categoryId, $term)
    {
        return Course::query()
            ->where('status', 'active')
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->when($term, function ($q) use ($term) {
                $q->where('name', 'like', '%' . $term . '%');
            });
    }




    public function delete($categoryId)
    {
        try {
            $category = $this->course->findOrFail($categoryId);
            $category->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function update($data)
    {
        $category = $this->course->find($data['id']);

        if ($category->update($data)) {
            return $category;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getCourseDatatable($data)
    {
        return Course::query()
            ->when(!empty($data['status']), function ($query) use ($data) {
                return $query->where('status', $data['status']);
            })
            ->when(!empty($data['category_id']), function ($query) use ($data) {
                return $query->where('category_id', $data['category_id']);
            })
            ->orderBy('created_at', 'desc')->get();
    }

    public function getCourse($id)
    {
        $englishId = Language::where('code', 'en')->pluck('id')->first();

        $course = Course::with([
            'locales' => function ($query) use ($englishId) {
                $query->where('language_id', $englishId);
            },
            'categories.locales' => function ($query) use ($englishId) {
                $query->where('language_id', $englishId);
            }
        ])->find($id);

        if ($course && $course->locales->isNotEmpty()) {
            $course->english_title = $course->locales->first()->title;
        } else {
            $course->english_title = null;
        }

        if ($course && $course->categories && $course->categories->locales->isNotEmpty()) {
            $course->english_category_title = $course->categories->locales->first()->title;
        } else {
            $course->english_category_title = null;
        }


        return $course;
    }

    public function getCourseAndTitle($id)
    {
        $englishId = Language::where('code', 'en')->pluck('id')->first();

        $course = Course::with([
            'locales' => function ($query) use ($englishId) {
                $query->where('language_id', $englishId);
            }
        ])->find($id);

        if ($course && $course->locales->isNotEmpty()) {
            $englishTitle = $course->locales->first()->title;
            return (object) [
                'id' => $course->id,
                'title' => $englishTitle,
                'categories' => $course->categories,
            ];
        }
        return null;
    }

    public function getAllCourse()
    {
        return $this->course->all();
    }

    public function getAllLatestCourse()
    {
        $englishId = Language::where('code', 'en')->pluck('id')->first();

        $courses = $this->course->with('defaultLocale')->where('status', 'publish')
            ->with([
                'locales' => function ($query) {
                    $query->latest();
                }
            ])
            ->withCount('syllabuses')
            ->get();

        // Iterate over each course to set the English title
        foreach ($courses as $course) {
            $englishLocale = $course->locales->where('language_id', $englishId)->first();
            $course->english_title = $englishLocale ? $englishLocale->title : null;
        }

        return $courses;
    }





    /*
    |--------------------------------------------------------------------------
    | ADDITIONAL FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getCategory($category_id)
    {
        return CourseCategory::with(['course'])->findOrFail($category_id);
    }


    public function searchCourse($keyword)
    {
        $courses = $this->course::where('title', 'like', "%{$keyword}%");

        return $courses->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function searchCategory($keyword)
    {
        $categories = $this->course->where('title', 'like', "%{$keyword}%");

        return $categories->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function searchSectionWiseCategory($keyword)
    {
        $englishId = Language::where('code', 'en')->pluck('id')->first();

        $courses = CourseCategory::whereNull('parent_category_id')
            ->whereHas('locales', function ($query) use ($keyword, $englishId) {
                $query->where('language_id', $englishId)
                    ->where('title', 'like', "%{$keyword}%");
            })
            ->with([
                'locales' => function ($query) use ($englishId) {
                    $query->where('language_id', $englishId);
                }
            ])
            ->paginate(30, ['*'], 'page', request()->get('page'));

        $courses->getCollection()->transform(function ($course) {
            $locale = $course->locales->first();
            $course->name = $locale ? $locale->title : 'Title not found';
            return $course;
        });

        return $courses;
    }

    public function getCourseByCategory($id)
    {
        return $this->course->where('category_id', $id)->get();
    }

    public function searchActiveCourse($keyword, $categroyId = null)
    {
        $englishId = Language::where('code', 'en')->pluck('id')->first();

        $courses = Course::whereHas('locales', function ($query) use ($keyword, $englishId) {
            $query->where('language_id', $englishId)
                ->where('title', 'like', "%{$keyword}%");
        })
            ->when($categroyId, function ($query) use ($categroyId) {
                $query->where('category_id', $categroyId);
            })
            ->byStatus(['publish', 'draft'])
            ->select('courses.id', 'course_locales.title')
            ->join('course_locales', function ($join) use ($keyword) {
                $join->on('courses.id', '=', 'course_locales.course_id')
                    ->where('course_locales.language_id', 1)
                    ->where('course_locales.title', 'like', "%{$keyword}%");
            })
            ->paginate(30, ['*'], 'page', request()->get('page'));

        return $courses;
    }


    public function getMostRepeatedCourses()
    {
        $today = now()->toDateString();

        $mostRepeatedCourses = Enquiry::select('course_id', DB::raw('count(*) as count'))
            ->whereDate('created_at', $today)
            ->groupBy('course_id')
            ->orderByDesc('count')
            ->take(3)
            ->get();

        $coursesData = [];
        $enquiryThreshold = 10; // Define your threshold value here

        foreach ($mostRepeatedCourses as $course) {
            $courseDetails = Course::select('id', 'title', 'mode_of_learning', 'course_format')
                ->where('id', $course->course_id)
                ->first();

            if ($courseDetails) {
                $enquiryStatus = $course->count > $enquiryThreshold ? 'high' : 'normal';
                $modesOfLearning = json_decode($courseDetails->mode_of_learning, true);

                $coursesData[] = [
                    'id' => $courseDetails->id,
                    'title' => $courseDetails->title,
                    'mode_of_learning' => $modesOfLearning,
                    'course_format' => $courseDetails->course_format,
                    'enquiry_count' => $course->count,
                    'enquiry_status' => $enquiryStatus, // Include the enquiry status (high/normal)
                ];
            }
        }

        return $coursesData;
    }

    public function getSubCategories($id)
    {
        $categories = CourseCategory::where('parent_category_id', $id);

        return $categories->paginate(config('app.select_options_count'), ['*'], 'page', request()->get('page'));
    }

    public function getLocaleContents($id)
    {
        $contentLocales = CourseLocale::where('course_id', $id)->get();

        $languageCodes = Language::pluck('code', 'id');

        $groupedContentLocales = $contentLocales->groupBy(function ($contentLocale) use ($languageCodes) {
            return $languageCodes[$contentLocale->language_id];
        });

        return $groupedContentLocales;
    }
    public function getTitles()
    {
        $titles = Title::with('language')->get();

        return $titles;
    }


    public function getCalenderLocal($id)
    {
        $contentLocales = CalenderLocal::where('calander_id', $id)->get();

        $languageCodes = Language::pluck('code', 'id');

        $groupedContentLocales = $contentLocales->groupBy(function ($contentLocale) use ($languageCodes) {
            return $languageCodes[$contentLocale->language_id];
        });

        return $groupedContentLocales;
    }

    public function saveImage(array $input)
    {
        if (isset($input['id']) && $input['id']) {
            $galleryImage = CourseItem::find($input['id']);
            $galleryImage->update($input);

            return $galleryImage;
        } elseif ($galleryImage = CourseItem::create($input)) {
            return $galleryImage;
        }

        return false;
    }

    public function getGalleryItem($id)
    {
        return CourseItem::find($id);
    }

    public function deleteCourseImage($id, $fileName)
    {
        CourseItem::where('id', $id)->where('image_path', $fileName)->delete();
    }

    public function deleteImage($contentId, $notInIds)
    {
        $items = CourseItem::whereNotIn('id', $notInIds)->where('content_id', $contentId)->get();

        foreach ($items as $item) {
            if (Storage::disk('elegant')->delete($item->image_path)) {
                $item->delete();
            }
        }
    }

    public function updateCourseItems(array $input)
    {
        $CourseItem = CourseItem::find($input['id']);
        unset($input['id']);

        if ($CourseItem->update($input)) {
            return $CourseItem;
        }

        return false;
    }

    public function getCurriculumDatatable($data)
    {
        $curriculum = Curriculum::select(app(Curriculum::class)->getTable() . '.*');

        if (isset($data['type'])) {
            $curriculum->where('type', $data['type']);
        }

        if (isset($data['course_id'])) {
            $curriculum->where('course_id', $data['course_id']);
        }

        $curriculum->orderBy('created_at', 'desc');

        return $curriculum;
    }

    public function getCourseCurriculum($id)
    {
        return Curriculum::where('id', $id)->first();
    }

    public function deleteCourseCurriculum($Id)
    {
        try {
            $curriculum = Curriculum::findOrFail($Id);
            $curriculum->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }
}
