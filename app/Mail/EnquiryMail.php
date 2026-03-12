<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $enquiryData;

    public function __construct($enquiryData)
    {
        $this->enquiryData = $enquiryData;
    }

    public function build()
    {
        return $this->subject('New Enquiry Received')
            ->view('email.enquiry')
            ->with([
                'enquiryData' => $this->enquiryData, // Pass the email to the view
            ]);
    }
}
