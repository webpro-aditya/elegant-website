@section('title', 'Become Mentor')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/mentor/mentor.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/web/mentor/mentor.js') }}"></script>
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1>Become Mentor at Elegant Training</h1>
        <ul class="p-0 m-auto">
            <li><a href="#">Home</a></li>
            <li>/</li>
            <li>Become Mentor</li>
        </ul>
    </div>
</x-web-layout>