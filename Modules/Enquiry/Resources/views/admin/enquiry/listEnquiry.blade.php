@section('title', 'List Enquiry')

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ mix('js/admin/enquiry/listEnquiry.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/enquiry/listEnquiry.css') }}">
@endpush

<x-layout>
    <x-toolbar :breadcrumbs="$breadcrumbs">
        <a href="{{ route('enquiry_export') }}" class="btn btn-primary">Export Enquiry</a>
    </x-toolbar>
    <div class="card">
        <div class="card-header border-0 pt-6">
            <x-dt-toolbar>
                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px kt-toolbar-filter" data-kt-menu="true"
                    id="kt-toolbar-filter">
                    <div class="px-5 py-3">
                        <div class="fs-4 text-dark fw-bold">Filter Options</div>
                    </div>
                    <div class="separator border-gray-200"></div>
                    <div class="px-5 py-3">
                        <div class="mb-5">
                            <label class="form-label fs-5 fw-semibold mb-3">Type:</label>
                            <select id="type" class="form-select" data-kt-select2="true" data-placeholder="Select type"
                                data-allow-clear="true" data-dropdown-parent="#kt-toolbar-filter">
                                <option value="">All</option>
                                <option value="course_enquiry">COURSE ENQUIRY</option>
                                <option value="demo_class">DEMO CLASS</option>
                                <option value="training_calender_enquiry">TRAINING CALENDAR</option>
                                <option value="contact_form"> CONTACT FORM </option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fs-5 fw-semibold mb-3">Course:</label>
                            <select class="form-select form-control-solid mb-2" name="course_id" data-kt-select2="true"
                                id="course_id" data-server="true" data-placeholder="Select Course"
                                data-option-url="{{ route('course_active_courses') }}">
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fs-5 fw-semibold mb-3">Date Range:</label>
                            <input type="text" class="form-control" id="date_range" placeholder="Select date range">
                            <input type="hidden" id="start_date" name="start_date">
                            <input type="hidden" id="end_date" name="end_date">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true" data-kt-table-filter="reset">Reset</button>
                            <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true"
                                data-kt-table-filter="filter">Apply</button>
                        </div>
                    </div>
                </div>
            </x-dt-toolbar>

        </div>

        <div class="card-body pt-0">

            <table class="table align-middle table-row-dashed fs-6 gy-5" id="listEnquiry"
                data-url="{{ route('enquiry_table') }}" data-kt-export-initialized="true">

                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th class="min-w-125px">Name</th>
                        <th class="min-w-125px">Email</th>
                        <th class="min-w-125px">Type</th>
                        <th class="min-w-125px">Create At</th>
                        <th class="min-w-70px export-none">Actions</th>
                    </tr>
                </thead>

                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
        </div>
    </div>
</x-layout>