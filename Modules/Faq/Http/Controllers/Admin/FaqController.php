<?php

namespace Modules\Faq\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Entities\Language;
use Modules\Faq\Entities\FaqLocal;
use Modules\Settings\Helpers\SettingsHelper;
use Yajra\DataTables\DataTables;
use Modules\Faq\Helpers\FaqHelper;
use Modules\Course\Helpers\CourseHelper;
use Modules\Course\Helpers\LocalHelper;
use Modules\Faq\Http\Requests\Admin\Faq\FaqAddRequest;
use Modules\Faq\Http\Requests\Admin\Faq\FaqCreateRequest;
use Modules\Faq\Http\Requests\Admin\Faq\FaqListDataRequest;
use Modules\Faq\Http\Requests\Admin\Faq\FaqListRequest;
use Modules\Faq\Http\Requests\Admin\Faq\FaqEditRequest;
use Modules\Faq\Http\Requests\Admin\Faq\FaqUpdateRequest;
use Modules\Faq\Http\Requests\Admin\Faq\FaqDeleteRequest;

class FaqController extends Controller
{
    protected $settingsHelper, $courseHelper, $faqHelper, $localHelper;
    public function __construct(SettingsHelper $settingsHelper, FaqHelper $faqHelper, CourseHelper $courseHelper, LocalHelper $localHelper)
    {
        $this->settingsHelper = $settingsHelper;
        $this->faqHelper = $faqHelper;
        $this->courseHelper = $courseHelper;
        $this->localHelper = $localHelper;
    }
    public function list(FaqListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'FAQ'],
        ];

        return view('faq::admin.listFaq', compact('breadcrumbs'));
    }
    public function table(FaqListDataRequest $request)
    {
        $faqs = $this->faqHelper->getDatatable($request->all());

        $dataTableJSON = DataTables::of($faqs)
            ->addIndexColumn()
            ->editColumn('question', function ($faq) {
                // $data['url'] = route('contents_view', ['slug' => $page->slug]);
                $data['text'] = $faq->question;

                return view('elements.listLink', compact('data'));
            })
            ->addColumn('status', function ($faq) {
                return view('elements.listStatus')->with('data', $faq);
            })
            ->addColumn('action', function ($faq) use ($request) {
                $data['edit_url'] = route('faq_edit', ['id' => $faq->id]);
                $data['delete_url'] = route('faq_delete', ['id' => $faq->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }
    public function add(FaqAddRequest $request)
    {
        $languages = $this->settingsHelper->getLanguages();

        return view('faq::admin.addFaq', compact('languages'));
    }
    public function save(FaqCreateRequest $request)
    {
        $data = [];
        $data = [
            'status' => $request->status,
            'model' => $request->model ?? 'Modules\Faq\Entities\Faq',
            'model_id' => $request->model_id ?? 1,
            'course_id' => $request->course_id,
        ];

        $faq = $this->faqHelper->save($data);

        $data = [
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
        ];

        $languageCodes = array_keys($request->input('question'));
        foreach ($languageCodes as $languageCode) {
            $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);

            if ($languageId) {
                $contentData = [
                    'language_id' => $languageId,
                    'faq_id' => $faq->id,
                    'question' => $data['question'][$languageCode],
                    'answer' => $data['answer'][$languageCode],
                ];
                if (array_filter($contentData, fn($value, $key) => !in_array($key, ['language_id', 'faq_id']) && !is_null($value), ARRAY_FILTER_USE_BOTH)) {
                    $this->localHelper->saveFaqLocal($contentData);
                }
            }
        }

        $event = auth()->user()->name . ' Added the Faq ';
        activity('Contents')->performedOn($faq)->event($event)->withProperties(['faq_id' => $faq->id, 'data' => $request->all()])->log('Faq Created');

        return redirect()->route('faq_list')->with('success', 'Faq added successfully');
    }
    public function edit(FaqEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'faq_list', 'name' => 'Faq', 'permission' => 'blog_read'],
            ['name' => 'FAQ Details'],
        ];

        $faq = $this->faqHelper->get($request->id);
        $old = [];

        if ($faq->course_id) {
            $old['course_id'] = $this->courseHelper->getCourseAndTitle($faq->course_id);
        }
        $contentsLocale = $this->faqHelper->getLocaleContents($request->id);
        $title = $contentsLocale['en']->first()->title;
        $languages = $this->settingsHelper->getLanguages();

        return view('faq::admin.editFaq', compact('faq', 'contentsLocale', 'title', 'breadcrumbs', 'languages', 'old'));
    }
    public function update(Request $request)
    {
        $currentData = $this->faqHelper->get($request->faq_id);

        $data = [];
        $data = [
            'id' => $request->faq_id,
            'status' => $request->status,
            'model' => $request->model ?? 'Modules\Faq\Entities\Faq',
            'model_id' => $request->model_id ?? 1,
            'course_id' => $request->course_id,
        ];

        $faq = $this->faqHelper->update($data);

        $data = [
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
        ];


        $languageCodes = array_keys($request->input('question'));
        foreach ($languageCodes as $languageCode) {
            $languageId = $this->localHelper->getLanguageIdFromCode($languageCode);
            if ($languageId) {
                $contentData = [
                    'language_id' => $languageId,
                    'faq_id' => $faq->id,
                    'question' => $data['question'][$languageCode],
                    'answer' => $data['answer'][$languageCode],
                ];
                $localeContentItem = $faq->locales()->where('language_id', $languageId)->first();
                if ($localeContentItem) {
                    $localeContentItem->update($contentData);
                } else {
                    $this->localHelper->saveFaqLocal($contentData);
                }
            }
        }

        $event = auth()->user()->name . ' Updated the Faq ';
        activity('FAQ')->performedOn($faq)->event($event)->withProperties(['faq_id' => $faq->id, 'data' => $request->all(), 'old' => $currentData])->log('Faq Updated');

        return redirect()->route('faq_list')->with('success', 'Faq Updated successfully');
    }
    public function delete(FaqDeleteRequest $request)
    {
        $faq = $this->faqHelper->get($request->id);

        if ($this->faqHelper->delete($request->id)) {
            if ($request->ajax()) {

                activity()->performedOn($faq)->event('Faq  Deleted')->withProperties(['faq_id' => $faq->id])->log('Faq Deleted');

                return response()->json(['status' => 1, 'message' => 'Faq  deleted successfully']);
            } else {
                return redirect()->route('faq_list')->with('success', 'Faq  deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('faq_list')->with('success', 'Failed to delete');
        }
    }
}
