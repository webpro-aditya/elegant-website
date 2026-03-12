<?php

namespace Modules\Resources\Helpers\web;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Cms\Entities\Language;
use Modules\Resources\Entities\FreeResource;
use Modules\Resources\Entities\QuizLocal;
use Modules\Resources\Entities\QuizResult;
use Modules\Resources\Entities\ResourceContent;
use Modules\Resources\Entities\ResourceContentLocal;
use Modules\Resources\Entities\ResourceLocal;
use Illuminate\Support\Str;

class ResourceHelper
{
    public function getDataWithType($type)
    {
        return FreeResource::where('status', 'active')->where('type', $type)->with('locales', 'contents')->get();
    }

    public function getResource($slug)
    {
        return FreeResource::where('slug', $slug)
            ->with(['locales', 'contents'])
            ->when(FreeResource::where('slug', $slug)->has('quizzes'), function ($query) {
                $query->with('quizzes.defaultLocale');
            })
            ->first();
    }
    public function getResourceContents($resource_id)
    {
        return ResourceContent::where('resource_id', $resource_id)->with('resource', 'defaultLocale', 'locales')->get();
    }

    public function getLatestResources($slug)
    {
        return FreeResource::with(['locales', 'contents'])
            ->where('slug', '!=', $slug)
            ->where('is_popular', 'yes')
            ->take(3)
            ->get();
    }

    public function getQuiz($id)
    {
        return FreeResource::where('id', $id) ->with(['locales', 'contents', 'quizzes.locales'])->first();

    }

    public function getQuizResult($id){

        return QuizResult::where('id', $id)->first();

    }

    public function saveQuizResult($resourceId){
        $quizResult = QuizResult::create([
            'resource_id' => $resourceId,
            'name' => 'Player_' . Str::random(5),
            'result' => json_encode([]) // Initialize result as empty JSON
        ]);

        return $quizResult;
    }

    public function findQuizResult($id){
        return  QuizResult::find($id);
    }

    public function saveQuiz($data, $id){
        $quiz = QuizResult::find($id);
        if ($quiz) {
            $quiz->update($data);
            return $quiz;
        }
        return null; // Return null if the quiz result is not found
    }

    public function getQuizeLocaleQuestions($id){
        return QuizLocal::whereIn('quiz_id', $id)->get();
    }

    public function getPlayerRankAndStatus($quizResult)
    {
        $allResults = QuizResult::where('resource_id', $quizResult->quiz_id)
            ->orderBy('score', 'desc')
            ->get();

        $rank = $allResults->search(function ($result) use ($quizResult) {
            return $result->id === $quizResult->id;
        }) + 1; // +1 because search returns zero-based index

        $status = $this->determineStatus($quizResult->score, $quizResult->resource->quizzes->count());

        return [
            'rank' => $rank,
            'totalPlayers' => $allResults->count(),
            'status' => $status
        ];
    }

    private function determineStatus($score, $totalQuestions)
    {
        if ($totalQuestions === 0) {
            return 'No Questions'; // Edge case for quizzes without questions
        }
    
        // Calculate the percentage score
        $percentage = ($score / $totalQuestions) * 100;
    
        // Determine status based on percentage
        if ($percentage >= 90) {
            return 'Excellent';
        } elseif ($percentage >= 75) {
            return 'Good';
        } elseif ($percentage >= 50) {
            return 'Average';
        } else {
            return 'Poor';
        }
    }
    
    public function getQuizQuestionStatus($quizResult)
    {
        $questions = $this->getQuizeLocaleQuestions($quizResult->resource->quizzes->pluck('id'));
        $userAnswers = json_decode($quizResult->result, true);

        $questionStatuses = [];

        foreach ($questions as $index => $question) {
            $questionNumber = $index + 1;
            $correctAnswer = $question->answer;
            $selectedOptionIndex = $userAnswers[$question->id] ?? null;

            if (is_null($selectedOptionIndex)) {
                $status = 'skipped';
            } else {
                $options = json_decode($question->options, true);
                $selectedOption = $options[$selectedOptionIndex - 1] ?? null;
                $status = $selectedOption === $correctAnswer ? 'correct' : 'incorrect';
            }

            $questionStatuses[] = [
                'number' => $questionNumber,
                'status' => $status,
            ];
        }

        return $questionStatuses;
    }
}
