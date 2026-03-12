@push('script')
    <script src="{{ mix('js/admin/quiz/listQuizContent.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/quiz/listQuizContent.css') }}">
@endpush

<div class="card-header border-0 pt-6">
    <x-dt-toolbar>
        <a class="btn btn-primary" type="button" data-kt-load-drawer="true" data-url="{{ route('free_resource_quiz_add', ['resource_id' => $resource->id]) }}" data-drawer-id="add_quiz_content">
            Add Quiz Content <i class="ki-outline ki-plus fs-3 text-inverse-dark"></i>
        </a>

        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px kt-toolbar-filter" data-kt-menu="true"
            id="kt-toolbar-filter">
            <div class="px-5 py-3">
                <div class="fs-4 text-dark fw-bold">Filter Options</div>
            </div>
            <div class="separator border-gray-200"></div>
            <div class="px-5 py-3">
                <div class="mb-5">
                    <label class="form-label fs-5 fw-semibold mb-3">Status:</label>
                    <select id="status" class="form-select" data-kt-select2="true" data-placeholder="Select status"
                        data-allow-clear="true" data-dropdown-parent="#kt-toolbar-filter">
                        <option value="">All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
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
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="listQuizContents"
        data-url="{{ route('free_resource_quiz_table', ['resource_id' => $resource->id]) }}">
        <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th>#</th>
                <th class="min-w-125px">Question</th>
                <th class="min-w-125px">Status</th>
                <th class="min-w-70px">Action</th>
            </tr>
        </thead>
        <tbody class="fw-semibold text-gray-600">
        </tbody>
    </table>
</div>

