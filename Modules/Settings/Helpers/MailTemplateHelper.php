<?php

namespace Modules\Settings\Helpers;

use Spatie\MailTemplates\Models\MailTemplate;

class MailTemplateHelper
{
    public function get($id)
    {
        return MailTemplate::find($id);
    }

    public function update(array $input)
    {
        $emailTemplate = MailTemplate::find($input['id']);

        if ($emailTemplate->update($input)) {
            return $emailTemplate;
        }

        return false;
    }

    public function getAll()
    {
        return MailTemplate::get();
    }
}
