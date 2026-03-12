<?php

namespace App\Listeners;

use App\Events\EnquiryReceived;
use App\Mail\EnquiryMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class HandleEnquiry
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\EnquiryReceived  $event
     * @return void
     */
    public function handle(EnquiryReceived $event)
    {
        $enquiryData = $event->enquiry;

        // $adminEmail = config('settings.config.mail_from_address');
        $adminEmail = config('settings.store.email') 
        ?? env('MAIL_FROM_ADDRESS', 'info@elegant-training.ae');
        // Mail::raw('New enquiry received', function ($message) use ($adminEmail) {
        //     $message->to($adminEmail)
        //         ->subject('Test Enquiry Email');
        // });

            Mail::to($adminEmail)->send(new EnquiryMail($enquiryData));

            
       
    }
}
