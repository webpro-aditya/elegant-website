@section('title', 'List Topics')

@push('script')
<script src="{{ mix('js/admin/topic/listTopic.js') }}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
@endpush

@push('style')
<link rel="stylesheet" type="text/css" href="{{ mix('css/admin/topic/listTopic.css') }}">
@endpush

<x-layout>
{{-- @section('toolbar') --}}
<x-toolbar :breadcrumbs="$breadcrumbs">
        @can('topic_create')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#topicModal">
            <i class="ki-outline ki-plus fs-2"></i>Add Topic</button>
        @endcan
    </x-toolbar>
{{-- @endsection --}}


    <div class="card">
        <div class="card-header border-0 pt-6">
            <x-dt-toolbar>
                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px kt-toolbar-filter" data-kt-menu="true" id="kt-toolbar-filter">
                    <div class="px-5 py-3">
                        <div class="fs-4 text-dark fw-bold">Filter Options</div>
                    </div>
                    <div class="separator border-gray-200"></div>
                    <div class="px-5 py-3">
                    <div class="mb-5">
                            <label class="form-label fs-5 fw-semibold mb-3">Course Category:</label>
                            <select id="category_id" class="form-select" data-kt-select2="true" data-server="true"
                                data-placeholder="Select Category" data-allow-clear="true"
                                data-option-url="{{ route('course_category_options') }}"
                                data-dropdown-parent="#kt-toolbar-filter">
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-table-filter="reset">Reset</button>
                            <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-table-filter="filter">Apply</button>
                        </div>
                    </div>
                </div>
            </x-dt-toolbar>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="listTopic" data-url="{{ route('topic_table') }}">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th class="min-w-125px">Code</th>
                        <th class="min-w-125px">Title</th>
                        <th class="min-w-125px">Category</th>
                        <th class="min-w-70px">Actions</th>
                    </tr>
                </thead>

                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
        </div>
    </div>
    @include('course::admin.topic.widgets.addTopic', ['categories' => $categories])

    @if(isset($topic))
    @include('course::admin.topic.widgets.editTopic', ['topic' => $topic, 'categories' => $categories])
    @endif
</x-layout>
