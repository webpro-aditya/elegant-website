<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Entities\ContentLocale;
use Modules\Cms\Entities\Language;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Settings\Helpers\SettingsHelper;
use Yajra\DataTables\DataTables;
use Modules\Cms\Http\Controllers\Admin\Includes\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Http\Requests\Admin\Contents\ContentAddRequest;
use Modules\Cms\Http\Requests\Admin\Contents\ContentCreateRequest;
use Modules\Cms\Http\Requests\Admin\Contents\ContentDeleteRequest;
use Modules\Cms\Http\Requests\Admin\Contents\ContentEditRequest;
use Modules\Cms\Http\Requests\Admin\Contents\ContentListDataRequest;
use Modules\Cms\Http\Requests\Admin\Contents\ContentListRequest;
use Modules\Cms\Http\Requests\Admin\Contents\ContentUpdateRequest;
use Modules\Cms\Http\Requests\Admin\Pages\PagesViewRequest;
use Modules\Seo\Helpers\SeoHelper;
use Modules\Course\Helpers\CourseHelper;

class CmsController extends Controller
{
    use Image;

    protected $contentHelper;

    protected $settingsHelper;

    protected $seoHelper;

    protected $courseHelper;

    public function __construct(ContentHelper $contentHelper, SettingsHelper $settingsHelper, SeoHelper $seoHelper, CourseHelper $courseHelper)
    {
        $this->contentHelper = $contentHelper;
        $this->settingsHelper = $settingsHelper;
        $this->seoHelper = $seoHelper;
        $this->courseHelper = $courseHelper;
    }
    public function listPages(PagesViewRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Pages'],
        ];

        return view('cms::admin.pages.listPage', compact('breadcrumbs'));
    }

    public function pageListData(PagesViewRequest $request)
    {
        $pages = $this->contentHelper->getPageDatatable();
        $dataTableJSON = DataTables::of($pages)
            ->addIndexColumn()
            ->editColumn('name', function ($page) {
                $data['url'] = route('contents_view', ['slug' => $page->slug]);
                $data['text'] = $page->title;
                return view('elements.listLink', compact('data'));
            })

            ->addColumn('action', function ($page) use ($request) {
                $data['view_url'] = route('contents_view', ['slug' => $page->slug]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }

    public function view(ContentListRequest $request)
    {
        $slug = '';
        $category = '';
        $title = '';
        if ($request->slug) {
            $slug = $request->slug;
            $category = null;
            $title = ucfirst($slug) ?? 'Content';
        } else if ($request->category) {
            $slug = null;
            $category = $request->category;
            $title = ucfirst($category) ?? 'Content';
        }
        $slugsArray = $this->contentHelper->getPageSlugs();

        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => "$title"],
        ];

        return view('cms::admin.contents.listContent', compact('breadcrumbs', 'slug', 'category', 'slugsArray', 'title'));
    }

    public function contentsTable(ContentListDataRequest $request)
    {
        $contents = $this->contentHelper->getContents($request->all());
        $slugs = $this->contentHelper->getPageSlugs();

        $dataTable = DataTables::of($contents)
            ->addIndexColumn()
            ->addColumn('name', function ($content) {
                $data['url'] = route('contents_edit', ['id' => $content->id]);
                $data['text'] = $content->name_for_language_1;
                return view('elements.listLink', compact('data'));
            });

        // ✅ Add Course column only for testimonials
        if ($request->categorySlug === 'testimonials') {
            $dataTable->addColumn('course', function ($content) {
                return $content->course ? $content->course->title : '-';
            });
        }

        $dataTable->addColumn('status', function ($content) {
            return view('elements.listStatus')->with('data', $content);
        })
            ->addColumn('action', function ($content) use ($request, $slugs) {
                $data['view_url'] = route('contents_details', ['id' => $content->id]);
                $data['edit_url'] = route('contents_edit', ['id' => $content->id]);
                if (!$slugs->contains($request['contentSlug'])) {
                    $data['delete_url'] = $content->is_deletable == 1 ? route('contents_delete', ['id' => $content->id]) : '';
                }
                return view('elements.listAction', compact('data'));
            });

        return $dataTable->make();
    }

    public function add(ContentAddRequest $request)
    {
        $fields = [];
        if (isset($request->category)) {
            $categorySlug = $request->category;
            $categoryId = $this->contentHelper->getCategoryIdBySlug($categorySlug);
            $fields = $this->contentHelper->getFieldsOfCategory($categorySlug);
        } else {
            $categorySlug = 'default';
            $categoryId = $this->contentHelper->getCategoryIdBySlug('default');
        }

        $slug = $request->slug ? $request->slug : '';

        $title = ucfirst($slug) ?? 'Content';

        if ($request->slug) {
            $slug = $request->slug;
            $fields = $this->contentHelper->getFieldsOfPage($slug);
        }

        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'contents_view', 'name' => 'Contents', 'permission' => 'contents_update'],
            ['name' => 'Add Content'],
        ];

        $languages = $this->settingsHelper->getLanguages();

        return view('cms::admin.contents.addContent', compact('breadcrumbs', 'fields', 'slug', 'title', 'categoryId', 'categorySlug', 'languages'));
    }

    public function save(Request $request)
    {
        $data = [];
        $slug = $request->slug != null ? $request->slug : Str::slug($request->title);

        $data = [
            'status' => $request->status,
            'link' => $request->link,
            'slug' => $slug,
            'content' => $request->content,
            'content_category_id' => $request->content_category_id ?? null,
            'page_slug' => $slug,
            'is_deltetable' => 1,
            'section' => 'web',
            'course_id' => $request->course_id ?? null,
            'thumbnail_alt' => $request->thumbnail_alt,
            'image_title' => $request->image_title,
            'email' => $request->email ?? null,
            'phone_number' => $request->phone_number ?? null,
        ];

        if ($request->hasFile('file')) {
            $filePath = 'contents/file';
            $fileName = Storage::disk('elegant')->putFile($filePath, $request->file('file'));
            $data['file'] = $fileName;
        }

        if ($request->hasFile('thumbnail')) {
            $filePath = 'contents/thumbnail';
            $data['thumbnail'] = Storage::disk('elegant')->putFile($filePath, $request->file('thumbnail'));
        } elseif ($request->has('thumbnail_remove') && $request->thumbnail_remove) {
            $data['thumbnail'] = '';
        }

        $content = $this->contentHelper->save($data);

        $data = [
            'name' => $request->input('name') ? $request->input('name') : $request->input('title'),
            'title' => $request->input('title'),
            'short_desc' => $request->input('short_desc'),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
        ];
        if ($request->input('name')) {
            $languageCodes = array_keys($request->input('name'));
            $title = $data['title'] ?? null;

            foreach ($languageCodes as $languageCode) {
                $languageId = Language::where('code', $languageCode)->value('id');
                if ($languageId) {
                    $name = $data['name'][$languageCode] ?? $title;
                    $contentData = [
                        'language_id' => $languageId,
                        'content_id' => $content->id,
                        'name' => $name,
                        'title' => $title,
                        'short_description' => $data['short_desc'][$languageCode] ?? null,
                        'description' => $data['description'][$languageCode] ?? null,
                        'content' => $data['content'][$languageCode] ?? null,
                    ];

                    ContentLocale::updateOrCreate(
                        ['language_id' => $languageId, 'content_id' => $content->id],
                        $contentData
                    );
                }
            }
        }
        if ($request->has('images')) {
            foreach ($request->images as $id => $file) {
                $inputImageData = [
                    'id' => $id,
                    'content_id' => $content->id,
                    'image_path' => $file,
                ];
                $this->contentHelper->saveImage($inputImageData);
            }
        }

        if ($request->filled('meta_title') && $request->filled('meta_description')) {
            $seoData = [
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_contents' => $request->meta_contents,
                'model' => $request->model,
                'model_id' => $content->id,
            ];
            $this->seoHelper->save($seoData);
        }

        $event = auth()->user()->name . ' Added the Content ';
        activity('Contents')->performedOn($content)->event($event)->withProperties(['content_id' => $content->id, 'data' => $request->all()])->log('Content Created');

        if ($request->filled('slug')) {
            return redirect()->route('contents_view', ['slug' => $content->page_slug])->with('success', 'Content added successfully');
        } else {
            return redirect()->route('contents_view', ['category' => $request->content_category_slug])->with('success', 'Content added successfully');
        }
    }
    public function editSection(Request $request)
    {
        $id = $this->contentHelper->getContentIdFromSlug($request->category);
        return redirect()->route('contents_edit', ['id' => $id]);
    }

    public function edit(ContentEditRequest $request)
    {
        $fields = [];
        $old = [];
        $categorySlug = '';
        $title = '';
        $slug = $request->slug ? $request->slug : '';
        $contents = $this->contentHelper->get($request->id);
        $contentsLocale = $this->contentHelper->getLocaleContents($request->id);
        if (count($contentsLocale) != 0) {
            $title = $contentsLocale['en']->first()->title;
        }
        if (isset($contents->content_category_id) && $contents->content_category_id) {
            $categorySlug = $this->contentHelper->getCategorySlugById($contents->content_category_id);
            $fields = $this->contentHelper->getFieldsOfCategory($categorySlug);
        } else {
            $categorySlug = $categoryId = '';
            $fields = $this->contentHelper->getFieldsOfPage($contents->page_slug);
        }

        if ($contents->course_id) {
            $old['course_id'] = $this->courseHelper->getCourseAndTitle($contents->course_id);
        }
        $languages = $this->settingsHelper->getLanguages();
        $seo = $this->seoHelper->getSeoByModelIdAndModel($contents->id, model: 'Modules\Cms\Entities\Content');
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'contents_view', 'name' => 'Contents', 'permission' => 'contents_update'],
            ['name' => 'Edit Content'],
        ];
        return view('cms::admin.contents.editContent', compact('breadcrumbs', 'old', 'title', 'fields', 'slug', 'categorySlug', 'seo', 'contents', 'contentsLocale', 'languages', 'categorySlug'));
    }

    public function update(Request $request)
    {
        $currentData = $this->contentHelper->get($request->content_id);

        $data = [
            'id' => $request->content_id,
            'status' => $request->status,
            'link' => $request->link,
            'course_id' => $request->course_id ?? null,
            'content' => $request->content,
            'is_deltetable' => 1,
            'section' => 'web',
            'image_title' => $request->image_title,
            'thumbnail_alt' => $request->thumbnail_alt,
            'email' => $request->email ?? null,
            'phone_number' => $request->phone_number ?? null,
        ];

        if ($request->hasFile('file')) {
            $filePath = 'contents/file';
            $fileName = Storage::disk('elegant')->putFile($filePath, $request->file('file'));
            $data['file'] = $fileName;
        } elseif ($request->has('file_remove') && $request->file_remove) {
            $data['file'] = '';
        }

        if ($request->hasFile('thumbnail')) {
            $filePath = 'contents/thumbnail';
            $data['thumbnail'] = Storage::disk('elegant')->putFile($filePath, $request->file('thumbnail'));
        } elseif ($request->has('thumbnail_remove') && $request->thumbnail_remove) {
            $data['thumbnail'] = '';
        }

        $content = $this->contentHelper->update($data);

        // $names = $request->input('name') ?? $request->input('title');
        // $languageCodes = array_keys($names);
        $names = $request->input('name', []); // default to empty array

        // If only "title" exists and no "name" array was submitted
        if (empty($names)) {
            $names = ['en' => $request->input('title')]; // fallback to default language
        }

        $languageCodes = array_keys($names);
        $title = $request->input('title');

        foreach ($languageCodes as $languageCode) {
            $languageId = Language::where('code', $languageCode)->value('id');
            if ($languageId) {
                $name = $names[$languageCode] ?? $title;
                $contentData = [
                    'language_id' => $languageId,
                    'content_id' => $content->id,
                    'name' => $name,
                    'title' => $title,
                    'short_description' => $request->input("short_desc.$languageCode"),
                    'description' => $request->input("description.$languageCode"),
                    'content' => $request->input("content.$languageCode"),
                ];

                // Find the existing ContentLocale record or create a new one
                $localeContentItem = $content->locales()->where('language_id', $languageId)->first();
                if ($localeContentItem) {
                    $localeContentItem->update($contentData); // Update existing record
                } else {
                    ContentLocale::create($contentData); // Create new record
                }
            }
        }


        if ($request->has('images')) {
            foreach ($request->images as $id => $file) {
                $inputImageData = [
                    'id' => $id,
                    'content_id' => $content->id,
                    'image_path' => $file,
                ];
                $this->contentHelper->saveImage($inputImageData);
            }
        }

        if ($request->filled('meta_title') || $request->filled('meta_description')) {
            $seoData = [
                'id' => $request->seo_id,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_contents' => $request->meta_contents,
                'model' => $request->model,
                'model_id' => $content->id,
            ];
            $this->seoHelper->update($seoData);
        }

        $event = auth()->user()->name . ' Updated the Content with Title ' . $currentData->title;
        activity('Contents')->performedOn($content)->event($event)->withProperties(['content_id' => $content->id, 'data' => $request->all(), 'old' => $currentData])->log('Content Updated');

        if (isset($request->category_slug)) {
            if ($request->content_category_slug == 'companies-and-startups' || $request->content_category_slug == 'our-clients' || $request->content_category_slug == 'privacy-policy' || $request->content_category_slug == 'terms-and-conditions') {
                return redirect()->route('contents_edit', ['id' => $request->id])->with('success', 'Content Updated successfully');
            } else {
                return redirect()->route('contents_view', ['category' => $request->category_slug])->with('success', 'Content Updated successfully');
            }
        } else {
            return redirect()->route('contents_view', ['slug' => $content->page_slug])->with('success', 'Content Updated successfully');
        }
    }
    public function delete(ContentDeleteRequest $request)
    {
        $content = $this->contentHelper->get($request->id);

        if ($this->contentHelper->delete($request->id)) {
            $event = auth()->user()->name . ' Deleted the Content with Title ' . $content->title;
            activity('Contents')->performedOn($content)->event($event)->withProperties(['content_id' => $content->id, 'data' => $content])->log('Content Deleted');

            return response()->json(['status' => 1, 'message' => 'success']);
        }

        return response()->json(['status' => 0, 'message' => 'failed']);
    }

    public function viewContent(Request $request)
    {
        $contents = $this->contentHelper->get($request->id);
        $contentsLocale = $this->contentHelper->getLocaleContents($request->id);
        $englishLocale = $contentsLocale->get('en')?->first();
        $englishName = $englishLocale?->name ?? '';
        if (isset($contents->content_category_id) && $contents->content_category_id) {
            $categorySlug = $this->contentHelper->getCategorySlugById($contents->content_category_id);
        } else {
            $categorySlug = $categoryId = '';
        }
        $languages = $this->contentHelper->getAllLanguages();
        $seo = $this->seoHelper->getSeoByModelIdAndModel($contents->id, 'Modules\Career\Entities\Content');

        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'contents_view', 'name' => 'Contents', 'permission' => 'contents_update'],
            ['name' => 'View Content'],
        ];

        return view('cms::admin.contents.viewContent', compact('contents', 'seo', 'contentsLocale', 'englishName', 'languages', 'breadcrumbs'));
    }
}
