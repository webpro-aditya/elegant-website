@section('title', 'Course Details')

@if ($courseData->seo)
@section('meta_title', $courseData->seo->meta_title)
@section('meta_description', $courseData->seo->meta_description)
@section('meta_contents')
        {!! $courseData->seo->meta_contents !!}
@endsection
@endif
@section('canonical', $courseData->seo->canonical_tag_url ?? url()->current())

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/course/courseDetail.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/web/course/courseDetail.js') }}"></script>
    <script>
document.addEventListener('DOMContentLoaded', function () {

    document.addEventListener('submit', function (event) {
        const form = event.target;

        if (!(form instanceof HTMLFormElement)) return;

        if (!form.checkValidity()) {
            return;
        }

        const submitButtons = form.querySelectorAll(
            'button[type="submit"], input[type="submit"]'
        );

        submitButtons.forEach(function (btn) {
            btn.disabled = true;

            if (btn.tagName === 'INPUT') {
                btn.value = 'Submitting...';
            } else {
                btn.innerText = 'Submitting...';
            }

            btn.classList.add('opacity-60', 'cursor-not-allowed');
        });

    }, true);
});
</script>
@endpush

<x-web-layout>
    <section id="course_details_section" class="">
        <div class="course-details-contents main-padding m-top">
            <div class="row">
                <div class="col-lg-8 course-details-title-description-area-col">
                    <div class="course-details-title-description-area">
                        <h1>{{ $courseData->defaultLocale->title }}</h1>
                        @php
                            $fullStars = floor($courseData->rating);
                            $halfStar = $courseData->rating - $fullStars >= 0.5 ? 1 : 0;
                            $emptyStars = 5 - $fullStars - $halfStar;
                        @endphp
                        <div class="course-review-area">
                            <div class="course-review-stars">
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <img src="{{ asset('images/web/elegant-svg/review-stra.svg') }}" class="me-1"
                                        alt="">
                                @endfor

                                @if ($halfStar)
                                    <img src="{{ asset('images/web/elegant-svg/review-half-star.svg') }}" class="me-1"
                                        alt="">
                                @endif

                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <img src="{{ asset('images/web/elegant-svg/review-empty-star.svg') }}"
                                        class="me-1" alt="">
                                @endfor
                            </div>
                            {{-- <p>{{ $courseData->rating }}
                            </p> --}}
                        </div>
                        <p>{!! $courseData->defaultLocale->short_description !!}
                        </p>
                        <div class="course-details-buttons-area">
                            <div class="book-demo-btn mb-5 mb-lg-0">

                                <a data-bs-toggle="modal" data-bs-target="#couseDemoClassModal">

                                    <button><span>
                                            <img src="{{ asset('images/web/elegant-svg/book-demo-play-btn.svg') }}"
                                                class="mx-2" alt="">
                                        </span>{{ app()->getLocale() == 'en' ? $translations['book_demo_now']['value_en'] : $translations['book_demo_now']['value_ar'] }}
                                    </button>
                                </a>
                            </div>
                            @if ($courseData->curriculum_url != null)
                                <div class="elegant-training-contents-area-button mt-0 btns mb-5 mb-lg-0">
                                    <button type="button" data-bs-toggle="modal"
                                        data-bs-target="#curriculmModal">{{ trans('home/home.download_cirriculam') }}</button>
                                </div>
                            @endif

                            <div class="elegant-training-contents-area-button mt-0 btns mb-5 mb-lg-0">
                                <button type="button" data-bs-toggle="modal"
                                    data-bs-target="#couseEnquiryModal">{{ app()->getLocale() == 'en' ? $translations['enquiry']['value_en'] : $translations['enquiry']['value_ar'] }}
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 course-details-image-area-col">
                    <div class="course-details-image-area">
                        @if ($courseData->demo_video_url)
                            <iframe src="{{ $courseData->demo_video_url }}" class="custom-iframe" frameborder="0"
                                allowfullscreen></iframe>
                        @else
                            <img src="{{ Storage::disk('elegant')->url($courseData->thumbnail_url) }}"
                                alt="{{ $courseData->thumbnail_alt }}" title="{{ $courseData->image_title }}"
                                class="img-fluid w-100">
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="upcoming_batch_section" class="main-padding py-10 py-md-15">
        <div class="upcoming-batch-contents-area">
            <div class="row">
                <div class="col-lg-8 upcoming-batch-details-area-col">
                    <div class="upcoming-batch-details-area">
                        <div class="upcoming-batch-link-area">
                            <ul class="nav nav-underline p-0">
                                @if (count($courseData->batches) != 0)
                                    <li class="nav-item">
                                        <a class="nav-link" href="#upcoming_batch_section">
                                            {{ app()->getLocale() == 'en' ? $translations['upcoming_batches']['value_en'] : $translations['upcoming_batches']['value_ar'] }}
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" href="#course_certificate_details_section">
                                        {{ app()->getLocale() == 'en' ? $translations['course_detail']['value_en'] : $translations['course_detail']['value_ar'] }}
                                    </a>
                                </li>
                                @if (count($syllubuses) != 0)
                                    <li class="nav-item">
                                        <a class="nav-link" href="#course_syllabus_section">
                                            {{ app()->getLocale() == 'en' ? $translations['course_curriculum']['value_en'] : $translations['course_curriculum']['value_ar'] }}
                                        </a>
                                    </li>
                                @endif
                                @if (count($features) != 0)
                                    <li class="nav-item">
                                        <a class="nav-link" href="#course_training_details_section">
                                            {{ app()->getLocale() == 'en' ? $translations['features']['value_en'] : $translations['features']['value_ar'] }}
                                        </a>
                                    </li>
                                @endif

                                @if (count($testimonials) != 0)
                                    <li class="nav-item">
                                        <a class="nav-link" href="#testimonial_section">
                                            {{ app()->getLocale() == 'en' ? $translations['reviews']['value_en'] : $translations['reviews']['value_ar'] }}
                                        </a>
                                    </li>
                                @endif
                                @if (count($faqs) != 0)
                                    <li class="nav-item">
                                        <a class="nav-link" href="#developer_course_section">
                                            {{ app()->getLocale() == 'en' ? $translations['faqs']['value_en'] : $translations['faqs']['value_ar'] }}
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                        @if (count($courseData->batches) != 0)
                            <div class="upcomin-batch-time-title">
                                <h2> {{ app()->getLocale() == 'en' ? $translations['upcoming_batch_details']['value_en'] : $translations['upcoming_batch_details']['value_ar'] }}
                                </h2>
                            </div>
                            <div class="upcoming-batch-time-table pe-lg-20">
                                <table class="table">
                                    <thead>
                                        <tr class="">
                                            <th class="me-1" scope="col">
                                                {{ app()->getLocale() == 'en' ? $translations['duration']['value_en'] : $translations['duration']['value_ar'] }}
                                            </th>
                                            <th scope="col">
                                                {{ app()->getLocale() == 'en' ? $translations['course_time']['value_en'] : $translations['course_time']['value_ar'] }}
                                            </th>
                                            <th scope="col">
                                                {{ app()->getLocale() == 'en' ? $translations['days']['value_en'] : $translations['days']['value_ar'] }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($courseData->batches as $batch)
                                            <tr>
                                                <td class="batch-date">{{ $batch->duration }}
                                                    {{ app()->getLocale() == 'en' ? $translations['hours']['value_en'] : $translations['hours']['value_ar'] }}
                                                </td>
                                                <td class="batch-time">{{ $batch->start_time }} -
                                                    {{ $batch->end_time }}
                                                </td>
                                                <td class="batch-time">
                                                    {{ $batch->name != '' && $batch->name != 'null' ? $batch->name : '' }}
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="upcomin-batch-time-title">
                                <h2>No Upcoming Batches Available!</h2>
                            </div>
                        @endif
                    </div>
                </div>
                @if ($courseData->pricing_format == 'paid')
                    <div class="col-lg-4 upcoming-batch-course-fee-col">
                        <div class="upcoming-batch-course-fee text-center w-100">
                            <h3> {{ app()->getLocale() == 'en' ? $translations['course_fees']['value_en'] : $translations['course_fees']['value_ar'] }}
                            </h3>
                            @if ($courseData->discount == 'yes')
                                <h2>{{ $courseData->discount_fee }}</h2>
                                <h4 class="original_amount">{{ $courseData->fee }}</h4>
                            @else
                                <h2>{{ $courseData->fee }}</h2>
                            @endif

                            <div class="elegant-training-contents-area-button mt-0 text-center">
                                <a data-bs-toggle="modal" data-bs-target="#couseDemoClassModal">
                                    <button>{{ app()->getLocale() == 'en' ? $translations['take_demo_class']['value_en'] : $translations['take_demo_class']['value_ar'] }}
                                    </button>
                                </a>
                            </div>
                            <p>{{ app()->getLocale() == 'en' ? $translations['join_demo_class_now']['value_en'] : $translations['join_demo_class_now']['value_ar'] }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section id="course_certificate_details_section">
        <div class="course-certificate-details-area main-padding mt-12 mb-8">
            <div class="course-title text-center">
                <h2> {{ app()->getLocale() == 'en' ? $translations['join']['value_en'] : $translations['join']['value_ar'] }}
                    {{ $courseData->defaultLocale->title }}
                    <!-- ({{ app()->getLocale() == 'en' ? $translations['real']['value_en'] : $translations['real']['value_ar'] }}
                    <br>
                    {{ app()->getLocale() == 'en' ? $translations['projects_expert']['value_en'] : $translations['projects_expert']['value_ar'] }}
                    ) -->
                </h2>
            </div>
            <div class="row">
                <div class="col-lg-8 course-details-certificate-contents-col">
                    <div class="course-details-certificate-contents">
                        <p>{!! $courseData->defaultLocale->description !!}</p>
                    </div>
                </div>
                <div class="col-lg-4 course-details-certificate-image-col">
                    <div class="course-details-certificate-image">
                        <div class="owl-carousel owl-theme certificate-slider">
                            @foreach ($courseData->items as $item)
                                <div class="item">
                                    <img src="{{ Storage::disk('elegant')->url($item->image_path) }}" alt=""
                                        title="{{ $item->title }}" class="img-fluid ">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (count($syllubuses) != 0)
        <section id="course_syllabus_section" class="main-padding m-top">
            <div class="course-title text-center">
                <h2>{{ $courseData->defaultLocale->title }}
                    {{ app()->getLocale() == 'en' ? $translations['course_syllabus']['value_en'] : $translations['course_syllabus']['value_ar'] }}
                </h2>
                <p>{{ app()->getLocale() == 'en' ? $translations['syllubus_short']['value_en'] : $translations['syllubus_short']['value_ar'] }}
                    {{ $courseData->defaultLocale->title }}
                </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="course-syllabus-list-area">
                        @foreach ($syllubuses as $title => $syllabusGroup)
                            <div class="course-syllabus-part">
                                <div class="Course-syllabus-part-title text-center">
                                    <h3>{{ $title }}</h3>
                                </div>
                                <div class="accordion" id="accordion{{ Str::slug($title) }}">
                                    @foreach ($syllabusGroup as $index => $syllabus)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button
                                                    class="accordion-button {{ $loop->parent->first && $loop->first ? '' : 'collapsed' }}"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ Str::slug($title) }}{{ $index }}"
                                                    aria-expanded="{{ $loop->parent->first && $loop->first ? 'true' : 'false' }}"
                                                    aria-controls="collapse{{ Str::slug($title) }}{{ $index }}">
                                                    <h3>{{ $syllabus->heading }}</h3>
                                                </button>
                                            </h2>
                                            <div id="collapse{{ Str::slug($title) }}{{ $index }}"
                                                class="accordion-collapse collapse {{ $loop->parent->first && $loop->first ? 'show' : '' }}"
                                                data-bs-parent="#accordion{{ Str::slug($title) }}">
                                                <div class="accordion-body">
                                                    <div class="course-syllabus-list-details-area">
                                                        {!! $syllabus->description !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="elegant-training-contents-area-button text-center">
                    @if ($courseData->brochure_url)
                        <a data-bs-toggle="modal" data-bs-target="#courseBrochureModal">
                            <button>
                                {{ app()->getLocale() == 'en' ? $translations['download_full_brochure']['value_en'] : $translations['download_full_brochure']['value_ar'] }}
                            </button>
                        </a>
                    @endif
                </div>
            </div>
        </section>

    @endif

    @if (count($features) != 0)
        <section id="course_training_details_section" class="">
            <div class="course-training-details-contents-area main-padding m-top">
                <div class="course-title text-center">
                    <h2> {{ app()->getLocale() == 'en' ? $translations['choose_elegant_training_for']['value_en'] : $translations['choose_elegant_training_for']['value_ar'] }}
                        {{ $courseData->defaultLocale->title }}
                    </h2>
                </div>
                <div class="row">
                    @foreach ($features as $item)
                        <div class="col-lg-4 course-training-details-contents-box-col mb-5">
                            <div class="course-training-details-contents-box text-center">
                                <img src="{{ Storage::disk('elegant')->url($item->thumbnail) }}"
                                    alt="{{ $item->thumbnail_alt }}" title="{{ $item->image_title }}"
                                    class="img-fluid ">
                                <h4>{{ $item->defaultLocale->name }}</h4>
                                <p>{!! $item->defaultLocale->description !!}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    @endif

    <section id="learning_add_section" class="m-top main-padding">
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
                        <img class="img-fluid"
                            src="{{ Storage::disk('elegant')->url($contents['home-page-founder-card']->thumbnail) }}"
                            title="{{ $contents['home-page-founder-card']->image_title }}"
                            alt="{{ $contents['home-page-founder-card']->thumbnail_alt }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (count($testimonials) != 0)
        <section id="testimonial_section"
            class="{{ isset($companies->items) && count($companies->items) != 0 ? 'mb-6' : '' }}"
            @if (!isset($companies->items) || count($companies->items) == 0) style="margin-bottom:40px" @endif>
            <div class="explore-online-course main-padding">
                <div class="section-title">
                    <h2>{{ app()->getLocale() == 'en' ? $translations['hear_from_our_happy_learners']['value_en'] : $translations['hear_from_our_happy_learners']['value_ar'] }}
                    </h2>
                </div>
                <div class="explore-online-course-slider-area">
                    <div class="owl-carousel owl-theme testimonial">
                        @foreach ($testimonials as $item)
                            @if ($item->defaultLocale)
                                <div class="item">
                                    <div class="explore-image-area">
                                        @if ($item->thumbnail)
                                            <img class="explore-main-image"
                                                src="{{ Storage::disk('elegant')->url($item->thumbnail) }}"
                                                alt="{{ $item->thumbnail_alt }}" title="{{ $item->image_title }}">
                                        @else
                                            <img class="explore-main-image"
                                                src="{{ asset('images/web/testi-1.png') }}" alt="">
                                        @endif
                                    </div>
                                    <h3>{{ $item->defaultLocale->name }} </h3>
                                    <p>{{ $item->defaultLocale->short_description }}</p>
                                    <!-- <a href="">{{ app()->getLocale() == 'en' ? $translations['view_more']['value_en'] : $translations['view_more']['value_ar'] }}   <span>
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

    @if (isset($companies->items) && count($companies->items) != 0)
        <section id="top_companies_section" class="m-top main-padding">
            <div class="course-title text-center">
                <h2>{{ app()->getLocale() == 'en' ? $translations['our_esteemed_clients']['value_en'] : $translations['our_esteemed_clients']['value_ar'] }}
                </h2>
            </div>
            <div class="top-conpanies-images">
                @foreach ($companies->items as $item)
                    <img src="{{ Storage::disk('elegant')->url($item->image_path) }}" alt="">
                @endforeach
            </div>
        </section>
    @endif

    <section id="developer_course_section" class="">
        <div class="developer-course-area m-top main-padding">
            <div class="course-title text-center">
                <h2>{{ $courseData->defaultLocale->title }} -
                    {{ app()->getLocale() == 'en' ? $translations['faqs']['value_en'] : $translations['faqs']['value_ar'] }}
                </h2>
            </div>

            <div class="row">
                @if (count($faqs) != 0)
                    <div class="col-lg-8 developer-course-list-area-col">
                        <div class="developer-course-list-area">
                            <div class="accordion" id="accordionExample">
                                @foreach ($faqs as $index => $faq)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $index }}"
                                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                aria-controls="collapse{{ $index }}">
                                                <h3>{{ $faq->defaultLocale->question }}</h3>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $index }}"
                                            class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="course-syllabus-list-details-area">
                                                    <p>{!! $faq->defaultLocale->answer !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if ($joinNow != null && isset($joinNow->defaultLocale))
                    <div class="col-lg-4 developer-course-small-list-area-col mt-3 mt-lg-0">
                        <div class="developer-course-small-list-area">
                            <p><b>{{ $joinNow->defaultLocale->name }}</b></p>
                            <p> {{ $joinNow->defaultLocale->short_description }} </p>
                            <div class="developer-small-course-list-area-box">
                                <div class="area-box-list">
                                    {!! $joinNow->defaultLocale->description !!}
                                </div>
                                <button class="enquire-now" type="button" data-bs-toggle="modal"
                                    data-bs-target="#couseEnquiryModal">{{ trans('home/home.enquire_now') }}</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>



    <div class="modal fade" id="curriculmModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('home/home.course_curriculum') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('web_save_course_curriculm') }}" method="POST" id="curriculmEnquiryForm"
                        class="enquire-form fv-plugins-bootstrap5 fv-plugins-framework">
                        @csrf
                        @honeypot
                        <input type="hidden" name="courseId" id="courseId" value="{{ $courseData->id }}">
                        <input type="hidden" name="type" value="course_curriculum">
                        <div class="col-12 mb-4 fv-row">
                            <label for="name" class="w-100 mb-2"> {{ trans('home/home.name') }} </label>
                            <input type="text" name="name"
                                placeholder=" {{ trans('home/home.enter_your_name') }}" id="name"
                                class="form-control w-100" required>
                            @error('name')
                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mb-4 fv-row">
                            <label for="email" class="w-100 mb-2"> {{ trans('home/home.email') }} </label>
                            <input type="email" name="email"
                                placeholder=" {{ trans('home/home.enter_your_email') }}" class="form-control w-100"
                                id="email" required>
                            @error('email')
                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row align-items-end mb-5 cn-code fv-row">
                            <label for="number" class="w-100 mb-2">{{ trans('home/home.mobile_number') }}</label>
                            <div class="d-flex gap-2 ">
                                <select name="country_code" id="curriculumCountryCode" autocomplete="off"
                                    class="form-control" style="width: 60%;">
                                    @foreach ($countries as $country)
                                        <option data-name="{{ $country->short_name }}"
                                            data-image="{{ asset('images/flags/' . $country->image) }}"
                                            value="{{ $country->country_code }}"
                                            @if (old('country_code')) @if (old('country_code') == $country->country_code)
                                        selected @endif
                                        @elseif($country->country_code == '971') selected @endif>
                                            +{{ $country->country_code }} {{ $country->short_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class=" w-100">
                                    <input type="number" name="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        placeholder="{{ trans('home/home.enter_your_mobile_number') }}"
                                        id="number" class="form-control w-100" required>
                                    @error('number')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mb-4 fv-row">
                            <label for="message" class="w-100 mb-2">{{ trans('home/home.message') }}</label>
                            <textarea name="message" id="message" rows="4" placeholder="{{ trans('home/home.drop_your_thoughts') }}"
                                class="form-control w-100"></textarea>
                                @error('message')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                        </div>
                                    @enderror
                        </div>
                        <div class="col-12 text-center">
                            <input type="submit" value="{{ trans('home/home.submit') }}"
                                class="submit-btn fv-button-submit" id="btnSubmit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Enquiry -->
    <div class="modal fade" id="couseEnquiryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ app()->getLocale() == 'en' ? $translations['enquire_now']['value_en'] : $translations['enquire_now']['value_ar'] }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('web_save_course_enquiry') }}" method="POST" id="courseEnquiryForm"
                        class="enquire-form fv-plugins-bootstrap5 fv-plugins-framework">
                        @csrf
                        @honeypot
                        <input type="hidden" name="courseId" id="courseId" value="{{ $courseData->id }}">
                        <input type="hidden" name="type" value="course_enquiry">
                        <div class="col-12 mb-4 fv-row">
                            <label for="name" class="w-100 mb-2">
                                {{ app()->getLocale() == 'en' ? $translations['name']['value_en'] : $translations['name']['value_ar'] }}
                            </label>
                            <input type="text" name="name"
                                placeholder="{{ app()->getLocale() == 'en' ? $translations['enter_your_name']['value_en'] : $translations['enter_your_name']['value_ar'] }}  "
                                id="name" class="form-control w-100" required>
                            @error('name')
                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mb-4 fv-row">
                            <label for="email"
                                class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['email']['value_en'] : $translations['email']['value_ar'] }}
                            </label>
                            <input type="email" name="email"
                                placeholder=" {{ app()->getLocale() == 'en' ? $translations['enter_your_email']['value_en'] : $translations['enter_your_email']['value_ar'] }} "
                                class="form-control w-100" id="email" required>
                            @error('email')
                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row align-items-end mb-5 cn-code fv-row">
                            <label for="number"
                                class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['mobile_number']['value_en'] : $translations['mobile_number']['value_ar'] }}
                            </label>
                            <div class="d-flex">

                                <select name="country_code" id="enquiryCountryCode" autocomplete="off"
                                    class="form-control" style="width: 60%;">
                                    @foreach ($countries as $country)
                                        <option data-name="{{ $country->short_name }}"
                                            data-image="{{ asset('images/flags/' . $country->image) }}"
                                            value="{{ $country->country_code }}"
                                            @if (old('country_code')) @if (old('country_code') == $country->country_code)
                                        selected @endif
                                        @elseif($country->country_code == '971') selected @endif>
                                            +{{ $country->country_code }} {{ $country->short_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="w-100">
                                    <input type="number" name="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        placeholder="{{ app()->getLocale() == 'en' ? $translations['enter_your_mobile_number']['value_en'] : $translations['enter_your_mobile_number']['value_ar'] }} "
                                        id="number" class="form-control w-100" required>
                                    @error('number')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mb-4 fv-row">
                            <label for="message"
                                class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['message']['value_en'] : $translations['message']['value_ar'] }}
                            </label>
                            <textarea name="message" id="message" rows="4"
                                placeholder="{{ app()->getLocale() == 'en' ? $translations['drop_your_thoughts']['value_en'] : $translations['drop_your_thoughts']['value_ar'] }}  "
                                class="form-control w-100"></textarea>
                                @error('message')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                        </div>
                                    @enderror
                        </div>
                        <div class="col-12 text-center">
                            <input type="submit"
                                value="{{ app()->getLocale() == 'en' ? $translations['submit']['value_en'] : $translations['submit']['value_ar'] }}  "
                                class="submit-btn fv-button-submit enquiry-submit" id="enquiry-submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Demo Class -->
    <div class="modal fade" id="couseDemoClassModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ app()->getLocale() == 'en' ? $translations['book_demo_class']['value_en'] : $translations['book_demo_class']['value_ar'] }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="demoClassForm" action="{{ route('web_save_course_enquiry') }}" method="POST"
                        class="enquire-form fv-plugins-bootstrap5 fv-plugins-framework ">
                        @csrf
                        @honeypot
                        <input type="hidden" name="courseId" id="courseId" value="{{ $courseData->id }}">
                        <input type="hidden" name="type" value="demo_class">
                        <div class="col-12 mb-4 fv-row">
                            <label for="name" class="w-100 mb-2">
                                {{ app()->getLocale() == 'en' ? $translations['name']['value_en'] : $translations['name']['value_ar'] }}
                            </label>
                            <input type="text" name="name"
                                placeholder=" {{ app()->getLocale() == 'en' ? $translations['enter_your_name']['value_en'] : $translations['enter_your_name']['value_ar'] }} "
                                id="name" class="form-control w-100" required>
                            @error('name')
                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mb-4 fv-row">
                            <label for="email" class="w-100 mb-2">
                                {{ app()->getLocale() == 'en' ? $translations['email']['value_en'] : $translations['email']['value_ar'] }}
                            </label>
                            <input type="email" name="email"
                                placeholder=" {{ app()->getLocale() == 'en' ? $translations['enter_your_email']['value_en'] : $translations['enter_your_email']['value_ar'] }}  "
                                class="form-control w-100" id="email" required>
                            @error('email')
                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row align-items-end mb-5 cn-code">
                            <label for="number" class="w-100 mb-4">
                                {{ app()->getLocale() == 'en' ? $translations['mobile_number']['value_en'] : $translations['mobile_number']['value_ar'] }}
                            </label>
                            <div class="d-flex">
                                <div class="fv-row">
                                    <select name="country_code" id="demoCountryCode" data-control="select2"
                                        data-server="true" autocomplete="off" class="form-control"
                                        style="width: 60%;">
                                        @foreach ($countries as $country)
                                            <option data-name="{{ $country->short_name }}"
                                                data-image="{{ asset('images/flags/' . $country->image) }}"
                                                value="{{ $country->country_code }}"
                                                @if (old('country_code')) @if (old('country_code') == $country->country_code)
                                            selected @endif
                                            @elseif($country->country_code == '971') selected @endif>
                                                +{{ $country->country_code }} {{ $country->short_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="fv-row w-100">
                                    <input type="number" name="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        placeholder="{{ app()->getLocale() == 'en' ? $translations['enter_your_mobile_number']['value_en'] : $translations['enter_your_mobile_number']['value_ar'] }}  "
                                        id="number" class="form-control w-100" required>
                                    @error('number')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        {{-- <div class="col-12 mb-4 location-contr">
                            <label for="location_id" class="form-label w-100 mb-2">
                                {{ app()->getLocale() == 'en' ? $translations['location']['value_en'] : $translations['location']['value_ar'] }}
                            </label>
                            <select class="form-select mb-2 rounded-1 h-40px" name="location_id" id="location_id"
                                @if ($locations->count() == 1) disabled @endif data-kt-select2="true"
                                data-placeholder="{{ app()->getLocale() == 'en' ? $translations['select_location']['value_en'] : $translations['select_location']['value_ar'] }} ">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->defaultLocale->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-12 mb-4 fv-row">
                            <label for="message"
                                class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['message']['value_en'] : $translations['message']['value_ar'] }}
                            </label>
                            <textarea name="message" id="message" rows="4"
                                placeholder=" {{ app()->getLocale() == 'en' ? $translations['drop_your_thoughts']['value_en'] : $translations['drop_your_thoughts']['value_ar'] }}  "
                                class="form-control w-100"></textarea>
                                @error('message')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                        </div>
                                    @enderror
                        </div>
                        <div class="col-12 text-center">
                            <input type="submit"
                                value="{{ app()->getLocale() == 'en' ? $translations['submit']['value_en'] : $translations['submit']['value_ar'] }}  "
                                id="demo-submit" class="submit-btn demo-submit fv-button-submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Course Brouchure Class -->
    <div class="modal fade" id="courseBrochureModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ app()->getLocale() == 'en' ? $translations['book_demo_class']['value_en'] : $translations['book_demo_class']['value_ar'] }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="demoClassForm" action="{{ route('web_save_course_enquiry') }}" method="POST"
                        class="enquire-form fv-plugins-bootstrap5 fv-plugins-framework ">
                        @csrf
                        @honeypot
                        <input type="hidden" name="courseId" id="courseId" value="{{ $courseData->id }}">
                        <input type="hidden" name="type" value="course_brochure">
                        <div class="col-12 mb-4 fv-row">
                            <label for="name" class="w-100 mb-2">
                                {{ app()->getLocale() == 'en' ? $translations['name']['value_en'] : $translations['name']['value_ar'] }}
                            </label>
                            <input type="text" name="name"
                                placeholder=" {{ app()->getLocale() == 'en' ? $translations['enter_your_name']['value_en'] : $translations['enter_your_name']['value_ar'] }} "
                                id="name" class="form-control w-100" required>
                            @error('name')
                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mb-4 fv-row">
                            <label for="email" class="w-100 mb-2">
                                {{ app()->getLocale() == 'en' ? $translations['email']['value_en'] : $translations['email']['value_ar'] }}
                            </label>
                            <input type="email" name="email"
                                placeholder=" {{ app()->getLocale() == 'en' ? $translations['enter_your_email']['value_en'] : $translations['enter_your_email']['value_ar'] }}  "
                                class="form-control w-100" id="email" required>
                            @error('email')
                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row align-items-end mb-5 cn-code">
                            <label for="number" class="w-100 mb-4">
                                {{ app()->getLocale() == 'en' ? $translations['mobile_number']['value_en'] : $translations['mobile_number']['value_ar'] }}
                            </label>
                            <div class="d-flex">
                                <div class="fv-row">
                                    <select name="country_code" id="brochureCountryCode" data-control="select2"
                                        data-server="true" autocomplete="off" class="form-control form-select"
                                        style="width: 60%;">
                                        @foreach ($countries as $country)
                                            <option data-name="{{ $country->short_name }}"
                                                data-image="{{ asset('images/flags/' . $country->image) }}"
                                                value="{{ $country->country_code }}"
                                                @if (old('country_code')) @if (old('country_code') == $country->country_code)
                                            selected @endif
                                            @elseif($country->country_code == '971') selected @endif>
                                                +{{ $country->country_code }} {{ $country->short_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="fv-row w-100">
                                    <input type="number" name="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        placeholder="{{ app()->getLocale() == 'en' ? $translations['enter_your_mobile_number']['value_en'] : $translations['enter_your_mobile_number']['value_ar'] }}  "
                                        id="number" class="form-control w-100" required>
                                    @error('number')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mb-4 location-contr">
                            <label for="location_id" class="form-label w-100 mb-2">
                                {{ app()->getLocale() == 'en' ? $translations['location']['value_en'] : $translations['location']['value_ar'] }}
                            </label>
                            <select class="form-select mb-2 rounded-1 h-40px" name="location_id" id="location_id"
                                @if ($locations->count() == 1) disabled @endif data-kt-select2="true"
                                data-placeholder="{{ app()->getLocale() == 'en' ? $translations['select_location']['value_en'] : $translations['select_location']['value_ar'] }} ">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->defaultLocale->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-4 fv-row">
                            <label for="message"
                                class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['message']['value_en'] : $translations['message']['value_ar'] }}
                            </label>
                            <textarea name="message" id="message" rows="4"
                                placeholder=" {{ app()->getLocale() == 'en' ? $translations['drop_your_thoughts']['value_en'] : $translations['drop_your_thoughts']['value_ar'] }}  "
                                class="form-control w-100"></textarea>
                                @error('message')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                        </div>
                                    @enderror
                        </div>
                        <div class="col-12 text-center">
                            <input type="submit"
                                value="{{ app()->getLocale() == 'en' ? $translations['submit']['value_en'] : $translations['submit']['value_ar'] }}  "
                                class="submit-btn demo-submit fv-button-submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-web-layout>
