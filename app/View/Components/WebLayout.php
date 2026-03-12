<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Course\Helpers\Web\CourseHelper;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Resources\Helpers\web\ResourceHelper;
use Modules\Translation\Helpers\TranslationHelper;

class WebLayout extends Component
{
    // public $breadcrumbs;
    public $courseHelper;
    public $cmsHelper;
    public $resourceHelper;
    protected $translationHelper;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    // array $breadcrumbs = [],
    public function __construct(ContentHelper $cmsHelper, CourseHelper $courseHelper, ResourceHelper $resourceHelper, TranslationHelper $translationHelper)
    {
        // $this->breadcrumbs = $breadcrumbs;
        $this->courseHelper = $courseHelper;
        $this->cmsHelper = $cmsHelper;
        $this->resourceHelper = $resourceHelper;
        $this->translationHelper = $translationHelper;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $offlines = $this->courseHelper->getOfflineCategory();
        $onlines = $this->courseHelper->getOnlineCategory();
        $features = $this->cmsHelper->getHeaderFeatureCourses();
        $categories = $this->courseHelper->getTopCourseCategories();
        $popularCourses = $this->courseHelper->getPopularCourses();
        $locations = $this->cmsHelper->getContactInformation();
        $interviews = $this->resourceHelper->getDataWithType('interview');
        $quizs = $this->resourceHelper->getDataWithType('quiz');
        $translations = $this->translationHelper->getKeyValue();

        $courses = $this->courseHelper->getWholeCategory();


        return view('layouts.web.app', compact('courses','offlines', 'popularCourses', 'quizs', 'interviews', 'categories', 'locations', 'features', 'onlines', 'translations'));
    }
}
