<?php

namespace Modules\Author\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Author\Entities\AuthorLocal;
use Modules\Cms\Entities\Language;
use Modules\Settings\Helpers\SettingsHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Author\Helpers\admin\AuthorHelper;
use Yajra\DataTables\DataTables;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Author\Http\Requests\Admin\AuthorAddRequest;
use Modules\Author\Http\Requests\Admin\AuthorUpdateRequest;
use Modules\Author\Http\Requests\Admin\AuthorCreateRequest;
use Modules\Author\Http\Requests\Admin\AuthorDeleteRequest;
use Modules\Author\Http\Requests\Admin\AuthorEditRequest;
use Modules\Author\Http\Requests\Admin\AuthorListRequest;
use Modules\Author\Http\Requests\Admin\AuthorListDataRequest;
use Modules\Course\Helpers\LocalHelper;

class AuthorController extends Controller
{
    protected $settingsHelper, $authorHelper, $contentHelper, $localHelper;
    public function __construct(LocalHelper $localHelper, SettingsHelper $settingsHelper, AuthorHelper $authorHelper,  ContentHelper $contentHelper)
    {
        $this->settingsHelper = $settingsHelper;
        $this->authorHelper = $authorHelper;
        $this->contentHelper = $contentHelper;
        $this->localHelper = $localHelper;
    }
    public function add(AuthorAddRequest $request)
    {
        $languages = $this->settingsHelper->getLanguages();

        return view('author::admin.addAuthor', compact('languages'));
    }
    public function save(Request $request)
    {
        $data = [];
        $slug =  Str::slug($request->input('name.en') . '-' . rand(1000, 9999)); // Adjust 'en' to the actual key used for English

        $data = [
            'status' => $request->status,
            'facebook' => $request->facebook ?? 'no facebook',
            'twitter' => $request->twitter ?? 'no twitter',
            'instagram' => $request->instagram ?? 'no instagram',
            'slug' => $slug,
        ];

        if ($request->hasFile('thumbnail')) {
            $filePath = 'author/thumbnail';
            $data['thumbnail'] = Storage::disk('elegant')->putFile($filePath, $request->file('thumbnail'));
        } elseif ($request->has('thumbnail_remove') && $request->thumbnail_remove) {
            $data['thumbnail'] = '';
        }

        $author = $this->authorHelper->save($data);

        $data = [
            'name' => $request->input('name'),
            'short_desc' => $request->input('short_desc'),
        ];

        $languageCodes = array_keys($request->input('name'));

        foreach ($languageCodes as $languageCode) {
            $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);
            if ($languageId) {
                $name = $data['name'][$languageCode];
                $contentData = [
                    'language_id' => $languageId,
                    'author_id' => $author->id,
                    'name' => $name,
                    'short_description' => $data['short_desc'][$languageCode] ?? null,
                ];
                $this->localHelper->saveAuthorLocal($contentData);
            }
        }

        $event = auth()->user()->name . ' Added the Author ';
        activity('Contents')->performedOn($author)->event($event)->withProperties(['author_id' => $author->id, 'data' => $request->all()])->log('Author Created');

        return redirect()->route('author_list')->with('success', 'Author added successfully');
    }
    public function list(AuthorListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Author'],
        ];

        return view('author::admin.listAuthor', compact('breadcrumbs'));
    }
    public function listTable(AuthorListDataRequest $request)
    {
        $authors = $this->authorHelper->getDatatable($request->all());
        // dd($authors);
        $dataTableJSON = DataTables::of($authors)
            ->addIndexColumn()
            ->editColumn('name', function ($author) {
                // $data['url'] = route('contents_view', ['slug' => $page->slug]);
                $locale = $author->locales->first(); // safely gets the first related locale or null
                $data['text'] = $locale->name ?? '–'; // null-safe

                return view('elements.listLink', compact('data'));
            })
            ->addColumn('status', function ($author) {
                return view('elements.listStatus')->with('data', $author);
            })
            ->addColumn('action', function ($author) use ($request) {
                $data['view_url'] = route('author_view', ['id' => $author->id]);
                $data['edit_url'] = route('author_edit', ['id' => $author->id]);
                $data['delete_url'] = route('author_delete', ['id' => $author->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }
    public function edit(AuthorEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'author_list', 'name' => 'Author', 'permission' => 'author_read'],
            ['name' => 'Author Details'],
        ];

        $author = $this->authorHelper->get($request->id);

        $contentsLocale = $this->authorHelper->getLocaleContents($request->id);
        $name = $contentsLocale['en']->first()->name;
        $languages = $this->settingsHelper->getLanguages();

        return view('author::admin.editAuthor', compact('author', 'contentsLocale', 'name', 'breadcrumbs', 'languages'));
    }
    public function update(Request $request)
    {
        $currentData = $this->authorHelper->get($request->author_id);

        $slug =  Str::slug($request->input('name.en') . '-' . rand(1000, 9999)); // Adjust 'en' to the actual key used for English
        $data = [
            'id' => $request->author_id,
            'status' => $request->status,
            'facebook' => $request->facebook ?? 'no facebook',
            'twitter' => $request->twitter ?? 'no twitter',
            'instagram' => $request->instagram ?? 'no instagram',
            'slug' => $slug,
        ];

        if ($request->hasFile('thumbnail')) {
            $filePath = 'author/thumbnail';
            $data['thumbnail'] = Storage::disk('elegant')->putFile($filePath, $request->file('thumbnail'));
        } elseif ($request->has('thumbnail_remove') && $request->thumbnail_remove) {
            $data['thumbnail'] = '';
        }

        $author = $this->authorHelper->update($data);

        $data = [
            'name' => $request->input('name'),
            'short_desc' => $request->input('short_desc'),
        ];

        $languageCodes = array_keys($request->input('name'));

        foreach ($languageCodes as $languageCode) {
            $languageId = Language::where('code', $languageCode)->value('id');
            if ($languageId) {

                $contentData = [
                    'language_id' => $languageId,
                    'author_id' => $author->id,
                    'name' => $data['name'][$languageCode],
                    'short_description' => $data['short_desc'][$languageCode] ?? null,
                ];

                $localeContentItem = $author->locales()->where('language_id', $languageId)->first();
                if ($localeContentItem) {
                    $localeContentItem->update($contentData);
                } else {
                    AuthorLocal::create($contentData);
                }
            }
        }

        $event = auth()->user()->name . ' Updated the Author';
        activity('Author')->performedOn($author)->event($event)->withProperties(['author_id' => $author->id, 'data' => $request->all(), 'old' => $currentData])->log('Author Updated');

        return redirect()->route('author_list')->with('success', 'Author Updated successfully');
    }
    public function delete(AuthorDeleteRequest $request)
    {
        $author = $this->authorHelper->get($request->id);

        if ($this->authorHelper->delete($request->id)) {
            if ($request->ajax()) {

                activity()->performedOn($author)->event('Author  Deleted')->withProperties(['author_id' => $author->id])->log('Author Deleted');

                return response()->json(['status' => 1, 'message' => 'Author  deleted successfully']);
            } else {
                return redirect()->route('author_list')->with('success', 'Author  deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('author_list')->with('success', 'Failed to delete');
        }
    }
    public function viewAuthor(Request $request)
    {
        $author = $this->authorHelper->get($request->id);
        $contentsLocale = $this->authorHelper->getLocaleContents($request->id);
        $englishLocale = $contentsLocale['en']->first();
        $englishName = $englishLocale->name;
        $languages = $this->contentHelper->getAllLanguages();
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'blog_list', 'name' => 'Contents', 'permission' => 'blog_read'],
            ['name' => 'View Blog'],
        ];

        return view('author::admin.viewAuthor', compact('author', 'contentsLocale', 'englishName', 'languages', 'breadcrumbs'));
    }
    public function optionsAuthor(Request $request)
    {
        $term = trim($request->search);
        $authors = $this->authorHelper->searchAuthor($term);
        $authorOption = [];

        foreach ($authors as $author) {
            $authorOption[] = ['id' => $author->id, 'text' => $author->locales()->where('language_id', Language::where('code', 'en')->value('id'))->value('name')];
        }

        return response()->json($authorOption);
    }
}
