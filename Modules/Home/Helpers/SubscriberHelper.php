<?php

namespace Modules\Home\Helpers;
use Modules\Home\Entities\Subscriber;

class SubscriberHelper
{
    public function save(array $input)
    {
        if ($author = Subscriber::create($input)) {
            return $author;
        }

        return false;
    }
}
