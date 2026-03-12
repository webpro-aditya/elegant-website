<?php

namespace Modules\Course\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Course\Entities\Venue;

class VenueHelper
{
    public function searchVenue($keyword)
    {
        $venues = Venue::where('title', 'like', "%{$keyword}%");

        return $venues->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function save(array $input)
    {
        if ($venue = Venue::create($input)) {
            return $venue;
        }

        return false;
    }

    public function getVenueDatatable($data)
    {
        $venues = Venue::select(app(Venue::class)->getTable() . '.*');

        if (isset($data['status'])) {
            $venues->where('status', $data['status']);
        }

        return $venues->latest();
    }

    public function delete($venueId)
    {
        try {
            $venue = Venue::findOrFail($venueId);
            $venue->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getVenue($id)
    {
        return Venue::find($id);
    }

    public function update($data)
    {
        $venue = Venue::find($data['id']);

        if ($venue->update($data)) {
            return $venue;
        }

        return false;
    }

    public function getAllVenue()
    {
        return Venue::All();
    }
}
