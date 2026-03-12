<?php

namespace Modules\Seo\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Seo\Helpers\SeoHelper;
use Yajra\DataTables\DataTables;
use Modules\Seo\Http\Requests\Admin\Seo\SeoUpdateRequest;
use Modules\Seo\Http\Requests\Admin\Seo\SeoAddRequest;
use Modules\Seo\Http\Requests\Admin\Seo\SeoCreateRequest;
use Modules\Seo\Http\Requests\Admin\Seo\SeoDeleteRequest;
use Modules\Seo\Http\Requests\Admin\Seo\SeoEditRequest;
use Modules\Seo\Http\Requests\Admin\Seo\SeoListDataRequest;
use Modules\Seo\Http\Requests\Admin\Seo\SeoListRequest;

class SeoController extends Controller
{
    protected $seoHelper;

    public function __construct(SeoHelper $seoHelper)
    {
        $this->seoHelper = $seoHelper;
    }
    public function listSeo(SeoListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'SEO'],
        ];

        return view('seo::admin.seo.listSeo', compact('breadcrumbs'));
    }

    public function seoListData(SeoListDataRequest $request)
    {
        $seos = $this->seoHelper->getSeoDatatable($request->all());
        $dataTableJSON = DataTables::of($seos)
            ->addIndexColumn()
            ->editColumn('meta_title', function ($seo) {
                $data['text'] = $seo->meta_title;
                return view('elements.listLink', compact('data'));
            })
            ->editColumn('model', function ($seo) {
                return $seo->model;
            })
            ->addColumn('name', function ($seo) {
                return $seo->modelable->name ?? $seo->modelable->title ;
            })
            ->addColumn('action', function ($seo) use ($request) {
                $data['edit_url'] = route('seo_edit', ['id' => $seo->id  ]);
                $data['delete_url'] = route('seo_delete', ['id' => $seo->id]);
                return view('elements.listAction', compact('data'));

            })
            ->make();

        return $dataTableJSON;
    }

    public function add(SeoAddRequest $request)
    {
        $type = '';
        if ($request->type) {
            $type = $request->type;
        }
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'contents_view', 'name' => 'Contents', 'permission' => 'contents_update'],
            ['name' => 'Edit Content'],
        ];

        return view('seo::admin.seo.addSeo', compact('breadcrumbs', 'type'));
    }

    public function save(SeoCreateRequest $request)
    {
        $data = [
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'model' => $request->model ?? 'Modules\Cms\Entities\Page',
            'model_id' => $request->model_id ?? 1,
            'google_analytics_footer' => $request->google_analytics_footer ?? '',
            'google_analytics_body' => $request->google_analytics_body ?? '',
            'google_analytics_head' => $request->google_analytics_head ?? '',

        ];

        $seo = $this->seoHelper->save($data);

        // activity('SEO')->performedOn($seo)->event($seo)->withProperties(['seo_id' => $seo->id, 'data' => $request->all()])->log('SEO Created');

        return redirect()->route('seo_list')->with('success', 'Content added successfully');

    }

    public function edit(SeoEditRequest $request)
    {
        $seo = $this->seoHelper->get($request->id);
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'contents_view', 'name' => 'Contents', 'permission' => 'contents_update'],
            ['name' => 'Edit Content'],
        ];
        $type = '';
        if($request->type){
            $type = $request->type;
        }
        return view('seo::admin.seo.editSeo', compact('breadcrumbs', 'seo', 'type'));
    }

    public function update(SeoUpdateRequest $request)
    {
        $data = [
            'id' => $request->seo_id ?? null,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'model' => $request->model ?? 'Modules\Cms\Entities\Page',
            'model_id' => $request->model_id ?? 1,
            'google_analytics_footer' => $request->google_analytics_footer ?? '',
            'google_analytics_body' => $request->google_analytics_body ?? '',
            'google_analytics_head' => $request->google_analytics_head ?? '',

        ];
        $seo = $this->seoHelper->update($data);



        activity('SEO')->performedOn($seo)->event($seo)->withProperties(['seo_id' => $seo->id, 'data' => $request->all()])->log('SEO Updated');

        return redirect()->route('seo_list')->with('success', 'Content Updated successfully');
    }
    public function delete(SeoDeleteRequest $request)
    {
        $seo = $this->seoHelper->get($request->id);

        if ($this->seoHelper->delete($request->id)) {
            $event = auth()->user()->name . ' Deleted the SEO with Title ' . $seo->meta_title;
            activity('Contents')->performedOn($seo)->event($event)->withProperties(['content_id' => $seo->id, 'data' => $seo])->log('SEO Deleted');

            return response()->json(['status' => 1, 'message' => 'success']);
        }

        return response()->json(['status' => 0, 'message' => 'failed']);
    }

    public function modelOptions(Request $request)
    {
        $term = trim($request->search);
        $models = $this->seoHelper->searchModels($term);
        $modelOptions = [];

        foreach ($models as $model) {   
            $shortModel = basename(str_replace('\\', '/',  $model->model));


            $modelOptions[] = ['id' => $model->model, 'text' =>  $shortModel];
        }

        return response()->json($modelOptions);
    }
}
