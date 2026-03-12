<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendCurriculumAdminMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'New Curriculum Download Request';
        $adminEmail = config('settings.config.mail_from_address');
        $return = $this->view('email.sendCurriculumAdminMail')
            ->subject($subject)
            ->from($adminEmail, $this->data['company_name'])
            ->with([
                'name' => $this->data['curriculum']->name ?? '',
                'email' => $this->data['curriculum']->email,
                'country_code' => $this->data['curriculum']->country_code ?? '',
                'phone' => $this->data['curriculum']->phone ?? '',
                'user_message' => $this->data['curriculum']->message ?? '',
                'course_name' => $this->data['course']->name ?? 'N/A',
                'date' => Carbon::now(),
                'company_name' => $this->data['company_name'],
            ]);
        return $return;
    }
}
