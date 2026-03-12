<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;

class SendSubscribeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $url;
    
    /**
     * Create a new message instance.
     */
    public function __construct($data,$url)
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
        $subject    ='Subscribe Successfully';
        $return = $this->view('email.subscribeEmail')
                    ->subject($subject)
                    ->from($this->data['mail_from_address'], 'Subscribe Successfully')
                    ->with([
                                // 'content'       => 'Congratulations, You have been Subscribe Successfully!',
                                'email'         => $this->data['email'],
                                'date'          => Carbon::now(),
                                'company_name'  => $this->data['company_name'] ,
                            ]);
        return $return ;
    }
}
