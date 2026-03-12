<?php

namespace Modules\Course\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Course\Helpers\VenueHelper;
use Modules\Course\Http\Requests\Admin\Venue\VenueAddRequest;
use Modules\Course\Http\Requests\Admin\Venue\VenueCreateRequest;
use Modules\Course\Http\Requests\Admin\Venue\VenueDeleteRequest;
use Modules\Course\Http\Requests\Admin\Venue\VenueEditRequest;
use Modules\Course\Http\Requests\Admin\Venue\VenueListDataRequest;
use Modules\Course\Http\Requests\Admin\Venue\VenueListRequest;
use Modules\Course\Http\Requests\Admin\Venue\VenueUpdateRequest;
use Yajra\DataTables\DataTables;

class VenueController extends Controller
{
    protected $venueHelper;

    public function __construct(VenueHelper $venueHelper)
    {
        $this->venueHelper = $venueHelper;
    }

    public function listVenue(VenueListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Venue'],
        ];

        return view('course::admin.venue.listVenue', compact('breadcrumbs'));
    }

    public function venueListData(VenueListDataRequest $request)
    {
        $venues = $this->venueHelper->getVenueDatatable($request->all());
        $dataTableJSON = DataTables::of($venues)
            ->addIndexColumn()
            ->editColumn('title', function ($venue) {
                $data['url'] = route('venue_edit', ['id' => $venue->id]);
                $data['text'] = $venue->title;

                return view('elements.listLink', compact('data'));
            })

            ->addColumn('status', function ($venue) {
                return view('elements.listStatus')->with('data', $venue);
            })

            ->addColumn('action', function ($venue) use ($request) {
                $data['edit_url'] = route('venue_edit', ['id' => $venue->id]);
                $data['delete_url'] = route('venue_delete', ['id' => $venue->id]);
                $data['view_url'] = route('venue_view', ['id' => $venue->id]);

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }

    public function viewVenue(VenueListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'venue_list', 'name' => 'Venue', 'permission' => 'venue_read'],
            ['name' => 'View Venue'],
        ];
        $venue = $this->venueHelper->getVenue($request->id);

        return view('course::admin.venue.viewVenue', compact('venue', 'breadcrumbs'));
    }

    public function addVenue(VenueAddRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'venue_list', 'name' => 'Venue', 'permission' => 'venue_read'],
            ['name' => 'Add Venue'],
        ];

        return view('course::admin.venue.addVenue', compact('breadcrumbs'));
    }

    public function createVenue(VenueCreateRequest $request)
    {
        $inputData = [
            'title' => $request->title,
            'status' => $request->status,
        ];
        $venue = $this->venueHelper->save($inputData);

        activity()->performedOn($venue)->event('Venue Created')->withProperties(['id' => $venue->id, 'data' => $inputData])->log('Venue Created');

        if($request->editCourse && $request->editCourse == 'yes'){
            return redirect()
            ->back()
            ->with('success', 'Venue added successfully');
        }else{
            return redirect()
            ->route('venue_list')
            ->with('success', 'Venue added successfully');
        }

    }

    public function editVenue(VenueEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'venue_list', 'name' => 'Venue', 'permission' => 'venue_read'],
            ['name' => 'Venue Details'],
        ];
        $venue = $this->venueHelper->getVenue($request->id);

        return view('course::admin.venue.listVenue', compact('venue', 'breadcrumbs'));
    }

    public function updateVenue(VenueUpdateRequest $request)
    {
        $inputData = [
            'id' => $request->id,
            'title' => $request->title,
            'status' => $request->status,
        ];

        $venue = $this->venueHelper->update($inputData);

        activity()->performedOn($venue)->event('Venue Updated')->withProperties(['id' => $venue->id, 'data' => $inputData])->log('Venue Created');

        return redirect()
            ->route('venue_list')
            ->with('success', 'Venue updated successfully');
    }

    public function deleteVenue(VenueDeleteRequest $request)
    {
        if ($this->venueHelper->delete($request->id)) {
            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'Venue deleted successfully']);
            } else {
                return redirect()->route('venue_list')->with('success', 'Venue deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('venue_list')->with('success', 'Failed to delete');
        }
    }

    public function venueOptions(Request $request)
    {
        $term = trim($request->search);
        $venues = $this->venueHelper->searchVenue($term);
        $venuesOptions = [];

        foreach ($venues as $venue) {
            $venuesOptions[] = ['id' => $venue->id, 'text' => $venue->title];
        }

        return response()->json($venuesOptions);
    }
}
