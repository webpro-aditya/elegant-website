<?php

namespace Modules\Career\Helpers;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Career\Entities\CareerApplicant;

class CareerApplicantHelper
{
    public function getDatatable($data)
    {
        $careers = CareerApplicant::select(app(CareerApplicant::class)->getTable() . '.*')->with('career');

        if (isset($data['status'])) {
            $careers->where('status', $data['status']);
        }

        if (isset($data['career_id'])) {
            $careers->where('career_id', $data['career_id']);
        }

        return $careers;
    }

    public function getApplicant($id)
    {
        return CareerApplicant::find($id);
    }

}