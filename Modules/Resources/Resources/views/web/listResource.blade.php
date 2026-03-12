@section('title', 'Detail Blog')

@push('script')
    <script src="{{ mix('js/web/detail.js') }}"></script>
@endpush
@section('canonical', url()->current())

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/detail.css') }}">
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1>{{ $resource->defaultLocale->name }} </h1>
        <ul class="p-0 m-auto">
            <li><a href="{{ route('web_home', ['locale' => app()->getLocale()]) }}">{{ app()->getLocale() == 'en' ? $translations['home']['value_en'] : $translations['home']['value_ar'] }}
                </a>
            </li>
            <li>/</li>
            <li>{{ app()->getLocale() == 'en' ? $translations['resource_details']['value_en'] : $translations['resource_details']['value_ar'] }}
            </li>
        </ul>
    </div>
    <div class="main-padding pt-10 pb-10 pb-md-15">
        <div class="row">
            <div class="col-lg-7">
                <div class="row">
                    <img src="{{ Storage::disk('elegant')->url($resource->thumbnail) }}"
                        alt="{{ $resource->thumbnail_alt }}" title="{{ $resource->image_title }}"
                        class="w-100 blog-img mb-3">
                    <p>{{ $resource->defaultLocale->short_description }}</p>
                    <p>{!! $resource->defaultLocale->description !!}</p>
                </div>

                <div class="table-of-contents mb-6">
                    <h3>{{ app()->getLocale() == 'en' ? $translations['table_of_contents']['value_en'] : $translations['table_of_contents']['value_ar'] }}
                    </h3>
                    <ol>
                        @foreach ($contents as $index => $content)
                            <li><a href="#content-{{ $index }}">{{ $content->defaultLocale->question }}</a>
                            </li>
                        @endforeach
                    </ol>
                </div>

                <div class="content">
                    <div class="mb-6">
                        <h3>{{ app()->getLocale() == 'en' ? $translations['basic']['value_en'] : $translations['basic']['value_ar'] }}
                            {{ $resource->defaultLocale->name }}
                            {{ app()->getLocale() == 'en' ? $translations['interview_questions_for_freshers']['value_en'] : $translations['interview_questions_for_freshers']['value_ar'] }}
                        </h3>
                        <p>{{ app()->getLocale() == 'en' ? $translations['the_following_are_the']['value_en'] : $translations['the_following_are_the']['value_ar'] }}
                            {{ $resource->defaultLocale->name }}
                            {{ app()->getLocale() == 'en' ? $translations['answer_for_freshers']['value_en'] : $translations['answer_for_freshers']['value_ar'] }}
                        </p>
                    </div>

                    <div id="resource-contents">
                        @foreach ($contents as $index => $content)
                            <div id="content-{{ $index }}" class="mb-6">
                                <h3> {{ $content->defaultLocale->question }}</h3>
                                <p> {!! $content->defaultLocale->answer !!} </p>
                                @if ($content->link)
                                    <div class="video-list position-relative">
                                        <iframe width="100%" height="300" src="{{ $content->link }}"
                                            frameborder="0" allowfullscreen class="rounded-5 "></iframe>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <input type="hidden" name="quiz_id" id="quiz_id" value="{{$resource->id}}">

                @if ($resource->type == 'quiz')
                    <div class="start-quiz-container rounded-3 p-5 p-md-10">
                        {{-- <p>{{$resource->defaultLocale->name}}</p> --}}
                        <h3 class="mb-5">{{$resource->defaultLocale->name}}</h3>
                        <div class="d-flex justify-content-between mb-3">
                            <h3>Questions :</h3>
                            <h3>{{$resource->quizzes->count()}}</h3>
                        </div>
                        <div class="line-contr my-7"></div>
                        <div class="d-flex justify-content-between">
                            <h3>Total Time :</h3>
                            <h3>{{$resource->time}}</h3>
                        </div>
                        
                        <a href="{{ route('web_free_resource_quiz', ['quiz' => $resource->slug]) }}" class="btn start-quiz-btn m-auto d-table mt-5">Start Quiz</a>
                    </div>
                @endif
            </div>


            <div class="col-5 blog-sidebar ps-lg-15">
                <h2 class="mb-5">{{ $resource->defaultLocale->name }}
                    {{ app()->getLocale() == 'en' ? $translations['popular']['value_en'] : $translations['popular']['value_ar'] }}
                </h2>

                <div class="popular-container">
                    @foreach ($latests as $latest)
                        <div class="popular-list position-relative">
                            <a href="{{ route('web_free_resource_view', ['slug' => $latest->slug]) }}">
                                <img src="{{ Storage::disk('elegant')->url($latest->thumbnail) }}"
                                    alt="{{ $latest->thumbnail_alt }}">
                                <p class="content">{{ $latest->defaultLocale->short_description }} </p>
                            </a>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</x-web-layout>
