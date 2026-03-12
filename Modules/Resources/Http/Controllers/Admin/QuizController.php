<?php

namespace Modules\Resources\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Entities\Language;
use Modules\Resources\Entities\QuizLocal;
use Modules\Resources\Helpers\admin\quiz\QuizHelper;
use Yajra\DataTables\DataTables;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Resources\Helpers\admin\freeResource\FreeResourceHelper;

class QuizController extends Controller
{
    protected $quizHelper;
    protected $settingsHelper;
    protected $resourceHelper;
    public function __construct(QuizHelper $quizHelper, SettingsHelper $settingsHelper, FreeResourceHelper $resourceHelper)
    {
        $this->quizHelper = $quizHelper;
        $this->settingsHelper = $settingsHelper;
        $this->resourceHelper = $resourceHelper;
    }
    public function table(Request $request)
    {
        $quizzes = $this->quizHelper->getDatatable($request->all());
        $dataTableJSON = DataTables::of($quizzes)
            ->addIndexColumn()
            ->editColumn('question', function ($quiz) {
                return $quiz->name_for_language_1;
            })
            ->addColumn('status', function ($quiz) {
                return view('elements.listStatus')->with('data', $quiz);
            })
            ->addColumn('action', function ($quiz) use ($request) {
                $data['edit_url'] = route('free_resource_quiz_edit', ['id' => $quiz->id]);
                $data['delete_url'] = route('free_resource_quiz_delete', ['id' => $quiz->id]);
    
                return view('elements.listAction', compact('data'));

            })
            ->make();

        return $dataTableJSON;
    }
    public function add(Request $request)
    {
        $languages = $this->settingsHelper->getLanguages();
        $resource_id = $request->resource_id;

        $responce['html'] = (string) view('resources::admin.quizContent.addQuizContent', compact('languages', 'resource_id'));
        $responce['scripts'][] = (string) mix('js/admin/quiz/addQuizContent.js');
        $responce['style'][] = (string) mix('css/admin/quiz/addQuizContent.css');

        return $responce;
    }
    public function save(Request $request)
    {

        $data = [];

        $data = [
            'resource_id' => $request->resource_id,
            'value' => $request->input('value') ?? 1,
            'status' => $request->input('status'),
        ];

        $quiz = $this->quizHelper->save($data);


        $data = [
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'options' => $request->input('options'),
            'quiz_id' => $quiz->id,
        ];

        $languageCodes = array_keys($data['question']);

        foreach ($languageCodes as $languageCode) {
            $languageId = Language::where('code', $languageCode)->value('id');

            if ($languageId) {
                $contentData = [
                    'quiz_id' => $data['quiz_id'],
                    'language_id' => $languageId,
                    'question' => $data['question'][$languageCode],
                    'answer' => $data['answer'][$languageCode] ?? null,
                    'options' => json_encode($data['options'][$languageCode]),
                ];

                QuizLocal::updateOrCreate(
                    [
                        'quiz_id' => $data['quiz_id'],
                        'language_id' => $languageId,
                    ],
                    $contentData
                );
            }
        }

        $event = auth()->user()->name . ' Added the Free Resource (Quiz) Content';
        activity('Free Resources (Quiz) Content')->performedOn($quiz)->event($event)->withProperties(['quiz_id' => $quiz->id, 'data' => $request->all()])->log('Resource Content (Quiz) Created');

        return redirect()->back()
            ->with('success', 'Quiz added successfully');
    }
    public function edit(Request $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'free_resource_list', 'name' => 'Free Resource', 'permission' => 'free_resource_read'],
            ['name' => 'Resource Content Details'],
        ];

        $quiz = $this->quizHelper->get($request->id);
        $contentsLocale = $this->quizHelper->getQuizContents($request->id);
        $languages = $this->settingsHelper->getLanguages();

        return view('resources::admin.quizContent.editQuizContent', compact('quiz', 'contentsLocale', 'breadcrumbs', 'languages'));
    }

    public function update(Request $request)
    {
        $currentData = $this->quizHelper->get($request->id);

        $data = [];

        $data = [
            'id' => $request->id,
            'value' => $request->input('value') ?? 1,
            'status' => $request->input('status'),
        ];

        $quiz = $this->quizHelper->update($data);


        $data = [
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'options' => $request->input('options'),
            'quiz_id' => $quiz->id,
        ];

        $languageCodes = array_keys($data['question']);

        foreach ($languageCodes as $languageCode) {
            $languageId = Language::where('code', $languageCode)->value('id');

            if ($languageId) {
                $contentData = [
                    'quiz_id' => $data['quiz_id'],
                    'language_id' => $languageId,
                    'question' => $data['question'][$languageCode],
                    'answer' => $data['answer'][$languageCode] ?? null,
                    'options' => json_encode($data['options'][$languageCode]),
                ];

                $localeContentItem = $quiz->locales()->where('language_id', $languageId)->first();
                if ($localeContentItem) {
                    $localeContentItem->update($contentData);
                } else {
                    QuizLocal::create($contentData);
                }
            }
        }

        $event = auth()->user()->name . ' Updated the Free Resource Content';
        activity('Free Resources (Quiz) Content')->performedOn($quiz)->event($event)->withProperties(['quiz_id' => $quiz->id, 'data' => $currentData])->log('Resource Content (Quiz) Updated');

        return redirect()
            ->route('free_resource_view', ['id' => $quiz->resource_id])
            ->with('success', 'Quiz updated successfully');
    }
    public function delete(Request $request)
    {
        $quiz = $this->quizHelper->get($request->id);

        if ($this->quizHelper->delete($request->id)) {
            if ($request->ajax()) {

                activity()->performedOn($quiz)->event('Quiz Deleted')->withProperties(['quiz_id' => $quiz->id])->log('Quiz Deleted');

                return response()->json(['status' => 1, 'message' => 'Quiz deleted successfully']);
            } else {
                return redirect()->route('free_resource_list')->with('success', 'Quiz deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('free_resource_list')->with('success', 'Failed to delete');
        }
    }

}
