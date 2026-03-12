@section('title', 'List Batches')

@push('script')
    <script src="{{ mix('js/admin/batch/listBatch.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/batch/listBatch.css') }}">
@endpush

<x-layout>

    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
            <button id="kt_drawer_add_batch_button" class="btn btn-primary">Add Batch</button>
        </x-toolbar>
    @endsection
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
                            <label class="form-label fs-5 fw-semibold mb-3">Status:</label>
                            <select id="status" class="form-select" data-kt-select2="true"
                                data-placeholder="Select status" data-allow-clear="true"
                                data-dropdown-parent="#kt-toolbar-filter">
                                <option value="">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fs-5 fw-semibold mb-3">Course:</label>
                            <select class="form-select form-control-solid mb-2" name="course_id" data-kt-select2="true"
                                id="course_id" data-server="true" data-placeholder="Select Course"
                                data-option-url="{{ route('course_active_courses') }}">
                            </select>
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
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="listBatch"
                data-url="{{ route('batch_table') }}">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th class="min-w-125px">Duration</th>
                        <th class="min-w-125px">Days</th>
                        <th class="min-w-125px">Status</th>
                        <th class="min-w-70px">Actions</th>
                    </tr>
                </thead>

                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
        </div>
    </div>





    <!--begin::Trigger button-->

    <!--end::Trigger button-->

    <!--begin::View component-->
    <div id="kt_drawer_add_batch" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#kt_drawer_add_batch_button" data-kt-drawer-close="#kt_drawer_add_batch_dismiss_close"
        data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'400px'}">

        <div class="card w-100 rounded-0">
            <div class="card-header pe-5">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">Add New
                            Batch</a>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-active-light-primary" id="kt_drawer_add_batch_dismiss_close">
                        <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
            </div>
            <div class="card-body hover-scroll-overlay-y">
                <form novalidate="novalidate" id="addBatchForm" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                    action="{{ route('batch_create') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        {{-- <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="required form-label">Name</label>
                            <input type="text" name="name" class="form-control mb-2" placeholder="Name" value="">
                            @error('name')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div> --}}
                        <div class="mb-5 fv-row fv-plugins-icon-container">
                            <label class="required form-label">Course</label>
                            <select class="form-select form-control-solid mb-2" name="course_id" data-kt-select2="true"
                                data-server="true" data-placeholder="Select Course"
                                data-option-url="{{ route('course_active_courses') }}" value="{{ old('course_id') }}">
                                @if (isset($old['course_id']) && $old['course_id'] != '')
                                    <option value="{{ $old['course_id']->id }}">
                                        {{ $old['course_id']->title }}
                                    </option>
                                @endif
                            </select>
                            @error('course_id')
                                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>

                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="required form-label">Duration</label>
                            <input type="number" id="duration" name="duration" class="form-control mb-2"
                                placeholder="Duration - Hours" value="">
                            @error('duration')
                                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="required form-label">Start Timing</label>
                            <input type="time" id="start_time" name="start_time" class="form-control mb-2"
                                placeholder="Start Time" value="">
                            @error('start_time')
                                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="required form-label">End Timing</label>
                            <input type="time" id="end_time" name="end_time" class="form-control mb-2"
                                placeholder="End Timing" value="">
                            @error('end_time')
                                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>

                    </div>



                    <div class="mb-5 fv-row fv-plugins-icon-container">
                        <button type="submit" id="btnSubmit" class="btn btn-primary fv-button-submit w-100">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout>