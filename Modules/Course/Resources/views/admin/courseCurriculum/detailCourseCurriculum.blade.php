@section('title', 'Curriculum Details')

@push('script')
    <script src="{{ mix('js/admin/courseCurriculum/detailCourseCurriculum.js') }}"></script>

@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/courseCurriculum/detailCourseCurriculum.css') }}">
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
            <a href="{{ route('course_curriculum_list') }}" class="btn btn-primary mx-3">Curriculum List</a>
        </x-toolbar>
    @endsection
    <div class="card">
        <div class="row">
            <div class="col-6">
                <div class="card-body">
                    <h5 class="card-title">Name</h5>
                    <p class="card-text">{{ $curriculum->name }}</p>
                    <h5 class="card-title">Phone</h5>
                    <p class="card-text">+{{ $curriculum->country_code }} {{ $curriculum->phone }}</p>

                    <h5 class="card-title">Message</h5>
                    <p class="card-text">{!! $curriculum->message !!}</p>
                    <h5 class="card-title">Created At</h5>
                    <p class="card-text">{{ $curriculum->created_at }}</p>
                    <!-- Add more content here as needed -->
                </div>
            </div>
            <div class="col-6">
                <div class="card-body">
                    <h5 class="card-title">Email</h5>
                    <p class="card-text">{{ $curriculum->email }}</p>
                    <h5 class="card-title">Type</h5>
                    <p class="card-text">{{ $curriculum->type }}</p>
                    @if ($curriculum->course_id)
                        <h5 class="card-title">Course</h5>
                        <p class="card-text">
                            <a href="{{ route('course_view', ['id' => $curriculum->courses->id]) }}">
                                {{ $curriculum->courses->englishLocale->title }}
                            </a>
                        </p>
                    @endif
                    <h5 class="card-title">Purpose</h5>
                    <p class="card-text">{!! $curriculum->subject !!}</p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
