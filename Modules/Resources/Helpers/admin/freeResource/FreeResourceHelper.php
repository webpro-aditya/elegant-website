<?php

namespace Modules\Resources\Helpers\admin\freeResource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Cms\Entities\Language;
use Modules\Resources\Entities\FreeResource;
use Modules\Resources\Entities\ResourceLocal;


class FreeResourceHelper
{
    public function save(array $input)
    {
        if ($resource = FreeResource::create($input)) {
            return $resource;
        }

        return false;
    }
    public function getDatatable($data)
    {
        $resourcesQuery = FreeResource::select(app(FreeResource::class)->getTable() . '.*')->with('locales');
      
        if (isset($data['status'])) {
            $resourcesQuery->where('status', '=', $data['status']);
        }

        if (isset($data['type'])) {
            $resourcesQuery->where('type', '=', $data['type']);
        }
     
        $resources = $resourcesQuery->get();
      
        return $resources;
    }

    public function get($id)
    {
        $resource =  FreeResource::find($id);

        if ($resource && $resource->locales->isNotEmpty()) {
            $resource->english_name = $resource->locales->first()->name;
        } else {
            $resource->english_name = null;
        }
        
        return $resource;
    }

    public function getResourceWithName($id)
    {
        $englishLanguageId = Language::where('code', 'en')->value('id');

        $resource = FreeResource::find($id);
        $englishName = ResourceLocal::where('resource_id', $resource->id)->where('language_id', $englishLanguageId)->value('name');

        $resource->english_name = $englishName;

        return $resource;
    }

    public function getLocaleContents($id)
    {
        $contentLocales = ResourceLocal::where('resource_id', $id)->get();

        $languageCodes = Language::pluck('code', 'id');

        $groupedContentLocales = $contentLocales->groupBy(function ($contentLocale) use ($languageCodes) {
            return $languageCodes[$contentLocale->language_id];
        });

        return $groupedContentLocales;
    }

    public function update($data)
    {
        $resource = FreeResource::find($data['id']);
        if ($resource->update($data)) {
            return $resource;
        }

        return false;
    }

    public function delete($id)
    {
        try {
            $resource = FreeResource::findOrFail($id);
            $resource->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

}