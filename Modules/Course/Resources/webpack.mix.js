const mix = require('laravel-mix');

const moduleDir = 'Modules/Course/';

/**
 * Course
 */

mix.js(moduleDir + 'Resources/js/admin/course/addCourse.js', 'public/js/admin/course');
mix.sass(moduleDir + 'Resources/sass/admin/course/addCourse.scss', 'public/css/admin/course');

mix.js(moduleDir + 'Resources/js/admin/course/editCourse.js', 'public/js/admin/course');
mix.sass(moduleDir + 'Resources/sass/admin/course/editCourse.scss', 'public/css/admin/course');

mix.js(moduleDir + 'Resources/js/admin/course/listCourse.js', 'public/js/admin/course');
mix.sass(moduleDir + 'Resources/sass/admin/course/listCourse.scss', 'public/css/admin/course');

/**
 * Course category
 */

mix.js(moduleDir + 'Resources/js/admin/category/addCategory.js', 'public/js/admin/category');
mix.sass(moduleDir + 'Resources/sass/admin/category/addCategory.scss', 'public/css/admin/category');

mix.js(moduleDir + 'Resources/js/admin/category/editCategory.js', 'public/js/admin/category');
mix.sass(moduleDir + 'Resources/sass/admin/category/editCategory.scss', 'public/css/admin/category');

mix.js(moduleDir + 'Resources/js/admin/category/listCategory.js', 'public/js/admin/category');
mix.sass(moduleDir + 'Resources/sass/admin/category/listCategory.scss', 'public/css/admin/category');

/**
 * Venue
 */

mix.js(moduleDir + 'Resources/js/admin/venue/addVenue.js', 'public/js/admin/venue');
mix.sass(moduleDir + 'Resources/sass/admin/venue/addVenue.scss', 'public/css/admin/venue');

mix.js(moduleDir + 'Resources/js/admin/venue/editVenue.js', 'public/js/admin/venue');
mix.sass(moduleDir + 'Resources/sass/admin/venue/editVenue.scss', 'public/css/admin/venue');

mix.js(moduleDir + 'Resources/js/admin/venue/listVenue.js', 'public/js/admin/venue');
mix.sass(moduleDir + 'Resources/sass/admin/venue/listVenue.scss', 'public/css/admin/venue');

/**
 * Topic
 */

mix.js(moduleDir + 'Resources/js/admin/topic/addTopic.js', 'public/js/admin/topic');
mix.sass(moduleDir + 'Resources/sass/admin/topic/addTopic.scss', 'public/css/admin/topic');

mix.js(moduleDir + 'Resources/js/admin/topic/editTopic.js', 'public/js/admin/topic');
mix.sass(moduleDir + 'Resources/sass/admin/topic/editTopic.scss', 'public/css/admin/topic');

mix.js(moduleDir + 'Resources/js/admin/topic/listTopic.js', 'public/js/admin/topic');
mix.sass(moduleDir + 'Resources/sass/admin/topic/listTopic.scss', 'public/css/admin/topic');

/**
 * Enrollment
 */

mix.js(moduleDir + 'Resources/js/admin/enrollment/listEnrollment.js', 'public/js/admin/enrollment');
mix.sass(moduleDir + 'Resources/sass/admin/enrollment/listEnrollment.scss', 'public/css/admin/enrollment');

/**
 * Batch
 */

mix.js(moduleDir + 'Resources/js/admin/batch/listBatch.js', 'public/js/admin/batch');
mix.sass(moduleDir + 'Resources/sass/admin/batch/listBatch.scss', 'public/css/admin/batch');
mix.js(moduleDir + 'Resources/js/admin/batch/viewBatch.js', 'public/js/admin/batch');
mix.sass(moduleDir + 'Resources/sass/admin/batch/viewBatch.scss', 'public/css/admin/batch');
mix.js(moduleDir + 'Resources/js/admin/batch/editBatch.js', 'public/js/admin/batch');
mix.sass(moduleDir + 'Resources/sass/admin/batch/editBatch.scss', 'public/css/admin/batch');

/**
 * Main Modules
 */

mix.js(moduleDir + 'Resources/js/admin/course/mainModule/listMainModule.js', 'public/js/admin/course/mainModule');
mix.js(moduleDir + 'Resources/js/admin/course/mainModule/editMainModule.js', 'public/js/admin/course/mainModule');
mix.js(moduleDir + 'Resources/js/admin/course/mainModule/addMainModule.js', 'public/js/admin/course/mainModule');

/**
 * Training Calendar
 */

mix.js(moduleDir + 'Resources/js/admin/course/trainingCalendar/listTrainingCalendar.js', 'public/js/admin/course/trainingCalendar');
mix.js(moduleDir + 'Resources/js/admin/course/trainingCalendar/editTrainingCalendar.js', 'public/js/admin/course/trainingCalendar');

mix.js(moduleDir + 'Resources/js/admin/trainingCalendar/listCalendar.js', 'public/js/admin/trainingCalendar');

/**
 * Discount
 */

mix.js(moduleDir + 'Resources/js/admin/discount/addDiscount.js', 'public/js/admin/discount');
mix.sass(moduleDir + 'Resources/sass/admin/discount/addDiscount.scss', 'public/css/admin/discount');
mix.js(moduleDir + 'Resources/js/admin/discount/listDiscount.js', 'public/js/admin/discount');
mix.sass(moduleDir + 'Resources/sass/admin/discount/listDiscount.scss', 'public/css/admin/discount');
mix.js(moduleDir + 'Resources/js/admin/discount/editDiscount.js', 'public/js/admin/discount');
mix.sass(moduleDir + 'Resources/sass/admin/discount/editDiscount.scss', 'public/css/admin/discount');



mix.js(moduleDir + 'Resources/js/admin/courseCurriculum/listCourseCurriculum.js', 'public/js/admin/courseCurriculum');
mix.sass(moduleDir + 'Resources/sass/admin/courseCurriculum/listCourseCurriculum.scss', 'public/css/admin/courseCurriculum');
mix.js(moduleDir + 'Resources/js/admin/courseCurriculum/detailCourseCurriculum.js', 'public/js/admin/courseCurriculum');
mix.sass(moduleDir + 'Resources/sass/admin/courseCurriculum/detailCourseCurriculum.scss', 'public/css/admin/courseCurriculum');

/**
 * Front End
 */

mix.js(moduleDir + 'Resources/js/web/course/courseDetail.js', 'public/js/web/course');
mix.sass(moduleDir + 'Resources/sass/web/course/courseDetail.scss', 'public/css/web/course');

mix.js(moduleDir + 'Resources/js/web/self-paced/self-paced.js', 'public/js/web/self-paced');
mix.sass(moduleDir + 'Resources/sass/web/self-paced/self-paced.scss', 'public/css/web/self-paced');

mix.js(moduleDir + 'Resources/js/web/training-calender/training-calender.js', 'public/js/web/training-calender');
mix.sass(moduleDir + 'Resources/sass/web/training-calender/training-calender.scss', 'public/css/web/training-calender');



mix.js(moduleDir + 'Resources/js/web/course/courseList.js', 'public/js/web/course');
mix.sass(moduleDir + 'Resources/sass/web/course/courseList.scss', 'public/css/web/course');
