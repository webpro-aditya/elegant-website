@section('title', 'List Roles')

@push('script')
    <script src="{{ asset('js/roles/listRoles.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/roles/listRoles.css') }}">
@endpush

<x-layout>
    @section('toolbar')
<x-toolbar :breadcrumbs="$breadcrumbs"></x-toolbar>
@endsection

    <div class="row row-cols-1 row-cols-md-3 row-cols-xl-4 g-5 g-xl-9">
        <div class="col-md-3">
            <div class="card h-md-100">
                <div class="card-body d-flex flex-center">
                    <button type="button" class="btn btn-clear d-flex flex-column flex-center" kt-load-remote-init="false" kt-load-remote-html="true" data-url="{{ route('user_role_add') }}">
                        <img src="{{ asset('images/illustrations/sketchy-1/4.png') }}" alt="" class="mw-100 mh-150px mb-7">
                        <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                    </button>
                </div>
            </div>
        </div>
        @foreach ($roles as $role)
            
                <div class="col-md-3">
                    <div class="card card-flush h-md-100">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{ $role->name_display }}</h2>
                            </div>
                        </div>
                        <div class="card-body pt-1">
                            <div class="fw-bold text-gray-600 mb-5">Total users with this role: {{ $role->users->count() }}</div>
                        </div>
                        <div class="card-footer flex-wrap pt-0">
                            <a href="{{ route('user_role_view', ['id' => $role->id]) }}" class="btn btn-light btn-active-primary my-1 me-2">View Role</a>
                            <button type="button" class="btn btn-light btn-active-light-primary my-1" kt-load-remote-init="false" kt-load-remote-html="true" data-url="{{ route('user_role_edit', ['id' => $role->id]) }}">Edit Role</button>
                        </div>
                    </div>
                </div>
        @endforeach
    </div>
</x-layout>
