<?php

namespace Modules\Settings\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\MailTemplates\TemplateMailable;
use Modules\Settings\Helpers\SettingsHelper;

class RegistrationSuccessMail extends TemplateMailable implements ShouldQueue
{
    use Queueable, SerializesModels;

      /**
     * merge fields
     */
    public $user_name;

    public $signature;

    public $settingsHelper;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->settingsHelper = new SettingsHelper();
        $this->user_name = $user->name;
        $this->signature = $this->settingsHelper->getByKey('signature')->value;
    }

    /**
     * The common base template
     */
    public function getHtmlLayout(): string
    {
        return view('settings::mailTemplate.userTemplate')->render();
    }
}
