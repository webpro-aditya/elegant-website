@if ($contents['corporate-training']->seo)
    @section('meta_tags', $contents['corporate-training']->seo->meta_contents)
    @section('meta_title', $contents['corporate-training']->seo->meta_title)
    @section('meta_description', $contents['corporate-training']->seo->meta_description)
@else
    @section('meta_title',  'Corporate Training in Dubai – Upskill Your Workforce')
    @section('meta_description', 'KHDA-approved corporate training in Dubai. Tailored programs for companies in IT, Finance, Management, and Soft Skills. Onsite & online sessions available.')
@endif

@section('title', 'Corporate Training')

@section('canonical', url()->current())


@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/corporate-training/corporate-training.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/web/corporate-training/corporate-training.js') }}"></script>
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1> {{ app()->getLocale() == 'en' ? $translations['why_choose_training_center']['value_en'] : $translations['why_choose_training_center']['value_ar'] }}
         </h1>
        <ul class="p-0 m-auto">
            <li><a href="#">{{ app()->getLocale() == 'en' ? $translations['home']['value_en'] : $translations['home']['value_ar'] }}
              </a></li>
            <li>/</li>
            <li>{{ app()->getLocale() == 'en' ? $translations['corporate_training']['value_en'] : $translations['corporate_training']['value_ar'] }} </li>
        </ul>
    </div>
    {{-- {{dd($contents['corporate-training'])}} --}}
    <div class="main-padding py-8 py-md-15 corporate-training">
        <div class="row">
            <div class="col-lg-6 pe-lg-10">
                <div class="position-relative">
                    <img src="{{ Storage::disk('elegant')->url($contents['corporate-training']->thumbnail) }}"
                        alt="{{$contents['corporate-training']->thumbnail_alt}}" title="{{$contents['corporate-training']->image_title}}" class="w-100 radius">
                </div>
            </div>
            <div class="col-lg-6 ps-lg-10">
                <p> {!! $contents['corporate-training']->defaultLocale->description !!} </p>
                <h3> {{ $contents['corporate-training']->defaultLocale->short_description }} </h3>
                <p> {!! $contents['corporate-training']->defaultLocale->content !!} </p>
            </div>
        </div>
    </div>
    <div class="main-padding pb-5 pb-md-15">
        <h2>{{ app()->getLocale() == 'en' ? $translations['course_with_elegant_center']['value_en'] : $translations['course_with_elegant_center']['value_ar'] }}  </h2>
        <div class="row">
            @foreach ($trainingCourses as $course)
                <div class="col-lg-6 pe-lg-20">
                    <div class="training-list p-5 rounded mt-5 mt-md-10">
                        <h4> {{ $course->defaultLocale->name }} </h4>
                        {!! $course->defaultLocale->description !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-web-layout>
