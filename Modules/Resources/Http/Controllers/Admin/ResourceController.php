<?php

namespace Modules\Resources\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Entities\Language;
use Modules\Resources\Entities\ResourceContent;
use Modules\Resources\Entities\ResourceContentLocal;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Resources\Helpers\admin\freeResource\ResourceHelper;
use Modules\Cms\Helpers\ContentHelper;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    protected $resourceHelper;
    protected $settingsHelper;
    protected $contentHelper;
    public function __construct(SettingsHelper $settingsHelper, ResourceHelper $resourceHelper, ContentHelper $contentHelper)
    {
        $this->settingsHelper = $settingsHelper;
        $this->resourceHelper = $resourceHelper;
        $this->contentHelper = $contentHelper;
    }

    public function table(Request $request)
    {
        $resources = $this->resourceHelper->getDatatable($request->all());
        $dataTableJSON = DataTables::of($resources)
            ->addIndexColumn()
            ->editColumn('question', function ($resource) {
                return $resource->name_for_language_1;
            })
            ->addColumn('action', function ($resource) use ($request) {
                $data['edit_url'] = route('free_resource_contents_edit', ['id' => $resource->id]);
                $data['delete_url'] = route('free_resource_contents_delete', ['id' => $resource->id]);

                return view('elements.listAction', compact('data'));

            })
            ->make();

        return $dataTableJSON;
    }

    public function add(Request $request)
    {
        $languages = $this->settingsHelper->getLanguages();
        $resource_id = $request->resource_id;

        $responce['html'] = (string) view('resources::admin.resourceContent.addResourceContent', compact('languages', 'resource_id' ));
        $responce['scripts'][] = (string) mix('js/admin/resourceContent/addResourceContent.js');
        $responce['style'][] = (string) mix('css/admin/resourceContent/addResourceContent.css');

        return $responce;
    }
    public function save(Request $request)
    {
        $data = [];

        $data = [
            'resource_id' => $request->resource_id,
            'link' => $request->input('link'),
            'status' => $request->input('status')
        ];

        $content = $this->resourceHelper->save($data);

        $data = [
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
        ];

        $languageCodes = array_keys($request->input('question'));

        foreach ($languageCodes as $languageCode) {
            $languageId = Language::where('code', $languageCode)->value('id');
            if ($languageId) {
                $question = $data['question'][$languageCode];
                $contentData = [
                    'language_id' => $languageId,
                    'content_id' => $content->id,
                    'question' => $question,
                    'answer' => $data['answer'][$languageCode] ?? null,
                ];

                ResourceContentLocal::create($contentData);
            }
        }

        $event = auth()->user()->name . ' Added the Free Resource Content';
        activity('Free Resources Content')->performedOn($content)->event($event)->withProperties(['resource_content_id' => $content->id, 'data' => $request->all()])->log('Resource Content Created');

        return redirect()
            ->route('free_resource_view', ['id' => $request->resource_id])
            ->with('success', 'Training Calendar added successfully');
    }

    public function edit(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'free_resource_list', 'name' => 'Free Resource', 'permission' => 'free_resource_read'],
            ['name' => 'Resource Content Details'],
        ];

        $resource = $this->resourceHelper->get($request->id);
        $contentsLocale = $this->resourceHelper->getLocaleContents($request->id);
        $title = $contentsLocale['en']->first()->title;
        $languages = $this->settingsHelper->getLanguages();
        return view('resources::admin.resourceContent.editResourceContent', compact('resource', 'contentsLocale', 'title', 'breadcrumbs', 'languages'));
    }

    public function update(Request $request)
    {

        $currentData = $this->resourceHelper->get($request->id);

        $data = [
            'id' => $request->id,
            'resource_id' => $request->resource_id,
            'link' => $request->input('link'),
            'status' => $request->input('status')
        ];

        $content = $this->resourceHelper->update($data);

        $data = [
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
        ];

        $languageCodes = array_keys($request->input('question'));

        foreach ($languageCodes as $languageCode) {
            $languageId = Language::where('code', $languageCode)->value('id');
            if ($languageId) {
                $question = $data['question'][$languageCode];
                $contentData = [
                    'language_id' => $languageId,
                    'content_id' => $content->id,
                    'question' => $question,
                    'answer' => $data['answer'][$languageCode] ?? null,
                ];

                $localeContentItem = $content->locales()->where('language_id', $languageId)->first();
                if ($localeContentItem) {
                    $localeContentItem->update($contentData); 
                } else {
                    ResourceContentLocal::create($contentData);
                }
            }
        }

        $event = auth()->user()->name . ' Updated the Free Resource Content';
        activity('Free Resources Content')->performedOn($content)->event($event)->withProperties(['resource_content_id' => $content->id, 'data' => $currentData])->log('Resource Content Updated');

        return redirect()
            ->route('free_resource_view', ['id' => $request->resource_id])
            ->with('success', 'Training Calendar updated successfully');
    }

    public function delete(Request $request)
    {
        $resource = $this->resourceHelper->get($request->id);

        if ($this->resourceHelper->delete($request->id)) {
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
}
