<?php

namespace Modules\Career\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Career\Entities\CareerCategory;

class CareerCategoryHelper
{
    public function save(array $input)
    {
        if ($categroy = CareerCategory::create($input)) {
            return $categroy;
        }

        return false;
    }


    public function getCategoryDatatable($data)
    {
        $categories = CareerCategory::select(app(CareerCategory::class)->getTable() . '.*');

        if (isset($data['status'])) {
            $categories->where('status', $data['status']);
        }
 
        if (isset($data['search']['value'])) {
            $categories->where('name_en','like', "%{$data['search']['value']}%");
        }

        return $categories;
    }

    public function getCategory($id)
    {
        return CareerCategory::find($id);
    }

    public function update($data)
    {
        $category = CareerCategory::find($data['id']);

        if ($category->update($data)) {
            return $category;
        }

        return false;
    }

    public function delete($categoryId)
    {
        try {
            $blog = CareerCategory::findOrFail($categoryId);
            $blog->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }


    public function searchCategory($keyword)
    {
        $courses = CareerCategory::where('status', 'active')->where('name_en', 'like', "%{$keyword}%");

        return $courses->paginate(30, ['*'], 'page', request()->get('page'));
    }

}