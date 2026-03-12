<?php

namespace Modules\Cms\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Entities\ContentCategory;
use Modules\Cms\Entities\ContentLocale;
use Modules\Cms\Entities\Language;
use Modules\Cms\Entities\Page;
use Modules\Cms\Entities\Content;
use Modules\Cms\Entities\ContentItem;
use Modules\Settings\Entities\Setting;

class ContentHelper
{
    public function getPageDatatable()
    {
        $pages = Page::select(app(Page::class)->getTable() . '.*')->with('content');

        return $pages;
    }

    public function getContents($data)
    {
        $contentsQuery = Content::select(app(Content::class)->getTable() . '.*')->with('locales', 'category');
        if (isset($data['contentSlug'])) {
            $contentsQuery->where('page_slug', $data['contentSlug']);
        }

        if (isset($data['categorySlug'])) {
            $contentsQuery->whereHas('contentCategory', function ($query) use ($data) {
                $query->where('slug', $data['categorySlug']);
            });
        }

        if (isset($data['status'])) {
            $contentsQuery->where('status', '=', $data['status']);
        }

        if (isset($data['course_id'])) {
            $contentsQuery->where('course_id',  $data['course_id']);
        }
        $contents = $contentsQuery->get();
        $contentsWithNames = $contents->map(function ($content) {
            $locale = $content->locales->firstWhere('language_id', 1);
            $content->name_for_language_1 = $locale ? $locale->name : 'Name not found';
            return $content;
        });
        return $contentsWithNames;

    }
    public function save(array $input)
    {
        if ($content = Content::create($input)) {
            return $content;
        }

        return false;
    }


    public function update($data)
    {
        $content = Content::find($data['id']);
        if ($content->update($data)) {
            return $content;
        }

        return false;
    }

    public function delete($id)
    {
        try {
            $content = Content::findOrFail($id);
            $content->delete();
            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getCategoryIdBySlug($slug)
    {
        return ContentCategory::where('slug', $slug)->value('id');
    }

    public function getCategorySlugById($id)
    {
        return ContentCategory::where('id', $id)->value('slug');
    }

    public function contentCount($id)
    {
        return Content::where('content_category_id', $id)->count();

    }

    public function getFieldsOfPage($slug)
    {
        $page = Page::where('slug', $slug)->first();

        if ($page) {
            return json_decode($page->fields, true);
        }

        return null;
    }

    public function getFieldsOfCategory($slug)
    {
        $content = ContentCategory::where('slug', $slug)->first();
        if ($content) {
            return json_decode($content->fields, true);
        }

        return null;
    }
    public function getContentIdFromSlug($slug)
    {
        return Content::where('slug', $slug)->pluck('id')->first();
    }

    /*
 |--------------------------------------------------------------------------
 | Dropzone
 |--------------------------------------------------------------------------
 */
    public function saveImage(array $input)
    {
        if (isset($input['id']) && $input['id']) {
            $galleryImage = ContentItem::find($input['id']);
            $galleryImage->update($input);

            return $galleryImage;
        } elseif ($galleryImage = ContentItem::create($input)) {
            return $galleryImage;
        }

        return false;
    }

    public function get($id)
    {
        return Content::find($id);
    }

    public function getLocaleContents($id)
    {
        $contentLocales = ContentLocale::where('content_id', $id)->get();
        $languageCodes = Language::pluck('code', 'id');

        $groupedContentLocales = $contentLocales->groupBy(function ($contentLocale) use ($languageCodes) {
            return $languageCodes[$contentLocale->language_id];
        });
        return $groupedContentLocales;
    }

    public function getContentsLocale($id)
    {
        $contentLocales = ContentLocale::where('content_id', $id)->get();

        return $contentLocales;
    }

    public function getGalleryItem($id)
    {
        return ContentItem::find($id);
    }

    public function deleteContentImage($id, $fileName)
    {
        ContentItem::where('id', $id)->where('image_path', $fileName)->delete();
    }

    public function deleteImage($contentId, $notInIds)
    {
        $items = ContentItem::whereNotIn('id', $notInIds)->where('content_id', $contentId)->get();

        foreach ($items as $item) {
            if (Storage::disk('elegant')->delete($item->image_path)) {
                $item->delete();
            }
        }
    }

    public function updateContentItems(array $input)
    {
        $contentItem = ContentItem::find($input['id']);
        unset($input['id']);

        if ($contentItem->update($input)) {
            return $contentItem;
        }

        return false;
    }

    public function getContentByKey()
    {
        return Content::where('status', 'active')->with('items', 'locales', 'defaultLocale')->get()->keyBy('slug');
    }

    public function getContentFromCategoryId($id)
    {
        return Content::with('items')->where('content_category_id', $id)->get();
    }

    public function getBySlugs($slugs)
    {
        return Content::whereIn('slug', $slugs)->get()->keyBy('slug');
    }

    public function getContentByPageSlug($slug)
    {
        return Content::with('items')->where('page_slug', $slug)->get()->keyBy('slug');
    }

    public function getAllLanguages()
    {
        $languageSettings = Setting::where('category', 'store')
            ->whereIn('key', ['ar', 'sp', 'fr', 'en'])
            ->get();

        $checkedLanguages = $languageSettings->filter(function ($setting) {
            return $setting->value === 'checked';
        })->map(function ($setting) {
            return $setting->key;
        })->toArray();

        if (!in_array('en', $checkedLanguages)) {
            $checkedLanguages[] = 'en';
        }

        $languages = Language::whereIn('code', $checkedLanguages)->get();

        return $languages;
    }

    public function getAllTestimonials()
    {
        $testimoialId = ContentCategory::where('slug', 'testimonials')->pluck('id')->first();

        return Content::where('content_category_id', $testimoialId)->where('status', 'active')->with('locales','defaultLocale', 'items')->where('status', 'active')->get();
    }

    public function getCourseTestimonials($courseId)
    {
        $testimoialId = ContentCategory::where('slug', 'testimonials')->pluck('id')->first();

        return Content::where('content_category_id', $testimoialId)->where('status', 'active')->where('course_id', $courseId)->with('locales','defaultLocale', 'items')->get();
    }

    public function getTrainingCourses()
    {
        $testimoialId = ContentCategory::where('slug', 'corporate-training-course')->pluck('id')->first();

        return Content::where('content_category_id', $testimoialId)->where('status', 'active')->with('locales', 'defaultLocale','items')->get();
    }

    public function getHeaderFeatureCourses()
    {
        $feature = ContentCategory::where('slug', 'banner-features')->pluck('id')->first();

        return Content::where('content_category_id', $feature)->where('status', 'active')->with('locales','defaultLocale','course', 'items')->get();
    }
    public function getCourseFeatures($id)
    {
        $category_id = ContentCategory::where('slug', 'feature')->pluck('id')->first();
        $contents = Content::where('content_category_id', $category_id)
            ->where('course_id', $id)->where('status', 'active')
            ->with('locales', 'defaultLocale')
            ->get();
        if ($contents) {
            return $contents;
        } else {
            return null;
        }
    }

    public function courseJoinNow($id)
    {
        $category_id = ContentCategory::where('slug', 'join-now-for-course')->pluck('id')->first();
        $contents = Content::where('content_category_id', $category_id)
            ->where('course_id', $id)->where('status', 'active')
            ->with('locales', 'defaultLocale')
            ->first();
        if ($contents) {
            return $contents;
        } else {
            return null;
        }
    }
    public function getYoutubeVideos()
    {
        $testimoialId = ContentCategory::where('slug', 'channel-videos')->pluck('id')->first();

        return Content::where('status', 'active')->where('content_category_id', $testimoialId)->with('locales', 'items')->get();
    }

    public function getMilestones()
    {
        $testimoialId = ContentCategory::where('slug', 'major-milestones')->pluck('id')->first();

        return Content::where('content_category_id', $testimoialId)->where('status', 'active')->with('locales', 'items')->get();
    }

    public function getContactInformation()
    {
        $contactId = ContentCategory::where('slug', 'contact-information')->pluck('id')->first();

        return Content::where('content_category_id', $contactId)->where('status', 'active')->with('locales', 'items')->get();
    }

    public function getCourseCompanies($courseId)
    {
        $companyId = ContentCategory::where('slug', 'top-companies-hiring')->pluck('id')->first();
        return Content::where('content_category_id', $companyId)->where('status', 'active')->where('course_id', $courseId)->with('locales','defaultLocale', 'items')->first();
    } 

    public function getPageSlugs(){
        return Page::pluck('slug');
    }

}
