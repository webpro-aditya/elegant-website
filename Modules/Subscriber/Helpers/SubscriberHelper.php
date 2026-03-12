<?php

namespace Modules\Subscriber\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Subscriber\Entities\Subscriber;

class SubscriberHelper
{
    /*
    |--------------------------------------------------------------------------
    | Subscriber
    |--------------------------------------------------------------------------
    */
    public function save(array $input)
    {
        if ($subscriber = Subscriber::create($input)) {
            return $subscriber;
        }

        return false;
    }

    public function getSubscriberDatatable($data)
    {
        $subscriber = Subscriber::select(app(Subscriber::class)->getTable() . '.*');

        if (isset($data['status'])) {
            $subscriber->where('status', $data['status']);
        }
        if (isset($data['email'])) {
            $subscriber->where('email', $data['email']);
        }

        return $subscriber;
    }


    public function delete($subscriberId)
    {
        try {
            $subscriber = Subscriber::findOrFail($subscriberId);
            $subscriber->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function update($data)
    {
        $subscriber = Subscriber::find($data['id']);

        if ($subscriber->update($data)) {
            return $subscriber;
        }

        return false;
    }

    public function getSubscriber($id)
    {
        try {
            $subscriber = Subscriber::findOrFail($id);

            return $subscriber;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function subscriberCount()
    {
        return $subscriber = Subscriber::count();
    }

    public function searchSubscriber($keyword)
    {
        $subscriberQuery = Subscriber::where('email', 'like', "%{$keyword}%")
            ->distinct('email'); 
        return $subscriberQuery->paginate(30, ['*'], 'page', request()->get('page'));
    }

}


