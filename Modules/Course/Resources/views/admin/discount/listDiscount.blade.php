@section('title', 'List Discount')

@push('script')
    <script src="{{ mix('js/admin/discount/listDiscount.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/discount/listDiscount.css') }}">
@endpush

<x-layout>
    <x-toolbar :breadcrumbs="$breadcrumbs">
        <a href="{{ route('discount_add') }}" class="btn btn-primary mx-3">Add Discount Coupon</a>
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
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="listDiscounts"
                data-url="{{ route('discount_table') }}">
                <thead>
                        <th>#</th>
                        <th class="min-w-125px">Title</th>
                        <th class="min-w-125px">Discount Code</th>
                        <th class="min-w-125px">Discount Percentage</th>
                        <th class="min-w-125px">Valid From</th>
                        <th class="min-w-125px">Valid To</th>
                        <th class="min-w-125px">Attempts Per User</th>
                        <th class="min-w-125px">Status</th>
                        <th class="min-w-70px">Actions</th>
                    </tr>
                </thead>

                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
