<?php

namespace Modules\Translation\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Translation\Http\Requests\Admin\TranslationViewRequest;
use Modules\Translation\Helpers\TranslationHelper;

class TranslationController extends Controller
{
    protected $translationHelper;

    public function __construct(TranslationHelper $translationHelper)
    {
        $this->translationHelper = $translationHelper;
    }
    public function view(TranslationViewRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Settings / Translation'],
        ];
        $translations = $this->translationHelper->getAll()->keyBy('key');

        return view('translation::admin.translation', compact('breadcrumbs', 'translations'));
    }

    public function saveTranslation(Request $request)
    {
        $translations = $request->input('translations');
    
        foreach ($translations as $key => $values) {
             $translationData = $this->translationHelper->getByKey($key);
            
            if ($translationData) {
                $translationData->value_en = $values['value_en'];
                $translationData->value_ar = $values['value_ar'];
                
                $this->translationHelper->update($translationData);
            }
        }
    
        return redirect()->back()->with('success', 'Translations updated successfully');
    }
}
