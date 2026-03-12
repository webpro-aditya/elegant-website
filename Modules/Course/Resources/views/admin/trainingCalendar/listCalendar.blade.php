@section('title', 'List Training Calendar')

@push('script')
    <script src="{{ mix('js/admin/trainingCalendar/listCalendar.js') }}"></script>
    <script>
        $(document).ready(function () {
            @if(session('excludedMessage'))
                var excludedMessage = {!! json_encode(session('excludedMessage')) !!};
                Swal.fire({
                    title: 'Excluded Rows',
                    html: excludedMessage,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endpush


<x-layout>
    <x-toolbar :breadcrumbs="$breadcrumbs">
        <button class="btn btn-bg-success btn-active-color-primary me-3 text-inverse-dark" data-kt-drawer-show="true" data-kt-drawer-target="#kt_drawer_add_training_calendar"> Bulk Upload <i class="ki-outline ki-plus fs-3 text-inverse-dark"></i></button>
        <a href="{{route('training_calendar_csv_download')}}"><button class="btn btn-bg-success btn-active-color-primary me-3 text-inverse-dark" > Download Sample CSV <i class="fa-solid fa-file-csv fs-3 text-inverse-dark"></i> </button></a>
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
                            <label class="form-label fs-5 fw-semibold mb-3">Status:</label>
                            <select id="status" class="form-select" data-kt-select2="true"
                                data-placeholder="Select status" data-allow-clear="true"
                                data-dropdown-parent="#kt-toolbar-filter">
                                <option value="">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="outdate">Outdate</option>
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
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="listCalendar"
                data-url="{{ route('training_calendar_table') }}">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th class="min-w-125px">Title</th>
                        <th class="min-w-125px">Course</th>
                        <th class="min-w-125px">Batch</th>
                        <th class="min-w-125px">Start Date</th>
                        <th class="min-w-125px">End Date</th>
                        <th class="min-w-125px">Status</th>
                    </tr>
                </thead>

                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="csvUploadModal" tabindex="-1" aria-labelledby="csvUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="csvUploadModalLabel">CSV Bulk Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="csvUploadForm" action="/upload-csv" method="POST" enctype="multipart/form-data"
                        action="{{ route('training_calendar_bulk_import') }}">
                        @csrf
                        <div class="form-group">
                            <label for="csvFile">Choose CSV file</label>
                            <input type="file" class="form-control-file" id="csvFile" name="csvFile" accept=".csv"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_drawer_add_training_calendar" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="training_calendar" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'500px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_drawer_add_training_calendar_toggle" data-kt-drawer-close="#kt_drawer_add_training_calendar_close">
        <div class="card shadow-none border-0 rounded-0 w-100">
            <div class="card-header" id="kt_drawer_add_training_calendar_header">
                <h3 class="card-title fw-bold text-gray-900">Bulk Upload Training Calendar</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_drawer_add_training_calendar_close">
                        <i class="ki-outline ki-cross fs-1"></i> </button>
                </div>
            </div>
            <div class="card-body position-relative" id="kt_drawer_add_training_calendar_body">
                <form novalidate="novalidate" id="addTrainingCalendarForm" action="{{ route('training_calendar_bulk_import') }}" method="POST" class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-column mb-12 fv-row">
                        <label class="required fw-semibold fs-6 mb-2">Title</label>
                        <input type="file" class="form-control form-control-solid" id="csvFile" name="csvFile" accept=".csv"/>
                    </div>

                    <div class="text-center pt-10">
                        <button type="button" class="btn btn-primary" id="kt_drawer_add_training_calendar_close">Discard </button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
