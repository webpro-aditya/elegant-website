@section('title', 'View Career Applicant')

@push('script')
    <script src="{{ mix('js/admin/careerApplicant/viewCareerApplicant.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/careerApplicant/viewCareerApplicant.css') }}">
@endpush

<x-layout>


    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
        </x-toolbar>
    @endsection
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <p><strong>Name:</strong> {{ $applicant->name }}</p>
                    <p><strong>Email:</strong> {{ $applicant->email }}</p>
                    <p><strong>Linkedin Profile:</strong>
                        @if ($applicant->linkedin_profile)
                            <a href="{{ $applicant->linkedin_profile }}"  target="_blank">
                                Go to Linkedin Page
                            </a>
                        @else
                            No Profile Given!
                        @endif
                    </p>
                    <p><strong>Resume:</strong>
                        @if ($applicant->resume)
                            <a href="{{ Storage::disk('elegant')->url($applicant->resume) }}" 
                                download>
                                Download Resume
                            </a>
                        @else
                            No Resume Given!
                        @endif
                    </p>

                </div>
                <div class="col-6">
                    <p><strong>Career:</strong> 
                        <a href="{{route('career_view', ['id' => $applicant->career_id])}}">
                        
                        {{ $applicant->career->title }}</a></p>
                    <p><strong>Phone:</strong> {{ $applicant->phone }}</p>
                    <p><strong>Job Profile:</strong> {{ $applicant->job_profile }}</p>

                </div>
            </div>
        </div>
    </div>
</x-layout>
