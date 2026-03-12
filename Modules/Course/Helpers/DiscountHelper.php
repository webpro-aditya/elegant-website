<?php

namespace Modules\Course\Helpers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Course\Entities\DiscountCode;

class DiscountHelper
{

    public function save(array $input)
    {
        if ($discount = DiscountCode::create($input)) {
            return $discount;
        }

        return false;
    }


    public function getDiscountDatatable($data)
    {
        $codes = DiscountCode::select(app(DiscountCode::class)->getTable() . '.*');

        if (isset($data['status'])) {
            $codes->where('status', $data['status']);
        }

        return $codes;
    }

    public function getDiscount($id)
    {
        return DiscountCode::find($id);
    }

    public function update($data)
    {
        $discount = DiscountCode::find($data['id']);

        if ($discount->update($data)) {
            return $discount;
        }

        return false;
    }

    public function delete($discountId)
    {
        try {
            $discount = DiscountCode::findOrFail($discountId);
            $discount->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }
}
