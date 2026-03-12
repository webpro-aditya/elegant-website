<?php

namespace Modules\Blog\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Author\Helpers\admin\AuthorHelper;
use Modules\Blog\Entities\BlogLocale;
use Modules\Cms\Entities\Language;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Blog\Helpers\BlogCategoryHelper;
use Modules\Blog\Helpers\BlogHelper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Modules\Seo\Helpers\SeoHelper;
use Yajra\DataTables\DataTables;
use Modules\User\Helpers\UserHelper;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Blog\Http\Requests\Admin\Blog\BlogAddRequest;
use Modules\Blog\Http\Requests\Admin\Blog\BlogCreateRequest;
use Modules\Blog\Http\Requests\Admin\Blog\BlogListDataRequest;
use Modules\Blog\Http\Requests\Admin\Blog\BlogListRequest;
use Modules\Blog\Http\Requests\Admin\Blog\BlogEditRequest;
use Modules\Blog\Http\Requests\Admin\Blog\BlogUpdateRequest;
use Modules\Blog\Http\Requests\Admin\Blog\BlogDeleteRequest;
use Modules\Course\Helpers\LocalHelper;

class BlogController extends Controller
{
    protected $settingsHelper, $userHelper, $categoryHelper, $blogHelper, $seoHelper, $authorHelper, $contentHelper, $localHelper;
    public function __construct(LocalHelper $localHelper, SettingsHelper $settingsHelper, SeoHelper $seoHelper, AuthorHelper $authorHelper, BlogCategoryHelper $categoryHelper, BlogHelper $blogHelper, UserHelper $userHelper, ContentHelper $contentHelper)
    {
        $this->settingsHelper = $settingsHelper;
        $this->categoryHelper = $categoryHelper;
        $this->blogHelper = $blogHelper;
        $this->seoHelper = $seoHelper;
        $this->userHelper = $userHelper;
        $this->contentHelper = $contentHelper;
        $this->authorHelper = $authorHelper;
        $this->localHelper = $localHelper;
    }

    public function list(BlogListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Blogs'],
        ];

        return view('blog::admin.blog.listBlog', compact('breadcrumbs'));
    }

    public function blogListData(BlogListDataRequest $request)
    {
        $blogs = $this->blogHelper->getBlogDatatable($request->all());
        $dataTableJSON = DataTables::of($blogs)
            ->addIndexColumn()
            ->editColumn('title', function ($blog) {
                // $data['url'] = route('contents_view', ['slug' => $page->slug]);
                $data['text'] = $blog->title;

                return view('elements.listLink', compact('data'));
            })
            ->editColumn('author', function ($blog) {
                return $blog->author->name ?? 'NO USER FOUND';
            })
            ->editColumn('category', function ($blog) {
                return $blog->category->name_en ?? 'NO CATEGORY FOUND';
            })
            ->addColumn('status', function ($blog) {
                return view('elements.listStatus')->with('data', $blog);
            })
            ->addColumn('action', function ($blog) use ($request) {
                $data['view_url'] = route('blog_view', ['id' => $blog->id]);
                $data['edit_url'] = route('blog_edit', ['id' => $blog->id]);
                $data['delete_url'] = route('blog_delete', ['id' => $blog->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }
    public function add(BlogAddRequest $request)
    {
        $fields = ['name', 'short_desc', 'content'];
        $languages = $this->settingsHelper->getLanguages();

        return view('blog::admin.blog.addBlog', compact('fields', 'languages'));
    }
    public function create(BlogCreateRequest $request)
    {
        $data = [
            'name' => $request->title,
            'status' => $request->status,
            'is_popular' => $request->is_popular,
            'category_id' => $request->category_id,
            'section' => 'web',
            'author_id' => $request->author_id,
            'career_guidance' => $request->career_guidance,
            'thumbnail_alt' => $request->thumbnail_alt,
            'image_title' => $request->image_title ?? 'no title'
        ];

        if ($request->hasFile('thumbnail')) {
            $filePath = 'blog/thumbnail';
            $data['thumbnail'] = Storage::disk('elegant')->putFile($filePath, $request->file('thumbnail'));
        } elseif ($request->has('thumbnail_remove') && $request->thumbnail_remove) {
            $data['thumbnail'] = '';
        }

        $blog = $this->blogHelper->save($data);

        $data = [
            'name' => $request->input('name'),
            'title' => $request->input('title'),
            'short_desc' => $request->input('short_desc'),
            'content' => $request->input('content'),
        ];

        $languageCodes = array_keys($request->input('name'));
        $title = $data['title'] ?? null;

        foreach ($languageCodes as $languageCode) {
            $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);

            if ($languageId) {
                $name = $data['name'][$languageCode] ?? $title;
                $contentData = [
                    'language_id' => $languageId,
                    'blog_id' => $blog->id, // Adjust according to your BlogLocale model structure
                    'name' => $name,
                    'title' => $title,
                    'short_description' => $data['short_desc'][$languageCode] ?? null,
                    'content' => $data['content'][$languageCode] ?? null,
                ];

                $this->localHelper->updateOrCreateBlogLocale(
                    ['language_id' => $languageId, 'blog_id' => $blog->id], // Adjust the conditions as per your BlogLocale model
                    $contentData
                );
            }
        }

        if ($request->filled('meta_title') && $request->filled('meta_description')) {
            $seoData = [
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_contents' => $request->meta_contents,
                'model' => $request->model,
                'model_id' => $blog->id,
            ];
            $this->seoHelper->save($seoData);
        }

        $event = auth()->user()->name . ' Added the Blog ';
        activity('Contents')->performedOn($blog)->event($event)->withProperties(['blog_id' => $blog->id, 'data' => $request->all()])->log('Blog Created');

        return redirect()->route('blog_list')->with('success', 'Content added successfully');
    }
    public function optionsCategory(Request $request)
    {
        $term = trim($request->search);
        $categories = $this->categoryHelper->searchCategory($term);
        $categoryOption = [];

        foreach ($categories as $course) {
            $categoryOption[] = ['id' => $course->id, 'text' => $course->name_en];
        }

        return response()->json($categoryOption);
    }

    public function edit(BlogEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'blog_list', 'name' => 'Blog', 'permission' => 'blog_read'],
            ['name' => 'Blog Details'],
        ];

        $blog = $this->blogHelper->getBlog($request->id);
        $old = [];

        if ($blog->category_id) {
            $old['category_id'] = $this->categoryHelper->getCategory($blog->category_id);
        }

        if ($blog->author_id) {
            $old['author_id'] = $this->authorHelper->getAuthorWithName($blog->author_id);
        }

        $contentsLocale = $this->blogHelper->getLocaleContents($request->id);
        $title = $contentsLocale['en']->first()->title;
        $seo = $this->seoHelper->getSeoByModelIdAndModel($blog->id, 'Modules\Blog\Entities\Blog');
        $fields = ['name', 'short_desc', 'content'];
        $languages = $this->settingsHelper->getLanguages();

        return view('blog::admin.blog.editBlog', compact('blog', 'contentsLocale', 'fields', 'seo', 'title', 'breadcrumbs', 'languages', 'old'));
    }

    public function update(BlogUpdateRequest $request)
    {
        $currentData = $this->blogHelper->getBlog($request->blog_id);

        $slug = Str::slug($request->title);
        $data = [
            'id' => $request->blog_id,
            'status' => $request->status,
            'is_popular' => $request->is_popular,
            'category_id' => $request->category_id,
            'author_id' => $request->author_id,
            'section' => 'web',
            'author' => $request->author,
            'career_guidance' => $request->career_guidance,
            // 'slug' => $slug,
            'thumbnail_alt' => $request->thumbnail_alt,
            'image_title' => $request->image_title
        ];

        if ($request->hasFile('thumbnail')) {
            $filePath = 'blog/thumbnail';
            $data['thumbnail'] = Storage::disk('elegant')->putFile($filePath, $request->file('thumbnail'));
        } elseif ($request->has('thumbnail_remove') && $request->thumbnail_remove) {
            $data['thumbnail'] = '';
        }

        $blog = $this->blogHelper->update($data);

        $data = [
            'name' => $request->input('name'),
            'title' => $request->input('title'),
            'short_desc' => $request->input('short_desc'),
            'content' => $request->input('content'),
        ];

        $names = $request->input('name') ?? $request->input('title');
        $languageCodes = array_keys($names);
        $title = $request->input('title');

        foreach ($languageCodes as $languageCode) {
            $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);
            if ($languageId) {
                $name = $names[$languageCode] ?? $title;
                $contentData = [
                    'language_id' => $languageId,
                    'blog_id' => $blog->id,
                    'name' => $name,
                    'title' => $title,
                    'short_description' => $data['short_desc'][$languageCode] ?? null,
                    'content' => $data['content'][$languageCode] ?? null,
                ];

                $localeContentItem = $blog->locales()->where('language_id', $languageId)->first();
                if ($localeContentItem) {
                    $localeContentItem->update($contentData); // Update existing record
                } else {
                    $this->saveBlogLocale($contentData);
                }
            }
        }

        if ($request->filled('meta_title') && $request->filled('meta_description')) {
            $seoData = [
                'id' => $request->seo_id,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_contents' => $request->meta_contents,
                'model' => $request->model,
                'model_id' => $blog->id,
            ];
            $this->seoHelper->update($seoData);
        }

        $event = auth()->user()->name . ' Updated the Blog with Title ' . $currentData->title;
        activity('Blogs')->performedOn($blog)->event($event)->withProperties(['blog_id' => $blog->id, 'data' => $request->all(), 'old' => $currentData])->log('Blog Updated');

        return redirect()->route('blog_list')->with('success', 'Blog Updated successfully');
    }

    public function delete(BlogDeleteRequest $request)
    {
        $blog = $this->blogHelper->getBlog($request->id);

        if ($this->blogHelper->delete($request->id)) {
            if ($request->ajax()) {

                activity()->performedOn($blog)->event('Blog  Deleted')->withProperties(['blog_id' => $blog->id])->log('Blog Deleted');

                return response()->json(['status' => 1, 'message' => 'Blog  deleted successfully']);
            } else {
                return redirect()->route('blog_list')->with('success', 'Blog  deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('blog_list')->with('success', 'Failed to delete');
        }
    }

    public function viewBlog(Request $request)
    {
        $blog = $this->blogHelper->getBlog($request->id);
        $contentsLocale = $this->blogHelper->getLocaleContents($request->id);
        $englishLocale = $contentsLocale['en']->first();
        $englishName = $englishLocale->name;
        $languages = $this->contentHelper->getAllLanguages();
        $seo = $this->seoHelper->getSeoByModelIdAndModel($blog->id, 'Modules\Blog\Entities\Blog');

        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'blog_list', 'name' => 'Contents', 'permission' => 'blog_read'],
            ['name' => 'View Blog'],
        ];

        return view('blog::admin.blog.viewBlog', compact('blog', 'seo', 'contentsLocale', 'englishName', 'languages', 'breadcrumbs'));
    }
}
