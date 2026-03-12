@section('title', 'View Course')

@push('script')
    <script src="{{ mix('js/admin/course/mainModule/listMainModule.js') }}"></script>
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
        </x-toolbar>
    @endsection

    @include('course::admin.course.courseInfo', ['activeMenu' => 'main-modules', 'course' => $course])

    <div class="card">
        <div class="card-header">
            <div class="card-title fs-3 fw-bold">Syllabus</div>
        </div>
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
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true" data-kt-table-filter="reset">Reset</button>
                            <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true"
                                data-kt-table-filter="filter">Apply</button>
                        </div>
                    </div>
                </div>
                <a class="btn btn-primary" style="margin-right: 3px" type="button" 
                    href="{{ route('course_main_module_form', ['course_id' => $course->id]) }}" >
                    Add Syllabus <i class="ki-outline ki-plus fs-3 text-inverse-dark"></i>
                </a>
            </x-dt-toolbar>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="listMainModules"
                data-url="{{ route('course_main_module_table', ['course_id' => $course->id]) }}">

                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th class="min-w-125px">Title</th>
                        <th class="min-w-125px">Heading</th>
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
