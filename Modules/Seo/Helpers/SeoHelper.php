<?php

namespace Modules\Seo\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Seo\Entities\Seo;


class SeoHelper
{
    public function getSeoDatatable($data)
    {
        $seoQuery = Seo::select(app(Seo::class)->getTable() . '.*');

        if (isset($data['model'])) {
            $seoQuery->where('model', $data['model']);
        }

        return $seoQuery;
    }


    public function save(array $input)
    {
        if ($seo = Seo::updateOrCreate($input)) {
            return $seo;
        }

        
        return false;
    }

    public function customSave(array $input, $model = null)
    {
        if ($model) {
            return $model->seo()->updateOrCreate([], [
                'meta_title'       => $input['meta_title'] ?? null,
                'meta_description' => $input['meta_description'] ?? null,
                'meta_contents'    => $input['meta_contents'] ?? null,
                'canonical_tag_url' => $input['canonical_tag_url'] ?? null
            ]);
        }

        // fallback if model not passed (using legacy "model/model_id" columns)
        if (isset($input['model'], $input['model_id'])) {
            return Seo::updateOrCreate(
                [
                    'model'    => $input['model'],
                    'model_id' => $input['model_id'],
                ],
                Arr::only($input, ['meta_title', 'meta_description', 'meta_contents', 'canonical_tag_url'])
            );
        }

        return false;
    }



    public function get($id)
    {
        return Seo::find($id);
    }

    public function update($data)
    {
        $searchCriteria = ['id' => $data['id']];
        if($data['id'] != null){
            $seo = Seo::updateOrCreate($searchCriteria, $data);
        }else{
            unset($data['id']);
            $seo = Seo::create($data);
        }


        return $seo;
    }
    public function delete($id)
    {
        try {
            $seo = Seo::findOrFail($id);
            $seo->delete();
            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getSeoByModelId($modelId)
    {
        $seo = Seo::where('model_id', $modelId)->latest()->first();
        if($seo){
            return $seo;
        }else{
            return null;
        }
    }

    public function getSeoByModelIdAndModel($modelId, $model)
    {
        $seo = Seo::where('model_id', $modelId)->where('model', $model)->latest()->first();
        if($seo){
            return $seo;
        }else{
            return null;
        }
    }

    public function searchModels($keyword)
    {
        $models = Seo::where('model', 'like', "%{$keyword}%")
            ->distinct('model')
            ->paginate(30, ['model'], 'page', request()->get('page'));

        return $models;
    }
}