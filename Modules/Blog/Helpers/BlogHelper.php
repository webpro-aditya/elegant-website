<?php

namespace Modules\Blog\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogLocale;
use Modules\Cms\Entities\Language;

class BlogHelper
{
    public function save(array $input)
    { 
        if ($blog = Blog::create($input)) {
            return $blog;
        }

        return false;
    }

    public function getBlogDatatable($data)
    {
        $blogsQuery = Blog::select(app(Blog::class)->getTable() . '.*')
            ->with('category', 'locales', 'author.locales');

        if (isset($data['status'])) {
            $blogsQuery->where('status', '=', $data['status']);
        }

        if (isset($data['author_id'])) {
            $blogsQuery->where('author_id', '=', $data['author_id']);
        }

        if (isset($data['category_id'])) {
            $blogsQuery->where('category_id', '=', $data['category_id']);
        }
        
        $blogs = $blogsQuery->get();

        return $blogs;

    }

    public function getBlog($id)
    {
        return Blog::find($id);
    }

    public function getLocaleContents($id)
    {
        $contentLocales = BlogLocale::where('blog_id', $id)->get();

        $languageCodes = Language::pluck('code', 'id');

        $groupedContentLocales = $contentLocales->groupBy(function ($contentLocale) use ($languageCodes) {
            return $languageCodes[$contentLocale->language_id];
        });

        return $groupedContentLocales;
    }

    public function update($data)
    {
        $blog = Blog::find($data['id']);
        if ($blog->update($data)) {
            return $blog;
        }

        return false;
    }

    public function delete($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $blog->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }
}