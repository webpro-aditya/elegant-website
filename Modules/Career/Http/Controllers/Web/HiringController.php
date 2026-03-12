<?php

namespace Modules\Career\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Career\Entities\Career;
use Modules\Cms\Helpers\ContentHelper;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Career\Helpers\Web\CareerHelper;
use Illuminate\Support\Facades\Storage;
use Modules\Translation\Helpers\TranslationHelper;

class HiringController extends Controller
{
    protected $cmsHelper;
    protected $settingsHelper;
    protected $careerHelper;
    protected $translationHelper;


    public function __construct(ContentHelper $cmsHelper, SettingsHelper $settingsHelper, CareerHelper $careerHelper, TranslationHelper $translationHelper)
    {
        $this->cmsHelper = $cmsHelper;
        $this->settingsHelper = $settingsHelper;
        $this->careerHelper = $careerHelper;
        $this->translationHelper = $translationHelper;

    }
    public function hiring()
    {
        $contents = $this->cmsHelper->getContentByKey();
        $categories = $this->careerHelper->getAllCategories();
        $translations = $this->translationHelper->getKeyValue();

        return view('career::web.hiring.hiring', compact('contents', 'categories', 'translations'));
    }

    public function hiringList(Request $request)
    {
        $tabId = $request->input('tabId');

        // Fetch careers based on $tabId
        if ($tabId === 'All') {
            $careers = Career::with('locales', 'category', 'defaultLocale')->where('status', 'active')->get(); // Example: Fetch all careers
        } else {
            $careers = Career::where('category_id', $tabId)->with('locales', 'category', 'defaultLocale')->where('status', 'active')->get(); // Ensure to load 'local' relation if needed
        }

        // Get the current locale
        $locale = app()->getLocale();
        $categoryNameField = 'name_' . $locale;

        // Add localized category name to each career
        $careers->each(function ($career) use ($categoryNameField) {
            $career->localized_category_name = $career->category->$categoryNameField ?? $career->category->name_en; // Fallback to English if localized name is not available
        });
        $translations = $this->translationHelper->getKeyValue();

        $response['view'] = (string) view('career::web.hiring.card.careerCard', compact('careers', 'translations'));

        return response()->json($response); // Return JSON response
    }

    public function careerApplicant(Request $request)
    {
        $inputData = [
            'name' => $request->name ?? 'no name',
            'email' => $request->email ?? 'no email',
            'phone' => $request->number ?? 'no phone',
            'career_id' => $request->careerId ?? 0,
            'job_profile' => $request->job_profile ?? 'No Job Profile',
            'linkedin_profile' => $request->linkedin ?? 'No Likedin Profile',
        ];

        if ($request->hasFile('resume')) {
            $filePath = 'job_resume';
            $fileName = Storage::disk('elegant')->putFile($filePath, $request->file('resume'));
            $inputData['resume'] = $fileName;
        }
        // Save the applicant
        if ($this->careerHelper->saveApplicant($inputData)) {
            return redirect()->back()->with('success', 'Your enquiry has been submitted successfully!');
        } else {
            return redirect()->back()->with('error', 'There was an error submitting your enquiry. Please try again.');
        }
    }
    public function applyHiring(Request $request)
    {
        $career = $this->careerHelper->getCareer($request->career_id);
        $translations = $this->translationHelper->getKeyValue();
        $response['html'] = (string) view('career::web.hiring.card.hiringModal', compact('career', 'translations'));
        $response['scripts'][] = (string) mix('js/web/hiring/careerCard.js');
    
        return response()->json($response);
    }

}
