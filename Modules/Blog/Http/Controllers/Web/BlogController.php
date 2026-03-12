<?php

namespace Modules\Blog\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Blog\Helpers\Web\BlogHelper;
use Modules\Author\Helpers\admin\AuthorHelper;
use Modules\Translation\Helpers\TranslationHelper;

class BlogController extends Controller
{
    protected $cmsHelper;
    protected $settingsHelper;
    protected $blogHelper;
    protected $authorHelper;
    protected $translationHelper;

    public function __construct(ContentHelper $cmsHelper, AuthorHelper $authorHelper, SettingsHelper $settingsHelper, BlogHelper $blogHelper, TranslationHelper $translationHelper)
    {
        $this->cmsHelper = $cmsHelper;
        $this->settingsHelper = $settingsHelper;
        $this->blogHelper = $blogHelper;
        $this->authorHelper = $authorHelper;
        $this->translationHelper = $translationHelper;
    }

    public function list()
    {
        $contents = $this->cmsHelper->getContentByKey();
        $blogs = $this->blogHelper->getBlogs();
        $categories = $this->blogHelper->getCategories();
        $populars = $this->blogHelper->getAllPopularBlogs();
        $careers = $this->blogHelper->getCareerBlogs();
        $featured = $this->blogHelper->getFeatured();
        $translations = $this->translationHelper->getKeyValue();

        return view('blog::web.list', compact('contents', 'populars', 'careers', 'blogs', 'categories', 'featured', 'translations'));
    }
    public function category(Request $request)
    {
        $blogs = $this->blogHelper->getBlogsFromCategorySlug($request->category);
        $category = $this->blogHelper->getCategoryFromSlug($request->category);
        $categories = $this->blogHelper->getCategories();
        $translations = $this->translationHelper->getKeyValue();

        return view('blog::web.category', compact('blogs', 'category', 'categories', 'translations'));
    }
    public function detail(Request $request)
    {
        $blog = $this->blogHelper->getBlogFromSlug($request->blog);
        $categories = $this->blogHelper->getCategories();
        $populars = $this->blogHelper->getPopularBlogs($request->blog);
        $translations = $this->translationHelper->getKeyValue();
        return view('blog::web.detail', compact('blog', 'categories', 'populars' ,'translations'));
    }

    public function authorList(Request $request)
    {
        $author = $this->authorHelper->get($request->id);
        $blogs = $this->blogHelper->getBlogsofAuthor($author->id);
        $translations = $this->translationHelper->getKeyValue();

        return view('blog::web.author.list', compact('author', 'blogs' ,'translations'));
    }
}
