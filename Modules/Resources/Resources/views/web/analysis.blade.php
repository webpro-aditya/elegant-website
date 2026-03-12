@section('title', 'Quiz')

@push('script')
    <script src="{{ mix('js/web/analysis.js') }}"></script>
@endpush
@section('canonical', url()->current())

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/analysis.css') }}">
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1>Quiz Analysis</h1>
        <ul class="p-0 m-auto">
            <li><a href="#">{{ $result->resource->name }}</a></li>
        </ul>
    </div>

    <div class="main-padding my-10">
        <div class="row">
            <div class="col-lg-6">
                <div class="rank-container p-5 py-10 rounded-3">
                    <h3 class="mb-3">Rank</h3>
                    <h4 class="mb-0"><b>{{ $data['rank'] }}</b> <span>{{ $data['status'] }}</span></h4>
                    <p class="mb-0 mt-3"><img src="{{ asset('images/web/participants.png') }}" alt="">
                        {{ $data['totalPlayers'] }} Participants</p>
                </div>
                <div class="grahp-container p-5 py-10 mt-10 rounded-3">

                </div>
                <div><a href="{{route('web_free_resource_view', ['slug' => $result->resource->slug])}}" class="btn style-btn mt-5">Go to Quiz</a></div>
            </div>
            <div class="col-lg-6 question-number mt-5 mt-lg-0">
                <div class="time-container rounded-3 p-5 px-5 px-md-10">
                    <div class="row">
                        <div class="col-12 col-md-6 mt-5">
                            <p><img class="mx-2" src="{{ asset('images/web/score.png') }}" alt="">
                                <b>Score:</b> {{ $result->score }}/{{ $result->resource->quizzes->count() }}</p>
                        </div>
                        {{-- <div class="col-12 col-md-6 mt-5">
                            <p><img class="mx-2" src="{{ asset('images/web/attempt.png') }}" alt=""> <b>Attempt:</b> 1</p>
                        </div> --}}
                        <div class="col-12 col-md-6 mt-5">
                            <p><img class="mx-2" src="{{ asset('images/web/time.png') }}" alt="">
                                <b>Time:</b>{{ $result->time_taken }}</p>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <p><img class="mx-2" src="{{ asset('images/web/accuracy.png') }}" alt="">
                                <b>Accuracy:</b> {{ $result->accuracy }}%</p>
                        </div>
                    </div>
                </div>
                <div class="number-container rounded-3 p-5 p-lg-10 mt-10">
                    <div class="col-12 text-center mb-5">
                        <h4>Your Answer</h4>
                    </div>
                    @foreach ($questionStatuses as $question)
                        <div class="number text-center {{ $question['status'] }}">
                            {{ $question['number'] }}
                        </div>
                    @endforeach
                </div>
                <div><a href="{{route('web_free_resource_solution', ['slug' => $result->resource->slug])}}" class="btn style-btn mt-5 float-end">View Solution</a></div>
            </div>
        </div>
    </div>
</x-web-layout>
