<?php

namespace Modules\Course\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth:admin')->prefix('course')->name('course_')->group(function () {

    Route::get('/', [CourseController::class, 'listCourse'])->name('list');
    Route::post('table', [CourseController::class, 'courseListData'])->name('table');
    Route::get('add', [CourseController::class, 'addCourse'])->name('add');
    Route::post('create', [CourseController::class, 'createCourse'])->name('create');
    Route::get('edit', [CourseController::class, 'editCourse'])->name('edit');
    Route::post('update', [CourseController::class, 'updateCourse'])->name('update');
    Route::post('status_change', [CourseController::class, 'statusChange'])->name('status_change');
    Route::delete('delete', [CourseController::class, 'deleteCourse'])->name('delete');

    Route::get('section-categories', [CourseController::class, 'sectionWiseCategories'])->name('section_wise_categories');

    Route::get('course/from-categories', [CourseController::class, 'getCoursesFromCategory'])->name('from_category');


    Route::get('courses-options', [CourseController::class, 'optionsSearchCourse'])->name('options_courses');

    // Route::get('all-categories', [CourseController::class, 'optionsAllCategories'])->name('all_categories');

    Route::get('sub-categories', [CourseController::class, 'optionsSubCategories'])->name('options_sub_categories');

    Route::get('active-courses', [CourseController::class, 'activeCourses'])->name('active_courses');

    Route::get('all-categories', [CourseCategoryController::class, 'categoryOptions'])->name('all_categories');

    Route::get('all-titles', [SyllabusController::class, 'titleOptions'])->name('all_titles');

    // View Routes
    Route::get('view', [CourseController::class, 'viewCourse'])->name('view');

    /**
     * Settings
     */
    Route::get('settings', [CourseController::class, 'courseSettingsView'])->name('settings');
    Route::post('settings/save', [CourseController::class, 'saveSettings'])->name('save_settings');

    /**
     * Course Category
     */
    Route::middleware('auth:admin')->prefix('category')->name('category_')->group(function () {
        Route::get('/', [CourseCategoryController::class, 'listCategory'])->name('list');
        Route::post('table', [CourseCategoryController::class, 'categoryListData'])->name('table');
        Route::get('add', [CourseCategoryController::class, 'addCategory'])->name('add');
        Route::post('create', [CourseCategoryController::class, 'createCategory'])->name('create');
        Route::get('view', [CourseCategoryController::class, 'viewCategory'])->name('view');
        Route::get('edit', [CourseCategoryController::class, 'editCategory'])->name('edit');
        Route::post('update', [CourseCategoryController::class, 'updateCategory'])->name('update');
        Route::post('status_change', [CourseCategoryController::class, 'statusChange'])->name('status_change');
        Route::delete('delete', [CourseCategoryController::class, 'deleteCategory'])->name('delete');
        Route::get('options', [CourseCategoryController::class, 'categoryOptions'])->name('options');
    });

    Route::middleware('auth:admin')->prefix('sub')->name('sub_')->group(function () {
        Route::post('table', [CourseCategoryController::class, 'subCategoryListData'])->name('category_table');

    });

    /**
     * Syllabus
     */
    Route::middleware('auth:admin')->prefix('main_module')->name('main_module_')->group(function () {
        Route::get('main-module', [CourseController::class, 'courseMainModuleView'])->name('list');
        Route::post('table/{course_id}', [SyllabusController::class, 'syllabusListData'])->name('table');
        Route::get('add/{course_id}', [SyllabusController::class, 'addSyllabus'])->name('add');
        Route::post('modules/save', [SyllabusController::class, 'saveSyllabus'])->name('create');
        Route::get('edit/{course_id}', [SyllabusController::class, 'editSyllabus'])->name('edit');
        Route::post('update', [SyllabusController::class, 'updateSyllabus'])->name('update');
        Route::delete('delete', [SyllabusController::class, 'deleteSyllabus'])->name('delete');
        Route::get('form', [SyllabusController::class, 'form'])->name('form');
   
    });

    /**
     * Training Calendars
     */
    Route::middleware('auth:admin')->prefix('training_calendar')->name('training_calendar_')->group(function () {
        Route::get('main-modules', [CourseController::class, 'courseTrainingCalendarView'])->name('list');
        Route::post('table/{course_id}', [TrainingCalendarController::class, 'trainingCalendarListData'])->name('table');
        Route::post('modules/save', [TrainingCalendarController::class, 'saveTrainingCalendar'])->name('create');
        Route::get('edit/{course_id}', [TrainingCalendarController::class, 'editTrainingCalendar'])->name('edit');
        Route::post('update', [TrainingCalendarController::class, 'updateTrainingCalendar'])->name('update');
        Route::delete('delete', [TrainingCalendarController::class, 'deleteTrainingCalendar'])->name('delete');
    });

    /**
     * Over view
     */
    Route::middleware('auth:admin')->prefix('overview')->name('overview_')->group(function () {
        Route::get('main-modules', [CourseController::class, 'courseTrainingOverView'])->name('list');
    });


    Route::middleware('auth:admin')->prefix('batch')->name('batch_')->group(function () {
        Route::get('/', [BatchController::class, 'listCourseBatch'])->name('list');
        Route::post('/table', [BatchController::class, 'listCourseBatchData'])->name('table');


    });
    /**
     * Course Certificate Image
     */

    Route::post('image_save', [CourseController::class, 'imageSave'])->name('image_save');
    Route::get('fetch_image', [CourseController::class, 'imageData'])->name('fetch_image');
    Route::get('image_delete', [CourseController::class, 'imageDelete'])->name('image_delete');
    Route::post('data_update', [CourseController::class, 'dataUpdate'])->name('data_update');


    Route::middleware('auth:admin')->prefix('curriculum')->name('curriculum_')->group(function () {
        Route::get('/', [CourseController::class, 'listCourseCurriculum'])->name('list');
        Route::post('/table', [CourseController::class, 'listCourseCurriculumData'])->name('table');
        Route::get('/detail', [CourseController::class, 'courseCurriculumDetail'])->name('detail');
        Route::delete('delete', [CourseController::class, 'deleteCourseCurriculum'])->name('delete');

    });


});




/**
 * Training Calendars
 */
Route::middleware('auth:admin')->prefix('training-calendar')->name('training_calendar_')->group(function () {
    Route::get('/', [TrainingCalendarController::class, 'list'])->name('list');
    Route::post('table', [TrainingCalendarController::class, 'calendarListData'])->name('table');
    Route::post('/bulk-import-calendar', [CSVController::class, 'bulkImport'])->name('bulk_import');
    Route::get('/download-calender-csv', [CSVController::class, 'csvDownload'])->name('csv_download');

});

/**
 * Discount
 */
Route::middleware('auth:admin')->prefix('discount')->name('discount_')->group(function () {
    Route::get('/add', [DiscountController::class, 'addDiscount'])->name('add');
    Route::post('create', [DiscountController::class, 'create'])->name('create');
    Route::get('/', [DiscountController::class, 'listDiscount'])->name('list');
    Route::post('table', [DiscountController::class, 'discountListData'])->name('table');
    Route::get('edit', [DiscountController::class, 'editDiscount'])->name('edit');
    Route::post('update', [DiscountController::class, 'updateDiscount'])->name('update');
    Route::delete('delete', [DiscountController::class, 'deleteDiscount'])->name('delete');
});
/**
 * Venue
 */
Route::middleware('auth:admin')->prefix('venue')->name('venue_')->group(function () {
    Route::get('/', [VenueController::class, 'listVenue'])->name('list');
    Route::post('table', [VenueController::class, 'venueListData'])->name('table');
    Route::get('add', [VenueController::class, 'addVenue'])->name('add');
    Route::post('create', [VenueController::class, 'createVenue'])->name('create');
    Route::get('view', [VenueController::class, 'viewVenue'])->name('view');
    Route::get('edit', [VenueController::class, 'editVenue'])->name('edit');
    Route::post('update', [VenueController::class, 'updateVenue'])->name('update');
    Route::post('status_change', [VenueController::class, 'statusChange'])->name('status_change');
    Route::delete('delete', [VenueController::class, 'deleteVenue'])->name('delete');
    Route::get('venue-options', [VenueController::class, 'venueOptions'])->name('options_venue');
});

/**
 * Topic
 */
Route::middleware('auth:admin')->prefix('topic')->name('topic_')->group(function () {
    Route::get('/', [TopicController::class, 'listTopic'])->name('list');
    Route::post('table', [TopicController::class, 'topicListData'])->name('table');
    Route::get('add', [TopicController::class, 'addTopic'])->name('add');
    Route::post('create', [TopicController::class, 'createTopic'])->name('create');
    Route::get('view', [TopicController::class, 'viewTopic'])->name('view');
    Route::get('edit', [TopicController::class, 'editTopic'])->name('edit');
    Route::post('update', [TopicController::class, 'updateTopic'])->name('update');
    Route::post('status_change', [TopicController::class, 'statusChange'])->name('status_change');
    Route::delete('delete', [TopicController::class, 'deleteTopic'])->name('delete');
    Route::get('topic-options', [TopicController::class, 'topicOptions'])->name('options_topic');
});

/**
 * Batches
 */
Route::middleware('auth:admin')->prefix('batch')->name('batch_')->group(function () {
    Route::get('/', [BatchController::class, 'listBatch'])->name('list');
    Route::post('table', [BatchController::class, 'batchListData'])->name('table');
    Route::get('add', [BatchController::class, 'addBatch'])->name('add');
    Route::post('create', [BatchController::class, 'createBatch'])->name('create');
    Route::get('view', [BatchController::class, 'viewBatch'])->name('view');
    Route::get('edit', [BatchController::class, 'editBatch'])->name('edit');
    Route::post('update', [BatchController::class, 'updateBatch'])->name('update');
    Route::post('status_change', [BatchController::class, 'statusChange'])->name('status_change');
    Route::delete('delete', [BatchController::class, 'deleteBatch'])->name('delete');
    Route::get('options', [BatchController::class, 'batchOptions'])->name('options');
});

/**
 * Enrollment
 */
Route::middleware('auth:admin')->prefix('enrollment')->name('enrollment_')->group(function () {
    Route::get('/', [EnrollmentController::class, 'listEnrollment'])->name('list');
    Route::post('table', [EnrollmentController::class, 'enrollmentListData'])->name('table');
    Route::get('view', [EnrollmentController::class, 'viewEnrollment'])->name('view');
    Route::post('status_change', [EnrollmentController::class, 'statusChange'])->name('status_change');
    Route::delete('delete', [EnrollmentController::class, 'deleteEnrollment'])->name('delete');
});
