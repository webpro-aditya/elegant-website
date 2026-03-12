@section('title', 'List Content')

@push('script')
    <script src="{{ mix('js/admin/contents/listContent.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/contents/listContent.css') }}">
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
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
                            <select id="status" class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                data-placeholder="Select status" data-dropdown-parent="#kt-toolbar-filter">
                                <option value="">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        @if($category == 'feature' || $category == 'join-now-for-course' ||  $category == 'top-companies-hiring' || $category == 'banner-features')
                            <div class="mb-5">
                                <label class="form-label fs-5 fw-semibold mb-3">Course:</label>
                                <select class="form-select form-control-solid mb-2" name="course_id" data-kt-select2="true"
                                    id="course_id" data-server="true" data-placeholder="Select Course"
                                    data-option-url="{{ route('course_active_courses') }}">
                                </select>
                            </div>
                        @endif
                        <input type="hidden" id="content_slug" name="content_slug" value="{{ $slug }}">
                        <input type="hidden" id="category_slug" name="category_slug" value="{{ $category }}">
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2 reset" data-kt-table-filter="reset"
                                data-kt-menu-dismiss="true">Reset</button>
                            <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true"
                                data-kt-table-filter="filter">Apply</button>
                        </div>
                    </div>
                </div>
                {{-- @can('contents_create')
                @if ($categorySlug != '')
                <a href="{{ route('admin_contents_add', ['category_slug' => $categorySlug]) }}"
                    class="btn btn-primary">Add
                    Content</a>
                @elseif($slug != '')
                <a href="{{ route('admin_contents_add', ['slug' => $slug]) }}" class="btn btn-primary">Add
                    Content</a>
                @else
                <a href="{{ route('admin_contents_add') }}" class="btn btn-primary">Add
                    Content</a>
                @endif
                @endcan --}}
                @if (!isset($slug) || !$slugsArray->contains($slug))
                    @if ($category != null && $slug == null)
                        <a href="{{ route('contents_add', ['category' => $category]) }}" class="btn btn-primary">Add Content</a>
                    @elseif ($slug != null && $category == null)
                        <a href="{{ route('contents_add', ['slug' => $slug]) }}" class="btn btn-primary">Add Content</a>
                    @else
                        <a href="{{ route('contents_add') }}" class="btn btn-primary">Add Content</a>
                    @endif
                @endif

            </x-dt-toolbar>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="listContents"
                data-url="{{ route('contents_contentsTable') }}">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th class="min-w-125px">Name</th>
                        @if ($category === "testimonials")
                        <th class="min-w-125px">Course</th>
                        @endif
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