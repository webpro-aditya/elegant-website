@section('title', 'List Brochure')

@push('script')
    <script src="{{ mix('js/admin/brochure/listBrochure.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/brochure/listBrochure.css') }}">
@endpush

<x-layout>
    {{-- <x-toolbar :breadcrumbs="$breadcrumbs">
        <a href="{{ route('blog_category_add') }}" class="btn btn-primary">Add Blog Category</a>
        <a href="{{ route('blog_add') }}" class="btn btn-primary mx-3">Add Blog</a>
    </x-toolbar> --}}
    <div class="card">
        <div class="card-header border-0 pt-6">
            {{-- <x-dt-toolbar>
                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px kt-toolbar-filter" data-kt-menu="true"
                    id="kt-toolbar-filter">
                    <div class="px-5 py-3">
                        <div class="fs-4 text-dark fw-bold">Filter Options</div>
                    </div>
                    <div class="separator border-gray-200"></div>
                    <div class="px-5 py-3">
                        <div class="mb-5">
                            <label class="form-label fs-5 fw-semibold mb-3">Type:</label>
                            <select id="type" class="form-select" data-kt-select2="true"
                                data-placeholder="Select type" data-allow-clear="true"
                                data-dropdown-parent="#kt-toolbar-filter">
                                <option value="">All</option>
                                <option value="corporate">Corporate</option>
                                <option value="individual">Individual</option>
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
            </x-dt-toolbar> --}}
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="listBrochure"
            data-url="{{ route('brochure_table') }}" >

                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th class="min-w-125px">Name</th>
                        <th class="min-w-125px">Email</th>
                        <th class="min-w-70px">Actions</th>
                    </tr>
                </thead>

                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
