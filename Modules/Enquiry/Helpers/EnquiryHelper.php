<?php

namespace Modules\Enquiry\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Modules\Enquiry\Entities\Enquiry;

class EnquiryHelper
{
    public function getEnquiryDatatable($data)
    {
        $enquiries = Enquiry::select(app(Enquiry::class)->getTable() . '.*');

        if (isset($data['type'])) {
            $enquiries->where('type', $data['type']);
        }

        if (isset($data['course_id'])) {
            $enquiries->where('course_id', $data['course_id']);
        }
        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $enquiries->whereBetween(
                DB::raw('DATE(created_at)'),
                [$data['start_date'], $data['end_date']]
            );
        }
        $enquiries->orderBy('created_at', 'desc');

        if (isset($data['no_limit'])) {
            $enquiries->take($data['no_limit']);
        }
        return $enquiries;
    }

    public function get($id)
    {
        try {
            $enquiry = Enquiry::with('courses.englishLocale')->findOrFail($id);

            return $enquiry;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getAllEnquiry()
    {
        try {
            $enquiry = Enquiry::with('courses.englishLocale')->get();

            return $enquiry;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function delete($enquiryId)
    {
        try {
            $enquiry = Enquiry::findOrFail($enquiryId);
            $enquiry->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getTotalEnquiryCount()
    {
        $totalCount = Enquiry::count();

        return $totalCount;
    }
}
