<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\MailTemplates\Models\MailTemplate;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        MailTemplate::create([
            'mailable' => \Modules\Settings\Mail\RegistrationVerificationMail::class,
            'name' => 'Registration Verification',
            'slug' => 'registration_verification',
            'subject' => 'Registration Verification',
            'html_template' => '<h1>Hi {{{ user_name }}},</h1><p>Please click the below link to verify your registration.</p><p>
            <a href="" style="background: #F3B42F; text-decoration: none; padding: 6px 14px; font-size: 11px; color: #000; font-weight: 600;">Click Here</a>
            </p><p></p>'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        MailTemplate::where('mailable', \Modules\Settings\Mail\RegistrationVerificationMail::class)->delete();
    }
};
