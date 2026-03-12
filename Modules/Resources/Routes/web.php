<?php

use Illuminate\Support\Facades\Route;
use Modules\Resources\Http\Controllers\Web\ResourceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('{locale}')->where(['locale' => 'ar|en'])->group(function () {
    Route::name('web_')->group(function () {
        Route::get('/free-resources/{slug}', [ResourceController::class, 'view'])->name('free_resource_view');
        Route::get('/quiz-detail', [ResourceController::class, 'quiz'])->name('free_resource_quiz');
        Route::get('/solution', [ResourceController::class, 'solution'])->name('free_resource_solution');
        Route::get('/analysis', [ResourceController::class, 'analysis'])->name('free_resource_analysis');

        route::get('/questions', [ResourceController::class, 'getQuestion'])->name('quiz_get_question');
        route::post('/questions/result', [ResourceController::class, 'result'])->name('quiz_result');

        route::get('/quiz/form', [ResourceController::class, 'form'])->name('free_resource_form');

        route::post('/quiz/form/submit', [ResourceController::class, 'saveForm'])->name('free_resource_form_submit');

        route::get('/quiz/questions', [ResourceController::class, 'getQAndA'])->name('free_resource_questions');


    });
});
