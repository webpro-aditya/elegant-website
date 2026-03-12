<?php

namespace Modules\Course\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Course\Helpers\DiscountHelper;
use Modules\Course\Http\Requests\Admin\Discount\DiscountAddRequest;
use Modules\Course\Http\Requests\Admin\Discount\DiscountCreateRequest;
use Modules\Course\Http\Requests\Admin\Discount\DiscountDeleteRequest;
use Modules\Course\Http\Requests\Admin\Discount\DiscountEditRequest;
use Modules\Course\Http\Requests\Admin\Discount\DiscountListDataRequest;
use Modules\Course\Http\Requests\Admin\Discount\DiscountListRequest;
use Modules\Course\Http\Requests\Admin\Discount\DiscountUpdateRequest;
use Yajra\DataTables\DataTables;

class DiscountController extends Controller
{
    protected $discountHelper;

    public function __construct(DiscountHelper $discountHelper)
    {
        $this->discountHelper = $discountHelper;
    }
    public function addDiscount(DiscountAddRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_discount_list', 'name' => 'Discount', 'permission' => 'discount_read'],
            ['name' => 'Add Discount'],
        ];

        return view('course::admin.discount.addDiscount', compact('breadcrumbs'));
    }

    public function create(DiscountCreateRequest $request)
    {
        $inputData = [
            'title' => $request->title,
            'code' => $request->code,
            'discount_percentage' => $request->percentage,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'attempt_per_user' => $request->attempt_per_user,
            'status' => $request->status,
        ];

        $discount = $this->discountHelper->save($inputData);

        activity()->performedOn($discount)->event('Discount Coupon Created')->withProperties(['discount_id' => $discount->id, 'data' => $inputData])->log('Discount Coupon Created');

        return redirect()
            ->route('discount_list')
            ->with('success', 'Discount Code Created successfully');
    }

    public function listDiscount(DiscountListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Discounts'],
        ];

        return view('course::admin.discount.listDiscount', compact('breadcrumbs'));
    }

    public function discountListData(DiscountListDataRequest $request)
    {
        $codes = $this->discountHelper->getDiscountDatatable($request->all());
        $dataTableJSON = DataTables::of($codes)
            ->addIndexColumn()
            ->editColumn('title', function ($code) {
                $data['url'] = route('discount_edit', ['id' => $code->id]);
                $data['text'] = $code->title;

                return view('elements.listLink', compact('data'));
            })

            ->editColumn('code', function ($code) {
                return $code->code;
            })

            ->editColumn('discount_percentage', function ($code) {
                return $code->discount_percentage;
            })

            ->editColumn('valid_from', function ($code) {
                return $code->valid_from;
            })

            ->editColumn('valid_to', function ($code) {
                return $code->valid_to;
            })

            ->editColumn('attempt_per_user', function ($code) {
                return $code->attempt_per_user;
            })

            ->addColumn('status', function ($code) {
                return view('elements.listStatus')->with('data', $code);
            })

            ->addColumn('action', function ($code) use ($request) {
                $data['edit_url'] = route('discount_edit', ['id' => $code->id]);
                $data['delete_url'] = route('discount_delete', ['id' => $code->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }

    public function editDiscount(DiscountEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'discount_list', 'name' => 'Discourse', 'permission' => 'discourse_read'],
            ['name' => 'Discount Coupon Details'],
        ];
        $discount = $this->discountHelper->getDiscount($request->id);

        return view('course::admin.discount.editDiscount', compact('discount', 'breadcrumbs',));
    }

    public function updateDiscount(DiscountUpdateRequest $request)
    {
        $updateData = [
            'id' => $request->id,
            'title' => $request->title,
            'code' => $request->code,
            'discount_percentage' => $request->percentage,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'attempt_per_user' => $request->attempt_per_user,
            'status' => $request->status,
        ];

        $discount = $this->discountHelper->update($updateData);
        activity()->performedOn($discount)->event('Discount Coupon Updated')->withProperties(['discount_id' => $discount->id, 'data' => $updateData])->log('Discount Code Updated');

        return redirect()
            ->route('discount_list')
            ->with('success', 'Discount Coupon updated successfully');
    }

    public function deleteDiscount(DiscountDeleteRequest $request)
    {
        $discount = $this->discountHelper->getDiscount($request->id);

        if ($this->discountHelper->delete($request->id)) {

            if ($request->ajax()) {

                activity()->performedOn($discount)->event('Discount Coupon Deleted')->withProperties(['discount_id' => $discount->id])->log('Discount Coupon Deleted');

                return response()->json(['status' => 1, 'message' => 'Disocunt Coupon deleted successfully']);

            } else {

                return redirect()->route('discount_list')->with('success', 'Discount Coupon deleted successfully');
            }

        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('discount_list')->with('success', 'Failed to delete');
        }
    }
}
