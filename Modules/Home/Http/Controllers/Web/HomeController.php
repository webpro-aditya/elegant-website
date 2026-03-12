<?php

namespace Modules\Home\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Course\Helpers\CourseHelper;
use Modules\Translation\Helpers\TranslationHelper;
use Modules\Settings\Helpers\SettingsHelper;

class HomeController extends Controller
{
    protected $cmsHelper;
    protected $courseHelper;
    protected $translationHelper;
    protected $settingsHelper;

    public function __construct(ContentHelper $cmsHelper, CourseHelper $courseHelper, TranslationHelper $translationHelper, SettingsHelper $settingsHelper)
    {
        $this->cmsHelper = $cmsHelper;
        $this->courseHelper = $courseHelper;
        $this->translationHelper = $translationHelper;
        $this->settingsHelper = $settingsHelper;
    }
   
    public function home()
    {
        $contents = $this->cmsHelper->getContentByKey();
        $courses = $this->courseHelper->getAllLatestCourse();
        $testimonials = $this->cmsHelper->getAllTestimonials();
        $translations = $this->translationHelper->getKeyValue();
        $settings = $this->settingsHelper->getKeyValue();

        return view('home::web.home', compact('contents', 'courses', 'testimonials', 'translations', 'settings'));
    }

    public function locale(Request $request)
    {
        $url = url()->previous();
        $parse = parse_url($url);
    
        $segments = [];
    
        if (isset($parse['path'])) {
            $segments = explode("/", trim($parse['path'], "/"));
    
            if (in_array($segments[0], ['en', 'ar', 'fr', 'sp'])) {
                $segments[0] = $request->locale;
            } else {
                array_unshift($segments, $request->locale);
            }
    
            $parse['path'] = '/' . implode("/", $segments);
    
            $url = $this->rebuildUrl($parse);
        }
    
        return redirect($url);
    }
    private function rebuildUrl(array $parsedUrl)
    {
        return (isset($parsedUrl['scheme']) ? "{$parsedUrl['scheme']}://" : '') .
               (isset($parsedUrl['host']) ? "{$parsedUrl['host']}" : '') .
               (isset($parsedUrl['port']) ? ":{$parsedUrl['port']}" : '') .
               (isset($parsedUrl['path']) ? "{$parsedUrl['path']}" : '') .
               (isset($parsedUrl['query']) ? "?{$parsedUrl['query']}" : '') .
               (isset($parsedUrl['fragment']) ? "#{$parsedUrl['fragment']}" : '');
    }
    

}