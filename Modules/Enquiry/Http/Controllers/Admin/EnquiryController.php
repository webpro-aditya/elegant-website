<?php

namespace Modules\Enquiry\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Enquiry\Helpers\EnquiryHelper;
use Modules\Enquiry\Http\Requests\Admin\Enquiry\EnquiryDeleteRequest;
use Modules\Enquiry\Http\Requests\Admin\Enquiry\EnquiryListDataRequest;
use Modules\Enquiry\Http\Requests\Admin\Enquiry\EnquiryListRequest;
use Rap2hpoutre\FastExcel\FastExcel;
use Yajra\DataTables\DataTables;

class EnquiryController extends Controller
{
    protected $enquiryHelper;

    public function __construct(EnquiryHelper $enquiryHelper)
    {
        $this->enquiryHelper = $enquiryHelper;
    }

    public function list(EnquiryListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Enqiry'],
        ];

        return view('enquiry::admin.enquiry.listEnquiry', compact('breadcrumbs'));
    }

    public function table(EnquiryListDataRequest $request)
    {
        $enquiries = $this->enquiryHelper->getEnquiryDatatable($request->all());
        $dataTableJSON = DataTables::of($enquiries)
            ->addIndexColumn()
            ->editColumn('name', function ($enquiry) {
                return $enquiry->name;
            })

            ->editColumn('email', function ($enquiry) {
                return $enquiry->email;
            })

            ->editColumn('type', function ($enquiry) {
                return view('elements.listStatus')->with('data', $enquiry);
            })

            ->addColumn('created_at', function ($enquiry) {
                return $enquiry->created_at->format('Y-m-d H:i');
            })

            ->addColumn('action', function ($enquiry) use ($request) {
                $data['view_url'] = route('enquiry_detail', ['id' => $enquiry->id]);
                $data['delete_url'] = route('enquiry_delete', ['id' => $enquiry->id]);

                return '<div class="export-none">' . view('elements.listAction', compact('data')) . '</div>';

            })
            ->make();

        return $dataTableJSON;
    }

    public function detail(EnquiryListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'enquiry_list', 'name' => 'Enquiry'],
            ['name' => 'Enquiry Details'],
        ];
        $enquiry = $this->enquiryHelper->get($request->id);

        return view('enquiry::admin.enquiry.detailEnquiry', compact('enquiry', 'breadcrumbs'));
    }

    public function delete(EnquiryDeleteRequest $request)
    {
        $enquiry = $this->enquiryHelper->get($request->id);

        if ($this->enquiryHelper->delete($request->id)) {

            if ($request->ajax()) {

                activity()->performedOn($enquiry)->event('enquiry Deleted')->withProperties(['enquiry_id' => $enquiry->id])->log('enquiry Deleted');

                return response()->json(['status' => 1, 'message' => 'enquiry deleted successfully']);

            } else {

                return redirect()->route('enquiry_list')->with('success', 'enquiry deleted successfully');
            }

        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('enquiry_list')->with('success', 'Failed to delete');
        }
    }

    public function exportEnquiries()
    {

        $enquiries = $this->enquiryHelper->getAllEnquiry();

        $formatted = $enquiries->map(function ($item) {
            return [
                'ID' => $item->id,
                'Name' => $item->name,
                'Email' => $item->email,
                'Country Code' => $item->country_code,
                'Phone' => $item->phone,
                'Subject' => $item->subject,
                'Message' => $item->message,
                'Course' => $item->courses ? $item->courses->name : '',
                'Section' => $item->section,
                'Type' => $item->type,
                'Created At' => \Carbon\Carbon::parse($item['created_at'])->format('M d, Y h:i A'),
            ];
        });

        // Export to Excel and download
        return (new FastExcel($formatted))->download('enquiries.xlsx');
    }
}
