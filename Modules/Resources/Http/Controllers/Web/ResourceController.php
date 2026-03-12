<?php

namespace Modules\Resources\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Resources\Helpers\web\ResourceHelper;
use Modules\Translation\Helpers\TranslationHelper;
use Modules\Resources\Entities\QuizResult;

class ResourceController extends Controller
{
    protected $resourceHelper;
    protected $settingsHelper;
    protected $contentHelper;
    protected $translationHelper;

    public function __construct(SettingsHelper $settingsHelper, ResourceHelper $resourceHelper, ContentHelper $contentHelper, TranslationHelper $translationHelper)
    {
        $this->settingsHelper = $settingsHelper;
        $this->resourceHelper = $resourceHelper;
        $this->contentHelper = $contentHelper;
        $this->translationHelper = $translationHelper;
    }

    public function view(Request $request)
    {
        $resource = $this->resourceHelper->getResource($request->slug);
        $contents = $this->resourceHelper->getResourceContents($resource->id);
        $latests = $this->resourceHelper->getLatestResources($request->slug);
        $translations = $this->translationHelper->getKeyValue();

        return view('resources::web.listResource', compact('resource', 'contents', 'latests', 'translations'));
    }

    public function quiz(Request $request)
    {
        $quiz = $this->resourceHelper->getResource($request->quiz);
        $translations = $this->translationHelper->getKeyValue();

        return view('resources::web.quiz', compact('quiz', 'translations'));
    }

    public function solution(Request $request)
    {
        $resource = $this->resourceHelper->getResource($request->slug);
        $translations = $this->translationHelper->getKeyValue();

        return view('resources::web.solution', compact('resource', 'translation'));
    }
    public function  analysis(Request $request)
    {
        $result = $this->resourceHelper->getQuizResult($request->result);
        $data = $this->resourceHelper->getPlayerRankAndStatus($result);
        $questionStatuses = $this->resourceHelper->getQuizQuestionStatus($result);

        return view('resources::web.analysis', compact('result', 'data', 'questionStatuses'));
    }

    public function getQuestion(Request $request)
    {
        // Check if the session has `quiz_question_id`, if not, render the null response early
        // if (!$request->session()->has('quiz_question_id')) {
        //     return $this->renderQuestionView(null, null, null);
        // }

        $quiz = $this->resourceHelper->getQuiz($request->quizId);
        $question = $quiz->quizzes()->with('locales')->skip($request->number - 1)->first();

        $questionText = $question->defaultLocale->question ?? null;
        $options = $question->defaultLocale->options ? json_decode($question->defaultLocale->options) : null;

        return $this->renderQuestionView($request->number, $questionText, $options);
    }

    protected function renderQuestionView($questionNumber, $question, $options)
    {
        $html = view('resources::web.quiz.options', compact('questionNumber', 'question', 'options'))->render();
        return response()->json(['html' => $html]);
    }


    public function result(Request $request)
    {
        $questionId = $request->input('questionId');
        $optionIndex = $request->input('optionIndex');
        $quizId = $request->input('quizId');

        if (!$request->session()->has('quiz_player_id')) {
            $quizResult = $this->resourceHelper->saveQuizResult($quizId);
            Session::put('quiz_player_id', $quizResult->id);
        } else {
            $quizResult = $this->resourceHelper->findQuizResult(Session::get('quiz_player_id'));
        }

        $currentResults = json_decode($quizResult->result, true);

        $currentResults[$questionId] = $optionIndex;

        $quizResult->result = json_encode($currentResults);
        $quizResult->save();

        return response()->json(['status' => 'success', 'message' => 'Answer saved']);
    }

    public function form(Request $request)
    {
        $responce['html'] = (string) view('resources::web.quiz.form');
        $responce['scripts'][] = (string) mix('js/web/quiz/form.js');

        return $responce;
    }

    public function saveForm(Request $request)
    {
        $quizPlayerId = Session::get('quiz_player_id');

        if(!$quizPlayerId){
            return redirect()->back()->with('error', 'Form Submitted Failed');
        }

        $quizResult = $this->resourceHelper->getQuizResult($quizPlayerId);

        $scoreData = $this->calculateScore($quizResult);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'time_taken' => $request->quiz_time,
            'score' => $scoreData['score'],
            'accuracy' => $scoreData['accuracy']
        ];

        $result = $this->resourceHelper->saveQuiz($data, $quizPlayerId);

        Session::forget('quiz_player_id');

        if ($result) {
            $locale =  app()->getLocale();
            return redirect()->route('web_free_resource_analysis', compact('locale', 'result'))
                ->with('success', 'Form Submitted Successfully');
        } else {
            return redirect()->back()->with('error', 'Form Submitted Failed');
        }
    }

    private function calculateScore($quizResult)
    {
        // Initialize counters for correct answers and total questions
        $correctAnswersCount = 0;
        $totalQuestions = 0;

        // Decode the user's answers
        $userResults = json_decode($quizResult->result, true);

        // Retrieve all quiz questions for this resource through its quizzes
        $questions = $this->resourceHelper->getQuizeLocaleQuestions($quizResult->resource->quizzes->pluck('id'));

        // Iterate over each question in QuizLocal to compare the answers
        foreach ($questions as $question) {
            $totalQuestions++;

            // Get the correct answer for the question
            $correctAnswer = $question->answer;

            // Check if there is an answer in the user's results for this question
            if (isset($userResults[$question->id])) {
                $selectedOptionIndex = $userResults[$question->id];

                // Decode the options array to get the selected option text
                $options = json_decode($question->options, true);
                $selectedOption = $options[$selectedOptionIndex - 1] ?? null; // Adjust index if options are zero-indexed

                // Compare the selected option with the correct answer
                if ($selectedOption === $correctAnswer) {
                    $correctAnswersCount++;
                }
            }
        }

        // Calculate score (e.g., each correct answer = 1 point)
        $score = $correctAnswersCount;

        // Calculate accuracy (percentage)
        $accuracy = $totalQuestions > 0 ? ($correctAnswersCount / $totalQuestions) * 100 : 0;


        return [
            'correctAnswersCount' => $correctAnswersCount,
            'totalQuestions' => $totalQuestions,
            'score' => $score,
            'accuracy' => $accuracy,
        ];
    }

    public function getQAndA(Request $request)
    {
        $quiz = $this->resourceHelper->getQuiz($request->resourceId);

        $foundQuestion = null; // To hold the found question

        foreach ($quiz->quizzes as $quizItem) {

            foreach ($quizItem->locales as $locale) {

                if ($locale->id == $request->questionId) {
                    $foundQuestion = $locale; // Store the found question


                    break 2; // Break out of both loops
                }
            }
        }
        $response = [
            'question' => $foundQuestion->question, // Assuming the question text is stored in the 'text' column
            'options' => $foundQuestion->options, // Adjust based on your options relation
            'answer' => $foundQuestion->answer // Adjust based on your options relation
        ];

        return response()->json($response);
    }
}
