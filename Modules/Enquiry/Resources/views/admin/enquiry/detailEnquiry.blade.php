@section('title', 'Enquiry Details')

@push('script')
    <script src="{{ mix('js/admin/enquiry/detailEnquiry.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/enquiry/detailEnquiry.css') }}">
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
            <a href="{{ route('enquiry_list') }}" class="btn btn-primary mx-3">Enquiry List</a>
        </x-toolbar>
    @endsection
    <div class="card">
        <div class="row">
            <div class="col-6">
                <div class="card-body">
                    <h5 class="card-title">Name</h5>
                    <p class="card-text">{{ $enquiry->name }}</p>
                    <h5 class="card-title">Phone</h5>
                    <p class="card-text">+{{ $enquiry->country_code }} {{ $enquiry->phone }}</p>

                    <h5 class="card-title">Message</h5>
                    <p class="card-text">{!! $enquiry->message !!}</p>
                    <h5 class="card-title">Created At</h5>
                    <p class="card-text">{{ $enquiry->created_at }}</p>
                    <!-- Add more content here as needed -->
                </div>
            </div>
            <div class="col-6">
                <div class="card-body">
                    <h5 class="card-title">Email</h5>
                    <p class="card-text">{{ $enquiry->email }}</p>
                    <h5 class="card-title">Type</h5>
                    <p class="card-text">{{ $enquiry->type }}</p>
                    @if ($enquiry->course_id)
                        <h5 class="card-title">Course</h5>
                        <p class="card-text">
                            <a href="{{ route('course_view', ['id' => $enquiry->courses->id]) }}">
                                {{ $enquiry->courses->englishLocale->title }}
                            </a>
                        </p>
                    @endif
                    <h5 class="card-title">Purpose</h5>
                    <p class="card-text">{!! $enquiry->subject !!}</p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
