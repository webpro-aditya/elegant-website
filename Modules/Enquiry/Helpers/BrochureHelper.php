<?php

namespace Modules\Enquiry\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Enquiry\Entities\Brochure;

class BrochureHelper
{
    public function getBrochureDatatable($data)
    {
        $enquiries = Brochure::select(app(Brochure::class)->getTable() . '.*');

        return $enquiries;
    }

    public function get($id)
    {
        try {
            $brochure = Brochure::findOrFail($id);

            return $brochure;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function delete($brochureId)
    {
        try {
            $brochure = Brochure::findOrFail($brochureId);
            $brochure->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function save(array $input)
    {
        if ($enquiry = Brochure::create($input)) {
            return $enquiry;
        }

        return false;
    }
}
