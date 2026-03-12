<?php

namespace Modules\Subscriber\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Subscriber\Helpers\SubscriberHelper;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Subscriber\Http\Requests\Web\SubscribeAddRequest;
use App\Jobs\SendEmail;
use Carbon\Carbon;

class SubscriberController extends Controller
{
    protected $subscribeHelper;
    protected $settingsHelper;


    public function __construct(SubscriberHelper $subscribeHelper, SettingsHelper $settingsHelper)
    {
        $this->subscribeHelper = $subscribeHelper;
        $this->settingsHelper = $settingsHelper;
    }

    public function subscribe(SubscribeAddRequest $request)
    {
        $inputData = [
            'email' => $request->email
        ];
        $this->subscribeHelper->save($inputData);

        $user_data_array = array();
        $user_data_array['email'] = $request->email;
        $user_data_array['company_name'] = $this->settingsHelper->getByKey('company_name_en')->value;
        $user_data_array['mail_from_address'] = $this->settingsHelper->getByKey('mail_from_address')->value;
        if (isset($user_data_array) && isset($user_data_array['mail_from_address']) && $user_data_array['mail_from_address'] != '') {
            SendEmail::dispatch($user_data_array, $request->email, 'send_subscribe_email')->delay(Carbon::now()->addSeconds(10));
        }
        return redirect()->route('web_home', ['locale' => 'en'])->with('success', 'Suscribe successfully');
    }
}
