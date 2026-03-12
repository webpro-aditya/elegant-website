@section('meta_title',  'Elegant Training Center Dubai | KHDA Approved Training Center')
@section('meta_description', 'At Elegant Training Center, we are dedicated to providing high-quality training programs. We are KHDA approved and Autodesk Authorized Training Center.')
@section('title', 'Home')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/home/home.css') }}">
@endpush
@section('canonical', url()->current())

@push('script')
    <script src="{{ mix('js/web/home/home.js') }}"></script>
@endpush
<x-web-layout>
    <section id="banner_title_contents_section" class="main-padding pt-15">
        <div class="row">
            <div class="col-md-6 banner-title-area-col">
                <div class="banner-title-area">
                    <h1><span>{{ $contents['elegant-training-1']->defaultLocale->name }}</span>
                        {{ $contents['elegant-training-1']->defaultLocale->short_description }}
                    </h1>
                    <div class="banner-btn">
                        <a href="{{ route('web_about') }}">
                            <button>
                                {{ app()->getLocale() == 'en' ? $translations['about_us']['value_en'] : $translations['about_us']['value_ar'] }}
                                <span>
                                    <img src="{{ asset('images/web/elegant-svg/banner-btn-arw.svg') }} " class="mx-2"
                                        alt="">
                                </span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 banner-description-area-col">
                <div class="banner-description-area">
                    <p>{!! $contents['elegant-training-1']->defaultLocale->description !!}</p>
                </div>
            </div>
        </div>
    </section>

    <section id="banner_slider_section" class="position-relative">
        <div class="banner-slider-rotation">
            <img class="round-arrow" src="{{ asset('images/web/elegant-svg/rotate-arw.svg') }}" alt="">
            <img class="round-text" src="{{ asset('images/web/elegant-svg/round-text.svg') }}" alt="">
        </div>
        <div class="owl-carousel owl-theme banner">
            @foreach ($contents['elegant-banner']->items as $item)
                <div class="item">
                    <img src="{{ Storage::disk('elegant')->url($item->image_path) }}" class="img-fluid" alt=""
                        title="{{ $item->title }}">
                </div>
            @endforeach
        </div>
    </section>

    <section id="global_compamies_section" class="mt-5">
        <div class="global-companies-working-area main-padding">
            <div class="global-companies-title text-center">
                <h3> {{ $contents['companies-and-startups']->defaultLocale->name }}</h3>
            </div>
            <div class="owl-carousel owl-theme working">
                @foreach ($contents['companies-and-startups']->items as $item)
                    <div class="item">
                        <img class="img-fluid" src="{{ Storage::disk('elegant')->url($item->image_path) }}" alt=""
                            title="{{ $item->title }}">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <div class="training-center-section">
        <div class="main-padding text-center py-4">Elegant Training Center is approved and permitted by Knowledge and
            Human Development Authority (KHDA),</div>
    </div>
    <section id="types_of_courses_section" class="main-padding my-7">
        <div class="section-title text-center">
            <h2>{{ $contents['build-your-career-your-way']->defaultLocale->name }}</h2>
            <p>{!! $contents['build-your-career-your-way']->defaultLocale->description !!}</p>
        </div>
        <div class="types-of-courses-boxes">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 types-of-courses-boxes-contents-area-col">
                    <div class="types-of-courses-boxes-contents-area">
                        <img class="course-image img-fluid"
                            src="{{ Storage::disk('elegant')->url($contents['live-online-courses']->thumbnail) }}"
                            title="{{ $contents['live-online-courses']->image_title }}"
                            alt="{{ $contents['live-online-courses']->thumbnail_alt }}">
                        <h3>{{ $contents['live-online-courses']->defaultLocale->name }} </h3>
                        <div class="content">{!! $contents['live-online-courses']->defaultLocale->description !!}</div>

                        @if ($contents['live-online-courses']->link != null)
                            <a href="{{ $contents['live-online-courses']->link }}">
                                {{ app()->getLocale() == 'en' ? $translations['view_more']['value_en'] : $translations['view_more']['value_ar'] }}
                        @endif

                            <!-- <a href="{{ $contents['live-online-courses']->link }}">{{ trans('home/home.view_more') }}
 
                            <span>
                                <img src="{{ asset('images/web/elegant-svg/rotate-arw.svg') }}" alt=""
                                    class="mx-2">
                            </span></a> -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 types-of-courses-boxes-contents-area-col">
                    <div class="types-of-courses-boxes-contents-area">
                        <img class="course-image img-fluid"
                            src="{{ Storage::disk('elegant')->url($contents['offline-courses']->thumbnail) }}"
                            title="{{ $contents['offline-courses']->image_title }}"
                            alt="{{ $contents['offline-courses']->thumbnail_alt }}">
                        <h3>{{ $contents['offline-courses']->defaultLocale->name }}</h3>
                        <div class="content">{!! $contents['offline-courses']->defaultLocale->description !!}</div>

                        @if ($contents['offline-courses']->link != null)
                            <a href="{{ $contents['offline-courses']->link }}">
                                {{ app()->getLocale() == 'en' ? $translations['view_more']['value_en'] : $translations['view_more']['value_ar'] }}
                                <span>
                        @endif

                                <!-- <a href="{{ $contents['offline-courses']->link }}">{{ trans('home/home.view_more') }} <span>
 
                                <img src="{{ asset('images/web/elegant-svg/rotate-arw.svg') }}" alt=""
                                    class="mx-2">
                            </span></a> -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 types-of-courses-boxes-contents-area-col">
                    <div class="types-of-courses-boxes-contents-area">
                        <img class="course-image img-fluid"
                            src="{{ Storage::disk('elegant')->url($contents['self-paced-courses']->thumbnail) }}"
                            title="{{ $contents['self-paced-courses']->image_title }}"
                            alt="{{ $contents['self-paced-courses']->thumbnail_alt }}">
                        <h3>{{ $contents['self-paced-courses']->defaultLocale->name }}</h3>
                        <div class="content">{!! $contents['self-paced-courses']->defaultLocale->description !!}</div>

                        @if ($contents['self-paced-courses']->link != null)
                            <a href="{{ $contents['self-paced-courses']->link }}">
                                {{ app()->getLocale() == 'en' ? $translations['view_more']['value_en'] : $translations['view_more']['value_ar'] }}
                        @endif

                            <!-- <a href="{{ $contents['self-paced-courses']->link }}">{{ trans('home/home.view_more') }}
 
                            <span>
                                <img src="{{ asset('images/web/elegant-svg/rotate-arw.svg') }}" alt=""
                                    class="mx-2">
                            </span></a> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="elegant_training_section" class="m-top main-padding">
        <div class="elegant-training-contents-area">
            <div class="row m-0">
                <div class="col-lg-6 elegant-training-image-area-col">
                    <div class="elegant-training-image-area">
                        @if ($contents['elegant-training-section']->thumbnail)
                            <img class="training-main-image"
                                src="{{ Storage::disk('elegant')->url($contents['elegant-training-section']->thumbnail) }}"
                                title="{{ $contents['elegant-training-section']->image_title }}"
                                alt="{{ $contents['elegant-training-section']->thumbnail_alt }}">
                        @else
                            <img class="training-main-image" src="{{ asset('images/web/training.png') }}" alt="">
                        @endif
                        <img class="img-fluid trainig-square-image" src="{{ asset('images/web/trainig-square.png') }}"
                            alt="">
                        <img class="img-fluid training-triangle-image"
                            src="{{ asset('images/web/training-triangle.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 elegant-training-description-area-col">
                    <div class="elegant-training-description-area">
                        <div class="section-title">
                            <h2>{{ $contents['elegant-training-section']->defaultLocale->name }}</h2>
                            <p>{{ strip_tags($contents['elegant-training-section']->defaultLocale->description) }}</p>
                        </div>
                        <div class="elegant-training-description-bottom">
                            <img class="" src="{{ asset('images/web/elegant-svg/training-bottom.svg') }}" alt="">
                            <h3>{{ $contents['elegant-training-section']->defaultLocale->short_description }}</h3>
                            <p>{{ strip_tags($contents['elegant-training-section']->defaultLocale->content) }} </p>
                        </div>
                    </div>
                    <div class="elegant-training-contents-area-button">
                        <a href="{{ $contents['elegant-training-section']->link }}">
                            <button>{{ app()->getLocale() == 'en' ? $translations['learn_more']['value_en'] : $translations['learn_more']['value_ar'] }}
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="explore_online_course_section">
        <div class="explore-online-course main-padding">
            <div class="section-title">
                <h2> {{ app()->getLocale() == 'en' ? $translations['explore_our_live_online_courses']['value_en'] : $translations['explore_our_live_online_courses']['value_ar'] }}
                </h2>
            </div>
            <div class="explore-online-course-slider-area">
                <div class="owl-carousel owl-theme explore">
                    @foreach ($courses as $course)
                                        @php
                                            $thumbnailPath = $course->thumbnail_url;
                                        @endphp
                                        <div class="item">
                                            <a
                                                href="{{ route('web_course_detail', ['locale' => app()->getLocale(), 'course' => $course->slug]) }}">

                                                <div class="explore-image-area">
                                                    <img class="explore-main-image"
                                                        src="{{ $thumbnailPath && Storage::disk('elegant')->exists($thumbnailPath) ? Storage::disk('elegant')->url($thumbnailPath) : asset('images/web/course-1.png') }}"
                                                        alt="{{ $course->thumbnail_alt }}" title="{{ $course->image_title }}">

                                                    <div class="image-overlay-text">
                                                        <p> {{ app()->getLocale() == 'en' ? $translations['new_course']['value_en'] : $translations['new_course']['value_ar'] }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <h3>{{ $course->defaultLocale->title }}</h3>
                                                <div class="explore-slider-bottom-icons">
                                                    <div class="d-flex">
                                                        <img class="mx-2 w-auto"
                                                            src="{{ asset('images/web/elegant-svg/explore-time.svg') }}" alt="">
                                                        <span>{{ $course->duration }} &nbsp; </span>
                                                        <span>
                                                            @if ($course->duration_type == 'days')
                                                                {{ app()->getLocale() == 'en' ? $translations['days']['value_en'] : $translations['days']['value_ar'] }}
                                                            @elseif ($course->duration_type == 'hours')
                                                                {{ app()->getLocale() == 'en' ? $translations['hours']['value_en'] : $translations['hours']['value_ar'] }}
                                                            @else
                                                                {{ app()->getLocale() == 'en' ? $translations['months']['value_en'] : $translations['months']['value_ar'] }}
                                                            @endif
                                                        </span>
                                                    </div>

                                                    {{-- <div class="d-flex">
                                                        <img class="mx-2 w-auto"
                                                            src="{{ asset('images/web/elegant-svg/explore-book.svg') }}" alt="">
                                                        <span>{{ $course->syllabuses_count }}
                                                            {{ app()->getLocale() == 'en' ? $translations['lessons']['value_en'] :
                                                            $translations['lessons']['value_ar'] }}
                                                        </span>
                                                    </div> --}}
                                                    <div class="d-flex">
                                                        <img class="mx-2 w-auto"
                                                            src="{{ asset('images/web/elegant-svg/explore-star.svg') }}" alt="">
                                                        &nbsp;
                                                        <span>{{ $course->rating }}
                                                            {{ app()->getLocale() == 'en' ? $translations['rating']['value_en'] : $translations['rating']['value_ar'] }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>



    <section id="online_learning_section" class="main-padding">
        <div class="row">
            <div class="col-lg-6 online-learning-contents-area-col">
                <div class="online-learning-contents-area">
                    <div class="section-title">
                        <h2>{{ $contents['learning-in-your-fingertips-1']->defaultLocale->name }}</h2>
                        <p>{{ $contents['learning-in-your-fingertips-1']->defaultLocale->short_description }}</p>
                    </div>
                    <div class="online-learning-description">
                        <p><b>{{ strip_tags($contents['learning-in-your-fingertips-1']->defaultLocale->description) }}</b>
                        </p>
                        <p> {{ strip_tags($contents['learning-in-your-fingertips-1']->defaultLocale->content) }}
                        </p>
                        <a href="{{ $contents['learning-in-your-fingertips-1']->link }}">
                            {{ app()->getLocale() == 'en' ? $translations['view_more']['value_en'] : $translations['view_more']['value_ar'] }}
                            <span>
                                <img class="mx-2" src="{{ asset('images/web/elegant-svg/rotate-arw.svg') }}" alt="">
                            </span></a>
                    </div>
                    <div class="online-learning-description">
                        <p><b>{{ $contents['learning-in-your-fingertips-2']->defaultLocale->short_description }}</b>
                        </p>
                        <p>{!! $contents['learning-in-your-fingertips-2']->defaultLocale->description !!}
                        </p>
                        <a href="{{ $contents['learning-in-your-fingertips-2']->link }}">
                            {{ app()->getLocale() == 'en' ? $translations['view_more']['value_en'] : $translations['view_more']['value_ar'] }}
                            <span>
                                <img class="mx-2" src="{{ asset('images/web/elegant-svg/rotate-arw.svg') }}" alt="">
                            </span></a>
                    </div>
                    <div class="elegant-training-contents-area-button">
                        <a href="{{ route('web_corporate_training') }}">
                            <button>
                                {{ app()->getLocale() == 'en' ? $translations['learn_more']['value_en'] : $translations['learn_more']['value_ar'] }}
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 online-learning-image-area-col mt-5 mt-lg-0 d-none d-md-block">
                @if ($contents['learning-in-your-fingertips-1']->thumbnail)
                    <img class="img-fluid w-100"
                        src="{{ Storage::disk('elegant')->url($contents['learning-in-your-fingertips-1']->thumbnail) }}"
                        alt="{{ $contents['learning-in-your-fingertips-1']->thumbnail_alt }}"
                        title="{{ $contents['learning-in-your-fingertips-1']->image_title }}">
                @else
                    <img class="img-fluid w-100" src="{{ asset('images/web/learning-course.png') }}" alt="">
                @endif
            </div>
        </div>
    </section>

    <section id="learning_add_section" class="main-padding">
        <div class="learning-add-area">
            <img class="img-fluid round-lg-image" src="{{ asset('images/web/round-lg-bg.png') }}" alt="">
            <img class="img-fluid round-sm-image" src="{{ asset('images/web/round-sm-bg.png') }}" alt="">
            <div class="row">
                <div class="col-lg-8 learning-add-contents-col">
                    <div class="learning-add-contents">
                        <p>{{ $contents['home-page-founder-card']->defaultLocale->short_description }}</p>
                        <h2>{{ $contents['home-page-founder-card']->defaultLocale->name }}</h2>
                        <h3>{{ strip_tags($contents['home-page-founder-card']->defaultLocale->content) }}</h3>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="learning-add-image">
                        @if ($contents['home-page-founder-card']->thumbnail)
                            <img class="img-fluid"
                                src="{{ Storage::disk('elegant')->url($contents['home-page-founder-card']->thumbnail) }}"
                                alt="{{ $contents['home-page-founder-card']->thumbnail_alt }}"
                                title="{{ $contents['home-page-founder-card']->image_title }}">
                        @else
                            <img class="img-fluid" src="{{ asset('images/web/man.png') }}" alt="">
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    @if (count($testimonials) != 0)
        <section id="testimonial_section" class="">
            <div class="explore-online-course main-padding">
                <div class="section-title">
                    <h2>{{ app()->getLocale() == 'en' ? $translations['hear_from_our_happy_learners']['value_en'] : $translations['hear_from_our_happy_learners']['value_ar'] }}
                    </h2>
                </div>
                <div class="explore-online-course-slider-area">
                    <div class="owl-carousel owl-theme testimonial">
                        @foreach ($testimonials as $item)
                            @if($item->defaultLocale)
                                <div class="item">
                                    <div class="explore-image-area">
                                        @if ($item->thumbnail)
                                            <img class="explore-main-image" src="{{ Storage::disk('elegant')->url($item->thumbnail) }}"
                                                alt="{{ $item->thumbnail_alt }}" title="{{ $item->image_title }}">
                                        @else
                                            <img class="explore-main-image" src="{{ asset('images/web/testi-1.png') }}" alt="">
                                        @endif
                                    </div>
                                    <h3>{{ $item->defaultLocale->name ?? '' }} </h3>
                                    <p>{{ $item->defaultLocale->short_description ?? '' }}</p>
                                    <!--
                                            <a href="">{{ app()->getLocale() == 'en' ? $translations['view_more']['value_en'] : $translations['view_more']['value_ar'] }}  <span>

                                            <a href="">{{ trans('home/home.view_more') }} <span>

                                                    <img src="{{ asset('images/web/elegant-svg/rotate-arw.svg') }}"
                                                        alt="" class="mx-2">
                                                </span>
                                            </a> -->
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif


    <section id="training_numbers_section">
        <img class="number-left" src="{{ asset('images/web/number-left.png') }}" alt="">
        <img class="number-right" src="{{ asset('images/web/number-right.png') }}" alt="">

        <div class="training-numbers-area main-padding">
            <div class="training-numbers-title text-center">
                <h3> {{ $contents['training-in-numbers']->defaultLocale->name }} </h3>
                <p>{{ $contents['training-in-numbers']->defaultLocale->short_description }} </p>
            </div>
            <div class="training-numbers-area">
                <div class="number-content-box">
                    <div class="count-number">{{ strip_tags($contents['elegant-number-1']->defaultLocale->short_description) }}
                    </div>
                    <p> {{ $contents['elegant-number-1']->defaultLocale->name }} </p>
                </div>
                <div class="number-content-box two-border">
                    <div class="count-number">{{ strip_tags($contents['elegant-number-1']->defaultLocale->description) }}</div>
                    <p>{!! $contents['elegant-number-1']->defaultLocale->content !!}</p>
                </div>
                <div class="number-content-box right-border">
                    <div class="count-number"> {{ strip_tags($contents['elegant-number-2']->defaultLocale->short_description) }} </div>
                    <p> {{ $contents['elegant-number-2']->defaultLocale->name }} </p>
                </div>
                <div class="number-content-box">
                    <div class="count-number">{{ strip_tags($contents['elegant-number-2']->defaultLocale->description) }}</div>
                    <p>{!! $contents['elegant-number-2']->defaultLocale->content !!}</p>
                </div>
            </div>
        </div>
    </section>

    <section id="placement_assistant_section" class="main-padding pb-15">
        <div class="placement-contents-area">
            <div class="row">
                <div class="col-md-7 placement-contents-col">
                    <div class="section-title">
                        <h2> {{ $contents['get-hired-faster-1']->defaultLocale->name }} </h2>
                        <p>{{ $contents['get-hired-faster-1']->defaultLocale->short_description }}</p>
                    </div>
                </div>
                <div class="col-md-5 placement-button-area-col">
                    <div class="elegant-training-contents-area-button">
                        <a href="{{ route('web_about') }}">
                            <button>{{ app()->getLocale() == 'en' ? $translations['learn_more']['value_en'] : $translations['learn_more']['value_ar'] }}
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="placement-image-content-area">
            <div class="placement-image-content-box">
                <img src="{{ Storage::disk('elegant')->url($contents['get-hired-faster-1']->thumbnail) }}"
                    alt="{{ $contents['get-hired-faster-1']->thumbnail_alt }}"
                    title="{{ $contents['get-hired-faster-1']->image_title }}">
                <h3> {{ strip_tags($contents['get-hired-faster-1']->defaultLocale->description) }} </h3>
                <p> {{ strip_tags($contents['get-hired-faster-1']->defaultLocale->content) }} </p>
            </div>
            <div class="placement-image-content-box">
                <img src="{{ Storage::disk('elegant')->url($contents['get-hired-faster-2']->thumbnail) }}"
                    alt="{{ $contents['get-hired-faster-2']->thumbnail_alt }}"
                    title="{{ $contents['get-hired-faster-2']->image_title }}">
                <h3>{{ $contents['get-hired-faster-2']->defaultLocale->name }} </h3>
                <p>{{ $contents['get-hired-faster-2']->defaultLocale->short_description }} </p>
            </div>
            <div class="placement-image-content-box">
                @if ($contents['get-hired-faster-2']->items)
                    @foreach ($contents['get-hired-faster-2']->items as $item)
                        <img src="{{ Storage::disk('elegant')->url($item->image_path) }}" alt="">
                    @endforeach

                @endif
                <h3> {{ strip_tags($contents['get-hired-faster-2']->defaultLocale->description) }}</h3>
                <p>{{ strip_tags($contents['get-hired-faster-2']->defaultLocale->content) }} </p>
            </div>
        </div>
    </section>

    
    <section id="our_clients_section">
        <div class="our-clients-working-area main-padding">
            <div class="our-clients-title text-center mb-6">
                <h3> {{ $contents['our-clients']->defaultLocale->title }}</h3>
            </div>
            <div class="owl-carousel owl-theme working our-client-items">
                @foreach ($contents['our-clients']->items as $item)
                    <div class="item">
                        <img class="img-fluid" src="{{ Storage::disk('elegant')->url($item->image_path) }}" alt=""
                            title="{{ $item->title }}">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-web-layout>