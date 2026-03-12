<?php

namespace Modules\Course\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Cms\Entities\Language;
use Modules\Course\Entities\Syllabus;
use Modules\Course\Entities\SyllabusLocal;

class SyllabusHelper
{
    public function searchSyllabus($keyword)
    {
        $modules = Syllabus::where('title', 'like', "%{$keyword}%");

        return $modules->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function save(array $input)
    {
        if ($module = Syllabus::create($input)) {
            return $module;
        }

        return false;
    }

    public function getSyllabusDatatable($data)
    {
    
        $modules = Syllabus::select(app(Syllabus::class)->getTable() . '.*')->with(['course', 'locales']);
    
        if (isset($data['course_id']) && ($data['course_id'])) {
            $modules->where('course_id', $data['course_id']);
        }
    
        if (isset($data['batch_id'])) {
            $modules->where('batch_id', $data['batch_id']);
        }
 
        if (isset($data['status'])) {
            $modules->where('status', $data['status']);
        }
        
        return $modules->get();
    }
    
    public function delete($moduleId)
    {
        try {
            $module = Syllabus::findOrFail($moduleId);
            $module->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getSyllabus($id)
    {
        return Syllabus::with('locales')->find($id);
    }

    public function update($data)
    {
        $module = Syllabus::find($data['id']);

        if ($module->update($data)) {
            return $module;
        }

        return false;
    }

    public function getAllSyllabus()
    {
        return Syllabus::All();
    }


    public function getLocaleSyllabus($id)
    {
        $contentLocales = SyllabusLocal::where('syllabus_id', $id)->get();

        $languageCodes = Language::pluck('code', 'id');

        $groupedContentLocales = $contentLocales->groupBy(function ($contentLocale) use ($languageCodes) {
            return $languageCodes[$contentLocale->language_id];
        });

        return $groupedContentLocales;
    }
}
