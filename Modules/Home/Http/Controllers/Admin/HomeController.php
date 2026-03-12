<?php

namespace Modules\Home\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Course\Helpers\CourseHelper;
use Modules\Enquiry\Helpers\EnquiryHelper;
use Modules\Subscriber\Helpers\SubscriberHelper;
class HomeController extends Controller
{
    protected $courseHelper;
    protected $enquiryHelper;
    protected $subscriberHelper;

    public function __construct(CourseHelper $courseHelper, EnquiryHelper $enquiryHelper, SubscriberHelper $subscriberHelper)
    {
        $this->courseHelper = $courseHelper;
        $this->enquiryHelper = $enquiryHelper;
        $this->subscriberHelper = $subscriberHelper;
    }
    public function dashboard()
    {
        $courseCount = $this->courseHelper->getAllCourse()->count();
        $enquiryCount = $this->enquiryHelper->getTotalEnquiryCount();
        $subscriberCount = $this->subscriberHelper->subscriberCount();
        return view('home::dashboard', compact('courseCount', 'enquiryCount', 'subscriberCount'));
    }
}
