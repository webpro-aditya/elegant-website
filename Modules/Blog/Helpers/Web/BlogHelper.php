<?php

namespace Modules\Blog\Helpers\Web;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Entities\BlogLocale;
use Modules\Cms\Entities\Language;

class BlogHelper
{
    public function getBlogs()
    {
        $localeColumn = 'name_' . config('app.locale');
    
        $blogs = Blog::with([
            'category' => function ($query) use ($localeColumn) {
                $query->select('id', $localeColumn);
            },
            'defaultLocale',
            'author' => function ($query) {
                $query->where('status', 'active'); 
            }
        ])
        ->where('status', 'active')
        ->whereHas('author', function ($query) {
            $query->where('status', 'active'); 
        })
        ->get()
        ->map(function ($blog) use ($localeColumn) {
            $blog->localizedCategoryName = $blog->category ? $blog->category->getAttribute($localeColumn) : null;
            return $blog;
        });

        return $blogs;
    }
    public function getCategories()
    {
        $localeColumn = 'name_' . config('app.locale');

        $categories = BlogCategory::where('status', 'active')
            ->has('blogs')
            ->withCount('blogs')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get(['id', $localeColumn]);

        $categories->each(function ($category) use ($localeColumn) {
            $category->setAttribute('name', $category->{$localeColumn});
        });

        return $categories;
    }

    public function getAllPopularBlogs()
    {
        $blogs = Blog::with('defaultLocale')->where('status', 'active')
            ->where('is_popular', 'yes')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return $blogs;
    }

    public function getPopularBlogs($slug)
    {
        $blogs = Blog::with('defaultLocale')->where('status', 'active')
            ->where('is_popular', 'yes')
            ->where('slug', '!=', $slug)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return $blogs;
    }

    public function getCareerBlogs()
    {
        $blogs = Blog::with('defaultLocale')->where('status', 'active')
            ->where('career_guidance', 'yes')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return $blogs;
    }

    public function getFeatured()
    {
        $localeColumn = 'name_' . config('app.locale');

        $categories = BlogCategory::where('status', 'active')
            ->where('is_featured', 'yes')
            ->has('blogs') 
            ->with('blogs')
            ->get();

        $categories->each(function ($category) use ($localeColumn) {
            $category->setAttribute('name', $category->{$localeColumn});
        });

        return $categories;
    }

    public function getBlogFromSlug($slug)
    {
        return Blog::where('slug', $slug)->with('defaultLocale', 'category', 'seo')->first();
    }

    public function getBlogsFromCategorySlug($slug)
    {

        $category = BlogCategory::where('slug', $slug)->first(); // Get the first instance

        $localeColumn = 'name_' . config('app.locale');

        if ($category) {

            $categoryId = $category->id;

            $blogs = Blog::with([
                'category' => function ($query) use ($localeColumn) {
                    $query->select('id', $localeColumn);
                },
                'defaultLocale'
            ])
                ->where('status', 'active')
                ->where('category_id', $categoryId)
                ->get()

                ->map(function ($blog) use ($localeColumn) {
                    $blog->localizedCategoryName = $blog->category ? $blog->category->getAttribute($localeColumn) : null;
                    return $blog;
                });
            return $blogs;

        }

        return collect(); // Return an empty collection if no category is found
    }

    public function getCategoryFromSlug($slug)
    {
        $localeColumn = 'name_' . config('app.locale');

        $category = BlogCategory::where('status', 'active')
            ->where('slug', $slug)
            ->with('blogs')
            ->first();

        if ($category) {
            $category->setAttribute('name', $category->{$localeColumn});
        }

        return $category;

    }

    public function getBlogsofAuthor($id)
    {
        return Blog::where('author_id', $id)->where('status', 'active')->get();
    }
}