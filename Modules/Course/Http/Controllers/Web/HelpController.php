<?php

namespace Modules\Course\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Settings\Helpers\SettingsHelper;

class HelpController extends Controller
{
    public function help(Request $request)
    {
        return view('course::web.help.help');
    }

    // public function saveHelp(Request $request)
    // {
    //     $inputData = [
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'number' => $request->number,
    //         'message' => $request->message,
    //         'course_id' => $request->courseId,
    //         'type' => $request->type,
    //     ];
    //     $this->
    //     dd($inputData);
    // }

    public function saveBrochure(Request $request, SettingsHelper $settingsHelper)
    {
      
    }
    public function verifyEmail(Request $request)
    {
    }
}