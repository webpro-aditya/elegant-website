<?php

namespace Modules\Cms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Translation\Helpers\TranslationHelper;

class ContentController extends Controller
{
    protected $translationHelper, $cmsHelper, $settingsHelper;

    public function __construct(ContentHelper $cmsHelper, SettingsHelper $settingsHelper, TranslationHelper $translationHelper)
    {
        $this->cmsHelper = $cmsHelper;
        $this->settingsHelper = $settingsHelper;
        $this->translationHelper = $translationHelper;
    }

    public function about()
    {
        $settings = $this->settingsHelper->getKeyValue();
        $contents = $this->cmsHelper->getContentByKey();
        $videos = $this->cmsHelper->getYoutubeVideos();
        $milestones = $this->cmsHelper->getMilestones();
        $translations = $this->translationHelper->getKeyValue();
       
        return view('cms::web.about.about', compact('settings', 'milestones', 'videos', 'contents', 'translations'));
    }

    public function hiring()
    {
        $settings = $this->settingsHelper->getKeyValue();
        return view('cms::web.hiring.hiring', compact('settings'));
    }

    public function corporateTraining()
    {
        $contents = $this->cmsHelper->getContentByKey();
        $settings = $this->settingsHelper->getKeyValue();
        $trainingCourses = $this->cmsHelper->getTrainingCourses();
        $translations = $this->translationHelper->getKeyValue();
 
        return view('cms::web.corporate-training.corporate-training', compact('settings', 'trainingCourses', 'contents', 'translations'));
    }

    public function mentor()
    {
        $settings = $this->settingsHelper->getKeyValue();
        return view('cms::web.mentor.mentor', compact('settings'));
    }

    public function contactUs()
    {
        $settings = $this->settingsHelper->getKeyValue();
        return view('cms::web.contactus.contactus', compact('settings'));
    }

    public function help()
    {
        return view('cms::web.help.help');
    }


    public function terms()
    {
        $settings = $this->settingsHelper->getKeyValue();
        $translations = $this->translationHelper->getKeyValue();
        $contents = $this->cmsHelper->getContentByKey();
       
        return view('cms::web.privacy.termsAndConditions', compact('settings',  'contents', 'translations'));
    }

    public function privacy()
    {
        $settings = $this->settingsHelper->getKeyValue();
        $translations = $this->translationHelper->getKeyValue();
        $contents = $this->cmsHelper->getContentByKey();
       
        return view('cms::web.privacy.privacyPolicy', compact('settings',  'contents', 'translations'));
    }

}