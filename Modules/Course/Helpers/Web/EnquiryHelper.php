<?php

namespace Modules\Course\Helpers\Web;

use Modules\Enquiry\Entities\Enquiry;

class EnquiryHelper
{
    public function save(array $input)
    {
        if ($enquiry = Enquiry::create($input)) {
            return $enquiry;
        }

        return false;
    }
}
