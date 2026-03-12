<?php

namespace Modules\Resources\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Entities\Language;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Resources\Entities\ResourceLocal;
use Modules\Resources\Helpers\admin\freeResource\FreeResourceHelper;
use Modules\Settings\Helpers\SettingsHelper;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Modules\Course\Helpers\LocalHelper;
use Modules\Seo\Helpers\SeoHelper;

class FreeResourcesController extends Controller
{
    protected $freeResourceHelper, $settingsHelper, $contentHelper, $localHelper, $seoHelper;
    public function __construct(LocalHelper $localHelper, SettingsHelper $settingsHelper, FreeResourceHelper $freeResourceHelper,  ContentHelper $contentHelper, SeoHelper $seoHelper)
    {
        $this->settingsHelper = $settingsHelper;
        $this->freeResourceHelper = $freeResourceHelper;
        $this->contentHelper = $contentHelper;
        $this->localHelper = $localHelper;
        $this->seoHelper = $seoHelper;
    }

    public function add(Request $request)
    {
        $languages = $this->settingsHelper->getLanguages();

        return view('resources::admin.freeResources.addFreeResource', compact( 'languages'));
    }

    public function save(Request $request)
    {
        $data = [
            'name' => $request->input('name.en'),
            'type' => $request->type,
            'is_popular' => $request->is_popular ,
            'section' => 'web',
            'status' => $request->status ,
            'thumbnail_alt' => $request->thumbnail_alt,
            'image_alt' => $request->image_alt,
            'time' => $request->time
        ];


        if ($request->hasFile('thumbnail')) {
            $filePath = 'free-resources/thumbnail';
            $data['thumbnail'] = Storage::disk('elegant')->putFile($filePath, $request->file('thumbnail'));
        } elseif ($request->has('thumbnail_remove') && $request->thumbnail_remove) {
            $data['thumbnail'] = '';
        }

        $resource = $this->freeResourceHelper->save($data);

        $data = [
            'name' => $request->input('name'),
            'short_description' => $request->input('short_desc'),
            'description' => $request->input('description'),
        ];

        $languageCodes = array_keys($request->input('name'));

        foreach ($languageCodes as $languageCode) {
            $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);
            if ($languageId) {
                $name = $data['name'][$languageCode];
                $contentData = [
                    'language_id' => $languageId,
                    'resource_id' => $resource->id, 
                    'name' => $name,
                    'short_description' => $data['short_description'][$languageCode] ?? null,
                    'description' => $data['description'][$languageCode] ?? null,
                ];
                $this->localHelper->saveResourceLocal($contentData);
            }
        }

        if ($request->filled('meta_title') && $request->filled('meta_description')) {
            $seoData = [
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_contents' => $request->meta_contents,
                'model' => $request->model,
                'model_id' => $resource->id,
            ];
            $this->seoHelper->save($seoData);
        }

        $event = auth()->user()->name . ' Added the Free Resource ';
        activity('Free Resources')->performedOn($resource)->event($event)->withProperties(['resource_id' => $resource->id, 'data' => $request->all()])->log('Resource Created');
 
        return redirect()->route('free_resource_list')->with('success', 'Free Resource added successfully');
    }

    public function list(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Free Resource'],
        ];

        return view('resources::admin.freeResources.listFreeResource', compact('breadcrumbs'));
    }

    public function listTable(Request $request)
    {
        $resources = $this->freeResourceHelper->getDatatable($request->all());
        $dataTableJSON = DataTables::of($resources)
            ->addIndexColumn()
            ->editColumn('name', function ($resource) {
                $data['text'] = $resource->name;

                return view('elements.listLink', compact('data'));
            })
            ->addColumn('type', function ($resource) {
                return $resource->type;
            })
            ->addColumn('status', function ($resource) {
                return view('elements.listStatus')->with('data', $resource);
            })
            ->addColumn('action', function ($resource) use ($request) {
                $data['view_url'] = route('free_resource_view', ['id' => $resource->id]);
                $data['edit_url'] = route('free_resource_edit', ['id' => $resource->id]);
                $data['delete_url'] = route('free_resource_delete', ['id' => $resource->id]);

                return view('elements.listAction', compact('data'));

            })
            ->make();

        return $dataTableJSON;
    }

    public function edit(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            // ['link' => 'blog_list', 'name' => 'Blog', 'permission' => 'blog_read'],
            ['name' => 'Resource Details'],
        ];

        $resource = $this->freeResourceHelper->get($request->id);

        $contentsLocale = $this->freeResourceHelper->getLocaleContents($request->id);
        $name = $contentsLocale['en']->first()->name;
        $languages = $this->settingsHelper->getLanguages();
        $seo = $this->seoHelper->getSeoByModelIdAndModel($resource->id, 'Modules\Blog\Entities\Blog');

        return view('resources::admin.freeResources.editFreeResource', compact('resource', 'seo', 'contentsLocale', 'name', 'breadcrumbs', 'languages'));
    }

    public function update(Request $request)
    {
        $currentData = $this->freeResourceHelper->get($request->resource_id);

        $slug =  Str::slug($request->input('name.en') . '-' .rand(1000, 9999)); // Adjust 'en' to the actual key used for English
        $data = [
            'id' => $request->resource_id,
            'type' => $request->type,
            'is_popular' => $request->is_popular ,
            'section' => 'web',
            'status' => $request->status ,
            // 'slug' => $slug,
            'thumbnail_alt' => $request->thumbnail_alt,
            'image_title' => $request->image_title,
            'time' => $request->time
        ];

        if ($request->hasFile('thumbnail')) {
            $filePath = 'free-resources/thumbnail';
            $data['thumbnail'] = Storage::disk('elegant')->putFile($filePath, $request->file('thumbnail'));
        } elseif ($request->has('thumbnail_remove') && $request->thumbnail_remove) {
            $data['thumbnail'] = '';
        }

        $resource = $this->freeResourceHelper->update($data);

        $data = [
            'name' => $request->input('name'),
            'short_description' => $request->input('short_desc'),
            'description' => $request->input('description'),
        ];

        $languageCodes = array_keys($request->input('name'));

        foreach ($languageCodes as $languageCode) {
            $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);
            
            if ($languageId) {
                $name = $data['name'][$languageCode];
                
                $contentData = [
                    'language_id' => $languageId,
                    'resource_id' => $resource->id, 
                    'name' => $name,
                    'short_description' => $data['short_description'][$languageCode] ?? null,
                    'description' => $data['description'][$languageCode] ?? null,
                ];

                $localeContentItem = $resource->locales()->where('language_id', $languageId)->first();
                if ($localeContentItem) {
                    $localeContentItem->update($contentData); 
                } else {
                    $this->localHelper->saveResourceLocal($contentData);
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

        $event = auth()->user()->name . ' Updated the Free Resource';
        activity('Free Resource')->performedOn($resource)->event($event)->withProperties(['resource_id' => $resource->id, 'data' => $request->all(), 'old' => $currentData])->log('Free Resource Updated');

        return redirect()->route('free_resource_list')->with('success', 'Free Resource Updated successfully');
    }


    public function delete(Request $request)
    {
        $resource = $this->freeResourceHelper->get($request->id);

        if ($this->freeResourceHelper->delete($request->id)) {
            if ($request->ajax()) {

                activity()->performedOn($resource)->event('Resouce Deleted')->withProperties(['resource_id' => $resource->id])->log('Free Resouce Deleted');

                return response()->json(['status' => 1, 'message' => 'Free Resouce  deleted successfully']);
            } else {
                return redirect()->route('free_resource_list')->with('success', 'Free Resouce  deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('free_resource_list')->with('success', 'Failed to delete');
        }
    }

    public function view(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            // ['link' => 'blog_list', 'name' => 'Blog', 'permission' => 'blog_read'],
            ['name' => 'Resources Details'],
        ];

        $resource = $this->freeResourceHelper->get($request->id);
        $contentsLocale = $this->freeResourceHelper->getLocaleContents($request->id);
        $name = $contentsLocale['en']->first()->name;
        $languages = $this->contentHelper->getAllLanguages();

        return view('resources::admin.freeResources.viewResources', compact('resource', 'contentsLocale', 'name', 'breadcrumbs', 'languages'));
    }
}
