<?php

use Illuminate\Support\Facades\Route;
use Modules\Course\Http\Controllers\Web\CourseController;
use Modules\Course\Http\Controllers\Web\HelpController;
use Spatie\Honeypot\ProtectAgainstSpam;

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
        Route::get('/category', [CourseController::class, 'category'])->name('category');
        Route::get('/courses', [CourseController::class, 'courses'])->name('courses');
        // Route::get('/course-list', [CourseController::class, 'courseList'])->name('course_list');
        Route::get('/course-list/{category?}', [CourseController::class, 'courseList'])->name('course_list');

        //Route::get('/course-detail', [CourseController::class, 'courseDetail'])->name('course_detail');
        Route::get('/course-detail/{course}', [CourseController::class, 'courseDetail'])->name('course_detail');

        Route::get('/order-summary', [CourseController::class, 'orderSummary'])->name('order_summary');
        Route::get('/help', [HelpController::class, 'help'])->name('help');
        Route::POST('/save-help', [HelpController::class, 'saveHelp'])->name('save_help');
        Route::middleware(ProtectAgainstSpam::class)->group(function () {
            Route::POST('/save-course-enquiry', [CourseController::class, 'saveCourseEnquiry'])->name('save_course_enquiry');
            Route::POST('/save-course-curriculm', [CourseController::class, 'saveCourseCurriculm'])->name('save_course_curriculm');
            Route::get('/download-curriculum/{path}', [CourseController::class, 'downloadCurriculum'])->name('download_curriculum');
        });
        Route::get('/search', [CourseController::class, 'searchCourse'])->name('course_search');
        Route::get('/training-calander', [CourseController::class, 'calender'])->name('training_calender');
        Route::post('/training-calander-list', [CourseController::class, 'calenderList'])->name('calender_list');
        Route::get('/course-finder', [CourseController::class, 'courseFinder'])->name('course_finder');
        Route::POST('/save-brochure', [HelpController::class, 'saveBrochure'])->name('save_brochure');
        Route::get('/verify-email', [HelpController::class, 'verifyEmail'])->name('verify_email');
        Route::get('/self-paced', [CourseController::class, 'selfPaced'])->name('self_paced');


        Route::post('/course-card', [CourseController::class, 'courseCard'])->name('course_card');

    });
});