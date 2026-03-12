@section('title', 'List Pages')

@push('script')
<script src="{{ mix('js/admin/pages/listPage.js') }}"></script>
@endpush

@push('style')
<link rel="stylesheet" type="text/css" href="{{ mix('css/admin/pages/listPage.css') }}">
@endpush

<x-layout>
    @section('toolbar')
    <x-toolbar :breadcrumbs="$breadcrumbs">
    </x-toolbar>
    @endsection
    
    <div class="card">

        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="listPages" data-url="{{ route('pages_table') }}">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th class="min-w-125px">Title</th>
                        <th class="min-w-70px">Actions</th>
                    </tr>
                </thead>

                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
        </div>
    </div>
</x-layout>