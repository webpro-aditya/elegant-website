<?php

namespace Modules\Resources\Helpers\admin\freeResource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Cms\Entities\Language;
use Modules\Resources\Entities\FreeResource;
use Modules\Resources\Entities\ResourceContent;
use Modules\Resources\Entities\ResourceContentLocal;
use Modules\Resources\Entities\ResourceLocal;

class ResourceHelper
{
    public function getDatatable($data)
    {
        $resourcesQuery = ResourceContent::select(app(ResourceContent::class)->getTable() . '.*')
            ->with('locales'); // Eager load locales relationship
    
        if (isset($data['status'])) {
            $resourcesQuery->where('status', '=', $data['status']);
        }
    
        if (isset($data['resource_id'])) {
            $resourcesQuery->where('resource_id', $data['resource_id']);
        }

        $resources = $resourcesQuery->get();

        $resourcesWithQuestions = $resources->map(function ($resource) {
            $locale = $resource->locales->firstWhere('language_id', 1);
            $resource->name_for_language_1 = $locale ? $locale->question : 'Title not found';
            return $resource;
        });
        
        return $resourcesWithQuestions;
    
    }
    public function save(array $input)
    {
        if ($resource = ResourceContent::create($input)) {
            return $resource;
        }

        return false;
    }

    public function get($id)
    {
        return ResourceContent::find($id);
    }


    public function getLocaleContents($id)
    {
        $contentLocales = ResourceContentLocal::where('content_id', $id)->get();

        $languageCodes = Language::pluck('code', 'id');

        $groupedContentLocales = $contentLocales->groupBy(function ($contentLocale) use ($languageCodes) {
            return $languageCodes[$contentLocale->language_id];
        });

        return $groupedContentLocales;
    }


    public function update($data)
    {
        $resource = ResourceContent::find($data['id']);
        if ($resource->update($data)) {
            return $resource;
        }

        return false;
    }


    public function delete($id)
    {
        try {
            $resource = ResourceContent::findOrFail($id);
            $resource->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }
}