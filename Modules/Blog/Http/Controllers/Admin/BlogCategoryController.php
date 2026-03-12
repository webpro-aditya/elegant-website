<?php

namespace Modules\Blog\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Blog\Helpers\BlogCategoryHelper;
use Modules\Blog\Http\Requests\Admin\BlogCategory\BlogCategoryAddRequest;
use Modules\Blog\Http\Requests\Admin\BlogCategory\BlogCategoryCreateRequest;
use Modules\Blog\Http\Requests\Admin\BlogCategory\BlogCategoryListDataRequest;
use Modules\Blog\Http\Requests\Admin\BlogCategory\BlogCategoryListRequest;
use Modules\Blog\Http\Requests\Admin\BlogCategory\BlogCategoryEditRequest;
use Modules\Blog\Http\Requests\Admin\BlogCategory\BlogCategoryUpdateRequest;
use Modules\Blog\Http\Requests\Admin\BlogCategory\BlogCategoryDeleteRequest;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str; 
use Modules\Settings\Helpers\SettingsHelper;

class BlogCategoryController extends Controller
{
    protected $categoryHelper, $settingsHelper;

    public function __construct(BlogCategoryHelper $categoryHelper, SettingsHelper $settingsHelper)
    {
        $this->categoryHelper = $categoryHelper;
        $this->settingsHelper = $settingsHelper;

    }

    public function listCategory(BlogCategoryListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Blog Category'],
        ];

        return view('blog::admin.blogCategory.listCategory', compact('breadcrumbs'));
    }

    public function categoryListData(BlogCategoryListDataRequest $request)
    {
        $categories = $this->categoryHelper->getCategoryDatatable($request->all());
        $dataTableJSON = DataTables::of($categories)
            ->addIndexColumn()
            ->editColumn('name_en', function ($category) {
                $data['url'] = route('blog_category_edit', ['id' => $category->id]);
                $data['text'] = $category->name_en;

                return view('elements.listLink', compact('data'));
            })
            ->addColumn('status', function ($category) {
                return view('elements.listStatus')->with('data', $category);
            })
            ->addColumn('action', function ($category) use ($request) {
                $data['edit_url'] = route('blog_category_edit', ['id' => $category->id]);
                $data['delete_url'] = route('blog_category_delete', ['id' => $category->id]);


                return view('elements.listAction', compact('data'));
            })
            ->make(true);

        return $dataTableJSON;
    }


    public function addCategory(BlogCategoryAddRequest $request)
    {
        $languages = $this->settingsHelper->getLanguages();
        
        return view('blog::admin.blogCategory.addCategory',compact('languages'));
    }

    public function create(BlogCategoryCreateRequest $request)
    {
        $slug = Str::slug($request->name_en). '-' . mt_rand(000, 999);

        $inputData = [
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'name_sp' => $request->name_sp,
            'name_fr' => $request->name_fr,
            'slug' => $slug,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
            'section' => 'web',
        ];
        $catergory = $this->categoryHelper->save($inputData);

        activity()->performedOn($catergory)->event('Blog Category Created')->withProperties(['category_id' => $catergory->id, 'data' => $inputData])->log('Blog Category Created');

        return redirect()
            ->route('blog_category_list')
            ->with('success', 'Blog Category added successfully');
    }

    public function editCategory(BlogCategoryEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'blog_category_list', 'name' => 'Blog Category'],
            ['name' => 'Blog Category Details'],
        ];
        $category = $this->categoryHelper->getCategory($request->id);

        $languages = $this->settingsHelper->getLanguages();

        return view('blog::admin.blogCategory.editCategory', compact('breadcrumbs', 'category', 'languages'));
    }
    public function updateCategory(BlogCategoryUpdateRequest $request)
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
            'is_featured' => $request->is_featured,
            'section' => 'web',
        ];
        $catergory = $this->categoryHelper->update($inputData);

        activity()->performedOn($catergory)->event('Blog Category Updated')->withProperties(['category_id' => $catergory->id, 'data' => $inputData])->log('Blog Category Created');

        return redirect()
            ->route('blog_category_list')
            ->with('success', 'Blog updated successfully');
    }

    public function deleteCategory(BlogCategoryDeleteRequest $request)
    {
        $category = $this->categoryHelper->getCategory($request->id);

        if ($this->categoryHelper->delete($request->id)) {
            if ($request->ajax()) {

                activity()->performedOn($category)->event('Blog Category Deleted')->withProperties(['category_id' => $category->id])->log('Blog Category Deleted');

                return response()->json(['status' => 1, 'message' => 'Blog Category deleted successfully']);
            } else {
                return redirect()->route('blog_list')->with('success', 'Blog Category deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('Blog_list')->with('success', 'Failed to delete');
        }
    }

}
