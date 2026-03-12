@section('title', 'solution')

@push('script')
    <script src="{{ mix('js/web/solution.js') }}"></script>
@endpush
@section('canonical', url()->current())

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/solution.css') }}">
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1> {{ app()->getLocale() == 'en' ? $translations['quiz_analysis']['value_en'] : $translations['quiz_analysis']['value_ar'] }}
        </h1>
        <ul class="p-0 m-auto">
            <li><a href="#">{{ $resource->name }}</a></li>
            <li>/</li>
            <li><a href="#"> {{ $resource->name }} {{ app()->getLocale() == 'en' ? $translations['quiz']['value_en'] : $translations['quiz']['value_ar'] }}</a></li>
            <li>/</li>
            <li>{{ app()->getLocale() == 'en' ? $translations['solution']['value_en'] : $translations['solution']['value_ar'] }}</li>
        </ul>
    </div>
    <div class="main-padding my-10">
        <div class="row">
            <div class="col-md-8">
                <div class="questian-container p-5 py-10">
                    <p id="question-number" class="d-none"></p>
                    <h4 id="question-text" class="mb-0"></h4>
                </div>
                <div id="options-container" class="answer-container p-5 py-10 mt-10">
                    <!-- Options will be appended here -->
                </div>
                <div><a href="{{ route('web_free_resource_view', ['slug' => $resource->slug]) }}"
                        class="btn style-btn mt-5">Go to Quiz</a></div>
            </div>



            <div class="col-md-4 question-number" id="question-container"
                data-url="{{ route('web_free_resource_questions') }}">
                <div class="number-container rounded-3 p-5 p-lg-10">
                    <div class="col-12 text-center mb-5">
                        <h4>Question</h4>
                    </div>


                    @foreach ($resource->quizzes as $question)
                        <div class="number text-center" data-q-id="{{ $question->defaultLocale->id }}"
                            data-r-id="{{ $resource->id }}">
                            {{ $loop->iteration }}
                        </div>
                    @endforeach

                </div>
                <div><a href="{{ route('web_home', ['locale' => app()->getLocale()]) }}"
                        class="btn style-btn mt-5 float-end">Home</a></div>
            </div>
        </div>
    </div>
</x-web-layout>
