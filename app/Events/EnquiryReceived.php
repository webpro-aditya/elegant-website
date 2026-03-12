<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Enquiry\Entities\Enquiry;

class EnquiryReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $enquiry;

    public function __construct($enquiry)
    {
        $this->enquiry = $enquiry;

    }
}
 