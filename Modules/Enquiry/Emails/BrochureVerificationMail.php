<?php

namespace Modules\Enquiry\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Enquiry\Entities\Brochure;
use Illuminate\Support\Str;


class BrochureVerificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $brochure;
    public $settings;


    /**
     * Create a new message instance.
     *
     * @param Brochure $brochure
     *
     * @return void
     */
    public function __construct(Brochure $brochure, $settings)
    {
        $this->brochure = $brochure;
        $this->settings = $settings;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Brochure Submission Verification')
            ->view('enquiry::admin.brochure.verficationMail')
            ->with([
                'brochure' => $this->brochure,
                'settings' => $this->settings
            ]);
    }
}
