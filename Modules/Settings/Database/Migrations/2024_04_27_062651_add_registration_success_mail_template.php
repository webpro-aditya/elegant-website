<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\MailTemplates\Models\MailTemplate;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        MailTemplate::create([
            'mailable' => \Modules\Settings\Mail\RegistrationSuccessMail::class,
            'name' => 'Registration Success',
            'slug' => 'registration_success',
            'subject' => 'Registration Success',
            'html_template' => '<p>Your registration successfully completed</p>',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        MailTemplate::where('mailable', \Modules\Settings\Mail\RegistrationSuccessMail::class)->delete();
    }
};
