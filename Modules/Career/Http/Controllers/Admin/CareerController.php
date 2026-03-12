<?php

namespace Modules\Career\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Career\Entities\CareerLocale;
use Modules\Cms\Entities\Language;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Seo\Helpers\SeoHelper;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Career\Helpers\CareerCategoryHelper;
use Modules\Career\Helpers\CareerHelper;
use Illuminate\Support\Str;
use Modules\Career\Http\Requests\Admin\Career\CareerAddRequest;
use Modules\Career\Http\Requests\Admin\Career\CareerCreateRequest;
use Modules\Career\Http\Requests\Admin\Career\CareerDeleteRequest;
use Modules\Career\Http\Requests\Admin\Career\CareerEditRequest;
use Modules\Career\Http\Requests\Admin\Career\CareerListDataRequest;
use Modules\Career\Http\Requests\Admin\Career\CareerListRequest;
use Modules\Career\Http\Requests\Admin\Career\CareerUpdateRequest;
use Modules\Course\Helpers\LocalHelper;
use Yajra\DataTables\DataTables;

class CareerController extends Controller
{
    protected $localHelper, $contentHelper, $careerHelper, $categoryHelper, $settingsHelper, $seoHelper;
    public function __construct(LocalHelper $localHelper, SettingsHelper $settingsHelper, CareerHelper $careerHelper, SeoHelper $seoHelper, CareerCategoryHelper $categoryHelper, ContentHelper $contentHelper)
    {
        $this->settingsHelper = $settingsHelper;
        $this->seoHelper = $seoHelper;
        $this->categoryHelper = $categoryHelper;
        $this->careerHelper = $careerHelper;
        $this->contentHelper = $contentHelper;
        $this->localHelper = $localHelper;
    }
    public function list(CareerListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Career'],
        ];

        return view('career::admin.career.listCareer', compact('breadcrumbs'));
    }
    public function careerListData(CareerListDataRequest $request)
    {
        $careers = $this->careerHelper->getDatatable($request->all());
        $dataTableJSON = DataTables::of($careers)
            ->addIndexColumn()
            ->editColumn('title', function ($career) {
                $data['text'] = $career->title;

                return view('elements.listLink', compact('data'));
            })
            ->editColumn('category', function ($career) {
                return $career->category->name_en ?? 'NO CATEGORY FOUND';
            })
            ->addColumn('status', function ($career) {
                return view('elements.listStatus')->with('data', $career);
            })
            ->addColumn('action', function ($career) use ($request) {
                $data['view_url'] = route('career_view', ['id' => $career->id]);
                $data['edit_url'] = route('career_edit', ['id' => $career->id]);
                $data['delete_url'] = route('career_delete', ['id' => $career->id]);
    
                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }
    public function add(CareerAddRequest $request)
    {
        $fields = ['name', 'location', 'skill', 'job_profile'];
        $languages = $this->settingsHelper->getLanguages();

        return view('career::admin.career.addCareer', compact('fields', 'languages'));
    }
    public function save(CareerCreateRequest $request)
    {
        $data = [
            'status' => $request->status,
            'title' => $request->title,
            'category_id' => $request->category_id,
            'vaccancy' => $request->vaccancy,
            'experience' => $request->experience,
            'employment' => $request->employment,
            'section' => 'web',
        ];

        $career = $this->careerHelper->save($data);


        $data = [
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'model' => $request->model,
            'meta_contents' => $request->meta_contents,
            'model_id' => $career->id,
        ];

        $this->seoHelper->save($data);


        $data = [
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'skill' => $request->input('skill'),
            'job_profile' => $request->input('job_profile'),
        ];

        $languageCodes = array_keys($request->input('name'));
        foreach ($languageCodes as $languageCode) {
            $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);
            if ($languageId) {
                $name = $data['name'][$languageCode];
                $contentData = [
                    'language_id' => $languageId,
                    'career_id' => $career->id,
                    'name' => $name,
                    'employment' => $data['employment'][$languageCode] ?? null,
                    'location' => $data['location'][$languageCode] ?? null,
                    'skill' => $data['skill'][$languageCode] ?? null,
                    'job_profile' => $data['job_profile'][$languageCode] ?? null,
                ];
                if (array_filter($contentData, fn($value, $key) => !in_array($key, ['language_id', 'career_id']) && !is_null($value), ARRAY_FILTER_USE_BOTH)) {
                    $this->localHelper->saveCareerLocale($contentData);
                }
            }
        }
        if ($request->filled('meta_title') && $request->filled('meta_description')) {
            $seoData = [
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_contents' => $request->meta_contents,
                'model' => $request->model,
                'model_id' => $career->id,
            ];
            $this->seoHelper->save($seoData);
        }

        $event = auth()->user()->name . ' Added the Career ';
        activity('Contents')->performedOn($career)->event($event)->withProperties(['career_id' => $career->id, 'data' => $request->all()])->log('Career Created');

        return redirect()->route('career_list')->with('success', 'Career added successfully');

    }
    public function edit(CareerEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'career_list', 'name' => 'Career', 'permission' => 'career_read'],
            ['name' => 'Career Details'],
        ];

        $career = $this->careerHelper->get($request->id);
        $old = [];

        if ($career->category_id) {
            $old['category_id'] = $this->categoryHelper->getCategory($career->category_id);
        }

        $contentsLocale = $this->careerHelper->getLocaleContents($request->id);
        $seo = $this->seoHelper->getSeoByModelIdAndModel($career->id, 'Modules\Career\Entities\Career');

        $fields = ['name', 'location', 'skill', 'job_profile'];
        $languages = $this->settingsHelper->getLanguages();
        return view('career::admin.career.editCareer', compact('contentsLocale', 'fields', 'seo', 'breadcrumbs', 'languages', 'old', 'career'));
    }
    public function update(Request $request)
    {

        $currentData = $this->careerHelper->get($request->career_id);

        $slug = Str::slug($request->title) . '-'. mt_rand(1000, 9999);
        $data = [
            'id' => $request->career_id,
            'status' => $request->status,
            'title' => $request->title,
            'category_id' => $request->category_id,
            'vaccancy' => $request->vaccancy,
            'experience' => $request->experience,
            'employment' => $request->employment,
            'section' => 'web',
            'slug' => $slug
        ];

        $career = $this->careerHelper->update($data);

        $data = [
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'skill' => $request->input('skill'),
            'job_profile' => $request->input('job_profile'),

        ];

        $names = $request->input('name');
        $languageCodes = array_keys($names);
        $title = $request->input('title');
        foreach ($languageCodes as $languageCode) {
            $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);
            if ($languageId) {
                $name = $names[$languageCode] ?? $title;
                $contentData = [
                    'language_id' => $languageId,
                    'career_id' => $career->id,
                    'name' => $name,
                    'employment' => $data['employment'][$languageCode] ?? null,
                    'location' => $data['location'][$languageCode] ?? null,
                    'skill' => $data['skill'][$languageCode] ?? null,
                    'job_profile' => $data['job_profile'][$languageCode] ?? null,
                ];
                $localeContentItem = $career->locales()->where('language_id', $languageId)->first();
                if ($localeContentItem) {
                    $localeContentItem->update($contentData);
                } else {
                    $this->localHelper->saveCareerLocale($contentData);

                    CareerLocale::create($contentData);
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
                'model_id' => $career->id,
            ];
            $this->seoHelper->update($seoData);
        }

        $event = auth()->user()->name . ' Updated the Career with Title ' . $currentData->title;
        activity('Careers')->performedOn($career)->event($event)->withProperties(['career_id' => $career->id, 'data' => $request->all(), 'old' => $currentData])->log('Career Updated');

        return redirect()->route('career_list')->with('success', 'Career Updated successfully');
    }
    public function delete(CareerDeleteRequest $request)
    {
        $career = $this->careerHelper->get($request->id);

        if ($this->careerHelper->delete($request->id)) {
            if ($request->ajax()) {

                activity()->performedOn($career)->event('Career  Deleted')->withProperties(['career_id' => $career->id])->log('Career Deleted');

                return response()->json(['status' => 1, 'message' => 'Career  deleted successfully']);
            } else {
                return redirect()->route('career_list')->with('success', 'Career  deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('career_list')->with('success', 'Failed to delete');
        }
    }
    public function optionsCategory(Request $request)
    {
        $term = trim($request->search);
        $categories = $this->categoryHelper->searchCategory($term);
        $categoryOption = [];

        foreach ($categories as $career) {
            $categoryOption[] = ['id' => $career->id, 'text' => $career->name_en];
        }
        
        return response()->json($categoryOption);
    }
    public function optionsCourses(Request $request)
    {
        $term = trim($request->search);
        $categories = $this->careerHelper->searchActiveCareer($term);
        $categoryOption = [];

        foreach ($categories as $career) {
            $categoryOption[] = ['id' => $career->id, 'text' => $career->name];
        }
        return response()->json($categoryOption);
    }
    public function view(CareerListRequest $request)
    {
        $career = $this->careerHelper->get($request->id);
        $contentsLocale = $this->careerHelper->getLocaleContents($request->id);
        $languages = $this->contentHelper->getAllLanguages();
        $seo = $this->seoHelper->getSeoByModelIdAndModel($career->id, 'Modules\Career\Entities\Career');

        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'career_list', 'name' => 'Contents', 'permission' => 'blog_read'],
            ['name' => 'View Career'],
        ];

        return view('career::admin.career.viewCareer', compact('career', 'seo', 'contentsLocale', 'languages', 'breadcrumbs'));
    }
}
