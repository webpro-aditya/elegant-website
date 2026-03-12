<?php

namespace Modules\Settings\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Settings\Helpers\MailTemplateHelper;
use Modules\Settings\Http\Requests\Admin\MailTemplateUpdateRequest;

class MailTemplateController extends Controller
{
    public $mailTemplateHelper;

    public function __construct(MailTemplateHelper $mailTemplateHelper)
    {
        $this->mailTemplateHelper = $mailTemplateHelper;
    }

    public function view($id = null)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Settings / Mail Templates'],
        ];
        $emailTemplates = $this->mailTemplateHelper->getAll();
        $activeTemplate = empty($id) ? $emailTemplates[0] : $this->mailTemplateHelper->get($id);

        return view('settings::mailTemplate.viewMailTemplate', compact('emailTemplates', 'activeTemplate', 'breadcrumbs'));
    }

    public function update(MailTemplateUpdateRequest $request)
    {
        $inputData = [
            'id' => $request->id,
            'subject' => $request->subject,
            'html_template' => $request->message,
        ];
        $this->mailTemplateHelper->update($inputData);

        return redirect()
            ->route('mail_template_view', ['id' => $request->id])
            ->with('success', 'Mail Template updated successfuly');
    }
}
