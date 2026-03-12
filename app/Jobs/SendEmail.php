<?php

namespace App\Jobs;

use App\Mail\SendCurriculumAdminMail;
use App\Mail\SendCurriculumDownlaodMail;
use App\Mail\SendSubscribeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Modules\Course\Entities\Curriculum;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $data;
    public $toemail;
    public $name;
    public $empname;
    public $type;
    public $url;
    public $tries = 1;
    public $timeout = 900;

    public function __construct($data, $toemail, $type,$url='empty')
    {
        $this->data = $data;
        $this->toemail = $toemail;
        $this->type = $type;
        $this->url  = $url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {  
        if ($this->type == 'send_subscribe_email') { 
            $emailclass = new SendSubscribeMail($this->data, $this->url);
        }
        elseif ($this->type == 'send_curriculum_download_email') { 
            $emailclass = new SendCurriculumDownlaodMail($this->data, $this->url);
        }elseif ($this->type == 'send_curriculum_admin_email') { 
            $emailclass = new SendCurriculumAdminMail($this->data);
        }
    
        Mail::to($this->toemail, $this->name)->send($emailclass);

        if($this->type == 'send_curriculum_download_email'){
            $curriculum = Curriculum::find($this->data['curriculum_id']);
            if ($curriculum) {
                $curriculum->email_send = 1;
                $curriculum->save();
            }
        }        
    }
}