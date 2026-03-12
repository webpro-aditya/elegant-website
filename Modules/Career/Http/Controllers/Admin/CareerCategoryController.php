<?php

namespace Modules\Career\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str; 
use Modules\Career\Http\Requests\Admin\CareerCategory\CareerCategoryDeleteRequest;
use Modules\Career\Http\Requests\Admin\CareerCategory\CareerCategoryEditRequest;
use Modules\Career\Http\Requests\Admin\CareerCategory\CareerCategoryUpdateRequest;
use Yajra\DataTables\DataTables;
use Modules\Career\Helpers\CareerCategoryHelper;
use Modules\Career\Http\Requests\Admin\CareerCategory\CareerCategoryAddRequest;
use Modules\Career\Http\Requests\Admin\CareerCategory\CareerCategoryCreateRequest;
use Modules\Career\Http\Requests\Admin\CareerCategory\CareerCategoryListDataRequest;
use Modules\Career\Http\Requests\Admin\CareerCategory\CareerCategoryListRequest;
use Modules\Settings\Helpers\SettingsHelper;

class CareerCategoryController extends Controller
{
    protected $categoryHelper, $settingsHelper;
    public function __construct(SettingsHelper $settingsHelper, CareerCategoryHelper $categoryHelper)
    {
        $this->categoryHelper = $categoryHelper;
        $this->settingsHelper = $settingsHelper;
    }

    public function list(CareerCategoryListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Career Category'],
        ];

        return view('career::admin.careerCategory.listCategory', compact('breadcrumbs'));
    }

    public function listData(CareerCategoryListDataRequest $request)
    { 
        $categories = $this->categoryHelper->getCategoryDatatable($request->all());
        $dataTableJSON = DataTables::of($categories)
            ->addIndexColumn()
            ->editColumn('name_en', function ($category) {
                $data['url'] = route('career_category_edit', ['id' => $category->id]);
                $data['text'] = $category->name_en;

                return view('elements.listLink', compact('data'));
            })
            ->addColumn('status', function ($category) {
                return view('elements.listStatus')->with('data', $category);
            })
            ->addColumn('action', function ($category) use ($request) {
                $data['edit_url'] = route('career_category_edit', ['id' => $category->id]);
                $data['delete_url'] = route('career_category_delete', ['id' => $category->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make(true);

        return $dataTableJSON;
    }

    public function add(CareerCategoryAddRequest $request)
    {
        $languages = $this->settingsHelper->getLanguages();

        return view('career::admin.careerCategory.addCategory', compact('languages'));
    } 

    public function create(CareerCategoryCreateRequest $request)
    {
        $slug = Str::slug($request->name_en). '-' . mt_rand(000, 999);

        $inputData = [
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'name_sp' => $request->name_sp,
            'name_fr' => $request->name_fr,
            'slug' => $slug,
            'status' => $request->status,
            'section' => 'web',
        ];
        $catergory = $this->categoryHelper->save($inputData);

        activity()->performedOn($catergory)->event('Career Category Created')->withProperties(['category_id' => $catergory->id, 'data' => $inputData])->log('Career Category Created');

        return redirect()
            ->route('career_category_list')
            ->with('success', 'Career Category added successfully');
    }

    public function edit(CareerCategoryEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'career_category_list', 'name' => 'Career Category'],
            ['name' => 'Career Category Details'],
        ];
        $category = $this->categoryHelper->getCategory($request->id);

        $languages = $this->settingsHelper->getLanguages();

        return view('career::admin.careerCategory.editCareerCategory', compact('breadcrumbs', 'category', 'languages'));
    }

    public function update(CareerCategoryUpdateRequest $request)
    {
        $slug = Str::slug($request->name_en). '-' . mt_rand(000, 999);

        $inputData = [
            'id' => $request->id,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'name_sp' => $request->name_sp,
            'name_fr' => $request->name_fr,
            'slug' => $slug,
            'status' => $request->status,
            'section' => 'web',
        ];
        $catergory = $this->categoryHelper->update($inputData);

        activity()->performedOn($catergory)->event('Career Category Updated')->withProperties(['category_id' => $catergory->id, 'data' => $inputData])->log('Career Category Created');

        return redirect()
            ->route('career_category_list')
            ->with('success', 'Career updated successfully');
    }

    public function delete(CareerCategoryDeleteRequest $request)
    {
        $category = $this->categoryHelper->getCategory($request->id);

        if ($this->categoryHelper->delete($request->id)) {
            if ($request->ajax()) {

                activity()->performedOn($category)->event('Career Category Deleted')->withProperties(['category_id' => $category->id])->log('Blog Category Deleted');

                return response()->json(['status' => 1, 'message' => 'Career Category deleted successfully']);
            } else {
                return redirect()->route('career_category_list')->with('success', 'Career Category deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('career_category_list  ')->with('success', 'Failed to delete');
        }
    }
}
