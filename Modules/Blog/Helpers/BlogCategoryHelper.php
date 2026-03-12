<?php

namespace Modules\Blog\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Blog\Entities\BlogCategory;

class BlogCategoryHelper
{
    public function save(array $input)
    {
        if ($categroy = BlogCategory::create($input)) {
            return $categroy;
        }

        return false;
    }

    public function getCategoryDatatable($data)
    {
        $categories = BlogCategory::select(app(BlogCategory::class)->getTable() . '.*');

        if (isset($data['status'])) {
            $categories->where('status', $data['status']);
        }

        return $categories;
    }

    public function delete($categoryId)
    {
        try {
            $blog = BlogCategory::findOrFail($categoryId);
            $blog->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getCategory($id)
    {
        return BlogCategory::find($id);
    }

    public function update($data)
    {
        $category = BlogCategory::find($data['id']);

        if ($category->update($data)) {
            return $category;
        }

        return false;
    }

    public function getAllBlogCategory()
    {
        return BlogCategory::All();
    }

    public function searchCategory($keyword)
    {
        $courses = BlogCategory::where('status', 'active') 
                               ->where('name_en', 'like', "%{$keyword}%");
    
        return $courses->paginate(30, ['*'], 'page', request()->get('page'));
    }
}
