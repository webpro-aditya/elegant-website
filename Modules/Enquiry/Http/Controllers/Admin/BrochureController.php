<?php

namespace Modules\Enquiry\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Enquiry\Helpers\BrochureHelper;
use Modules\Enquiry\Http\Requests\Admin\Brochure\BrochureDeleteRequest;
use Modules\Enquiry\Http\Requests\Admin\Brochure\BrochureListDataRequest;
use Modules\Enquiry\Http\Requests\Admin\Brochure\BrochureListRequest;
use Yajra\DataTables\DataTables;

class BrochureController extends Controller
{
    protected $brochureHelper;

    public function __construct(BrochureHelper $brochureHelper)
    {
        $this->brochureHelper = $brochureHelper;
    }

    public function list(BrochureListRequest $request)
    {
        return view('enquiry::admin.brochure.listBrochure');
    }

    public function table(BrochureListDataRequest $request)
    {
        $brochures = $this->brochureHelper->getBrochureDatatable($request->all());
        $dataTableJSON = DataTables::of($brochures)
            ->addIndexColumn()
            ->editColumn('name', function ($brochure) {
                return $brochure->name;
            })

            ->editColumn('email', function ($brochure) {
                return $brochure->email;
            })
            ->addColumn('action', function ($brochure) use ($request) {
                $data['delete_url'] = route('brochure_delete', ['id' => $brochure->id]);

                return view('elements.listAction', compact('data'));

            })
            ->make();

        return $dataTableJSON;
    }

    public function delete(BrochureDeleteRequest $request)
    {
        $brochure = $this->brochureHelper->get($request->id);

        if ($this->brochureHelper->delete($request->id)) {

            if ($request->ajax()) {

                activity()->performedOn($brochure)->event('brochure Deleted')->withProperties(['brochure_id' => $brochure->id])->log('brochure Deleted');

                return response()->json(['status' => 1, 'message' => 'brochure deleted successfully']);

            } else {

                return redirect()->route('brochure_list')->with('success', 'brochure deleted successfully');
            }

        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('brochure_list')->with('success', 'Failed to delete');
        }
    }
}
