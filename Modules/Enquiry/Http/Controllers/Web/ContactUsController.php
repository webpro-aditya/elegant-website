<?php

namespace Modules\Enquiry\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Course\Helpers\Web\CourseHelper;
use Modules\Faq\Helpers\FaqHelper;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Translation\Helpers\TranslationHelper;

class ContactUsController extends Controller
{
    protected $courseHelper;
    protected $contentHelper;
    protected $faqHelper;
    protected $settingsHelper;
    protected $translationHelper;


    public function __construct(
        CourseHelper $courseHelper,
        ContentHelper $contentHelper,
        FaqHelper $faqHelper,
        SettingsHelper $settingsHelper,
        TranslationHelper $translationHelper
    ) {
        $this->courseHelper = $courseHelper;
        $this->contentHelper = $contentHelper;
        $this->faqHelper = $faqHelper;
        $this->settingsHelper = $settingsHelper;
        $this->translationHelper = $translationHelper;

    }

    public function contact()
    { 
        $contents = $this->contentHelper->getContentByKey();
        $infos = $this->contentHelper->getContactInformation();

        $countries = $this->settingsHelper->getAllCountry();
        $translations = $this->translationHelper->getKeyValue();

        return view('enquiry::web.contactUs.contactus', compact('contents', 'infos','countries', 'translations'));
    }

}
