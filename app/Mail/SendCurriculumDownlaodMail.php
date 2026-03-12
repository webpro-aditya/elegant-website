<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class SendCurriculumDownlaodMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $url;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $url)
    {
        $this->data = $data;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Curriculum download Successfully';
        $return = $this->view('email.curriculumDownlaodEmail')
            ->subject($subject)
            ->from($this->data['mail_from_address'], 'Curriculum download Successfully')
            ->with([
                // 'content'       => 'Congratulations, You have been Subscribe Successfully!',
                'email' => $this->data['email'],
                'date' => Carbon::now(),
                'company_name' => $this->data['company_name'],
            ]);
        return $return;
    }
}
