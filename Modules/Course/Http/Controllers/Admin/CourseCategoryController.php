<?php

namespace Modules\Course\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Cms\Entities\Language;
use Modules\Course\Entities\CourseCategoryLocal;
use Modules\Course\Helpers\CourseCategoryHelper;
use Modules\Course\Helpers\LocalHelper;
use Modules\Course\Http\Requests\Admin\CourseCategory\CourseCategoryAddRequest;
use Modules\Course\Http\Requests\Admin\CourseCategory\CourseCategoryCreateRequest;
use Modules\Course\Http\Requests\Admin\CourseCategory\CourseCategoryDeleteRequest;
use Modules\Course\Http\Requests\Admin\CourseCategory\CourseCategoryEditRequest;
use Modules\Course\Http\Requests\Admin\CourseCategory\CourseCategoryListDataRequest;
use Modules\Course\Http\Requests\Admin\CourseCategory\CourseCategoryListRequest;
use Modules\Course\Http\Requests\Admin\CourseCategory\CourseCategoryUpdateRequest;
use Modules\Settings\Helpers\SettingsHelper;
use Yajra\DataTables\DataTables;

class CourseCategoryController extends Controller
{
    protected $courseCategoryHelper,  $settingsHelper, $localHelper;

    public function __construct(CourseCategoryHelper $courseCategoryHelper, SettingsHelper $settingsHelper, LocalHelper $localHelper)
    {
        $this->courseCategoryHelper = $courseCategoryHelper;
        $this->settingsHelper = $settingsHelper;
        $this->localHelper = $localHelper;
    }

    public function listCategory(CourseCategoryListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Course Category'],
        ];
        $parentCategories = $this->courseCategoryHelper->getParentCategory();

        return view('course::admin.category.listCategory', compact('breadcrumbs', 'parentCategories'));
    }
    public function categoryListData(CourseCategoryListDataRequest $request)
    {
        $categories = $this->courseCategoryHelper->getCategoryDatatable($request->all());
        $dataTableJSON = DataTables::of($categories)
            ->addIndexColumn()
            ->editColumn('title', function ($category) {
                // $data['image'] = $category->image && Storage::disk('elegant')->exists($category->image) ? Storage::disk('elegant')->url($category->image) : asset('images/avatars/blank.png');
                $data['url'] = route('course_category_edit', ['id' => $category->id]);
                $data['text'] = $category->title;

                return view('elements.listLink', compact('data'));
            })

            ->addColumn('status', function ($category) {
                return view('elements.listStatus')->with('data', $category);
            })

            ->addColumn('action', function ($category) use ($request) {
                $data['edit_url'] = route('course_category_edit', ['id' => $category->id]);
                $data['delete_url'] = route('course_category_delete', ['id' => $category->id]);
                // $data['view_url'] = route('course_category_view', ['id' => $category->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }
    public function subCategoryListData(CourseCategoryListDataRequest $request)
    {
        $categories = $this->courseCategoryHelper->getsubCategoryDatatable($request->all());
        $dataTableJSON = DataTables::of($categories)
            ->addIndexColumn()
            ->editColumn('title', function ($category) {
                $data['url'] = route('course_category_edit', ['id' => $category->id]);
                $data['text'] = $category->title;

                return view('elements.listLink', compact('data'));
            })

            ->editColumn('parent_category', function ($category) {
                $data['view_url'] = route('course_category_view', ['id' => $category->id]);

                $data['text'] = $category->parent->slug ?? '';

                return view('elements.listLink', compact('data'));
            })

            ->addColumn('status', function ($category) {
                return view('elements.listStatus')->with('data', $category);
            })

            ->addColumn('action', function ($category) use ($request) {
                $data['edit_url'] = route('course_category_edit', ['id' => $category->id]);
                $data['delete_url'] = route('course_category_delete', ['id' => $category->id]);
                $data['view_url'] = route('course_category_view', ['id' => $category->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }
    public function viewCategory(CourseCategoryListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_category_list', 'name' => 'Course Category', 'permission' => 'course_category_read'],
            ['name' => 'View Course Category'],
        ];
        $category = $this->courseCategoryHelper->getCategory($request->id);
        return view('course::admin.category.viewCategory', compact('category', 'breadcrumbs'));
    }
    public function addCategory(CourseCategoryAddRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_category_list', 'name' => 'Course Category', 'permission' => 'course_category_read'],
            ['name' => 'Add Course Category'],
        ];
        $languages = $this->settingsHelper->getLanguages();


        return view('course::admin.category.addCategory', compact('breadcrumbs', 'languages'));
    }
    public function createCategory(Request $request)
    {
        $englishTitle = $request->input('title')['en'];

        $slug = Str::slug($englishTitle);
        $inputData = [
            'parent_category_id' => $request->parent_category_id,
            'slug' => $slug,
            'status' => $request->status,
            'section' => 'web',
        ];

        if ($request->hasFile('image')) {
            $filePath = 'category/image';
            $fileName = Storage::disk('elegant')->putFile($filePath, $request->file('image'));
            $inputData['image'] = $fileName;
        }
        $category = $this->courseCategoryHelper->save($inputData);

        $languageCodes = array_keys($request->input('title'));


        foreach ($languageCodes as $languageCode) {
            $languageId = $this->localHelper->getLanguageIdFromCode($languageCode); 

            if ($languageId) {
                $title = $request->input('title')[$languageCode];

                $localeData = [
                    'language_id' => $languageId,
                    'category_id' => $category->id,
                    'title' => $title,
                    'description' => $request->input('description')[$languageCode],
                ];

                if (!empty($title)) {
                    $this->localHelper->saveCourseCategoryLocal($localeData);
                }
            }
        }

        activity()->performedOn($category)->event('Course Category Created')->withProperties(['id' => $category->id, 'data' => $inputData])->log('Course Category Created');

        return redirect()
            ->route('course_category_list')
            ->with('success', 'Course Category added successfully');
    }
    public function editCategory(CourseCategoryEditRequest $request)
    {
        $old = [];
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_category_list', 'name' => 'Course Category', 'permission' => 'course_category_read'],
            ['name' => 'Category Details'],
        ];
        $category = $this->courseCategoryHelper->getCategory($request->id);
        if (old('parent_category_id', $category->parent_category_id)) {
            $old['parent_category_id'] = $this->courseCategoryHelper->getCategoryWithTitle(old('parent_category_id', $category->parent_category_id));
        }
        $languages = $this->settingsHelper->getLanguages();
        $categoriesLocale = $this->courseCategoryHelper->getLocaleContents($request->id);

        return view('course::admin.category.editCategory', compact('category',  'categoriesLocale', 'languages', 'breadcrumbs', 'old'));
    }

    public function updateCategory(CourseCategoryUpdateRequest $request)
    {
        $englishTitle = $request->input('title')['en'];

        $slug = Str::slug($englishTitle);
        $inputData = [
            'id' => $request->id,
            'section' => 'web',
            'slug' => $slug,
            'status' => $request->status,
            'parent_category_id' => $request->parent_category_id,
        ];
        
        // Handle image upload or removal
        if ($request->hasFile('image')) {
            $inputData['image'] = Storage::disk('elegant')->putFile('category/image', $request->file('image'));
        } elseif ($request->image_remove == 1) {
            $inputData['image'] = '';
        }
        
        // Update category
        $category = $this->courseCategoryHelper->update($inputData);
        
        $languageCodes = array_keys($request->input('title'));

        foreach ($languageCodes as $languageCode) {
            $languageId = $this->localHelper->getLanguageIdFromCode($languageCode); 

            if ($languageId) {
                $title = $request->input('title')[$languageCode];

                $localeData = [
                    'language_id' => $languageId,
                    'category_id' => $category->id,
                    'title' => $title,
                    'description' => $request->input('description')[$languageCode] ?? null,
                ];

                if (!empty($title)) {
                    $categoryLocale = $this->localHelper->getCourseCategoryWithLanguage($category->id, $languageId);

                    if ($categoryLocale) {
                        $categoryLocale->update($localeData);
                    } else {
                        $this->localHelper->saveCourseCategoryLocal($localeData);
                    }
                }
            }
        }

        activity()->performedOn($category)->event('Course Category Updated')->withProperties(['id' => $category->id, 'data' => $inputData])->log('Course Category Created');

        return redirect()
            ->route('course_category_list')
            ->with('success', 'Course updated successfully');
    }

    public function deleteCategory(CourseCategoryDeleteRequest $request)
    {
        if ($this->courseCategoryHelper->delete($request->id)) {
            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'Course Category deleted successfully']);
            } else {
                return redirect()->route('course_category_list')->with('success', 'Course Category deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('course_category_list')->with('success', 'Failed to delete');
        }
    }

    public function categoryOptions(Request $request)
    {
        $term = trim($request->search);
        $categories = $this->courseCategoryHelper->searchCategory($term);
        $categoriesOptions = [];

        foreach ($categories as $category) {
            $categoriesOptions[] = ['id' => $category->id, 'text' => $category->title];
        }

        return response()->json($categoriesOptions);
    }
}
