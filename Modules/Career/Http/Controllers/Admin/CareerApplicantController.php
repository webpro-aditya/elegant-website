<?php

namespace Modules\Career\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Modules\Career\Http\Requests\Admin\CareerApplicant\CareerApplicantListDataRequest;
use Modules\Career\Http\Requests\Admin\CareerApplicant\CareerApplicantListRequest;
use Modules\Career\Http\Requests\Admin\CareerApplicant\CareerApplicantViewRequest;
use Modules\Career\Helpers\CareerApplicantHelper;

class CareerApplicantController extends Controller
{

    protected $applicantHelper;

    public function __construct(CareerApplicantHelper $applicantHelper)
    {
        $this->applicantHelper = $applicantHelper;
    }
    public function list(CareerApplicantListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Career'],
        ];

        return view('career::admin.careerApplicants.listCareerApplicants', compact('breadcrumbs'));
    }

    public function careerListData(CareerApplicantListDataRequest $request)
    {
        $careers = $this->applicantHelper->getDatatable($request->all());
        $dataTableJSON = DataTables::of($careers)
            ->addIndexColumn()
            ->editColumn('name', function ($career) {
                $data['text'] = $career->name;

                return view('elements.listLink', compact('data'));
            })
            
            ->editColumn('career', function ($career) {
                return $career->career->title ;
            })
            ->addColumn('status', function ($career) {
                return view('elements.listStatus')->with('data', $career);
            })
            ->addColumn('action', function ($career) use ($request) {
                $data['view_url'] = route('career_applicant_view', ['id' => $career->id]);
           
                return view('elements.listAction', compact('data'));

            })
            ->make();

        return $dataTableJSON;
    }

    public function viewApplicant(CareerApplicantViewRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'course_list', 'name' => 'Course', 'permission' => 'career_applicant_read'],
            ['name' => 'View Course'],
        ];
        $applicant = $this->applicantHelper->getApplicant($request->id);

        return view('career::admin.careerApplicants.viewCareerApplicant', compact('applicant', 'breadcrumbs'));
    }
}
