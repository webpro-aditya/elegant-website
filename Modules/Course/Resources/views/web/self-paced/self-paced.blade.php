@section('title', 'Self Paced')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/self-paced/self-paced.css') }}">
@endpush
@section('canonical', url()->current())

@push('script')
    <script src="{{ mix('js/web/self-paced/self-paced.js') }}"></script>
@endpush
<x-web-layout>
<section id="explore_online_course_section" class="m-top">
        <div class="explore-online-course main-padding">
            <div class="section-title">
                <h2>Most Popular Courses</h2>
            </div>
            <div class="explore-online-course-slider-area">
                <div class="row explore">
                    <div class="col-4 mb-7">
                        <div class="item">
                            <a
                                href="#">
                                <div class="explore-image-area">
                                    <img class="explore-main-image w-100"
                                        src="{{ asset('images/web/explore-1.png') }}"
                                        alt="" title="">

                                    <div class="image-overlay-text">
                                        <p>New Course</p>
                                    </div>
                                </div>
                                <h3>C++ Programming</h3>
                                <div class="explore-slider-bottom-icons">
                                    <div class="d-flex">
                                        <img class="mx-2 w-auto"
                                            src="{{ asset('images/web/elegant-svg/explore-time.svg') }}"
                                            alt="">
                                        <span>30</span>
                                        <span>Days</span>
                                    </div>

                                    <div class="d-flex">
                                        <img class="mx-2 w-auto"
                                            src="{{ asset('images/web/elegant-svg/explore-book.svg') }}"
                                            alt="">
                                        <span>3 Lessons</span>
                                    </div>
                                    <div class="d-flex">
                                        <img class="mx-2 w-auto"
                                            src="{{ asset('images/web/elegant-svg/explore-star.svg') }}"
                                            alt="">
                                        &nbsp;
                                        <span>4.3 Rating</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-4 mb-7">
                        <div class="item">
                            <a
                                href="#">
                                <div class="explore-image-area">
                                    <img class="explore-main-image w-100"
                                        src="{{ asset('images/web/explore-1.png') }}"
                                        alt="" title="">

                                    <div class="image-overlay-text">
                                        <p>New Course</p>
                                    </div>
                                </div>
                                <h3>C++ Programming</h3>
                                <div class="explore-slider-bottom-icons">
                                    <div class="d-flex">
                                        <img class="mx-2 w-auto"
                                            src="{{ asset('images/web/elegant-svg/explore-time.svg') }}"
                                            alt="">
                                        <span>30</span>
                                        <span>Days</span>
                                    </div>

                                    <div class="d-flex">
                                        <img class="mx-2 w-auto"
                                            src="{{ asset('images/web/elegant-svg/explore-book.svg') }}"
                                            alt="">
                                        <span>3 Lessons</span>
                                    </div>
                                    <div class="d-flex">
                                        <img class="mx-2 w-auto"
                                            src="{{ asset('images/web/elegant-svg/explore-star.svg') }}"
                                            alt="">
                                        &nbsp;
                                        <span>4.3 Rating</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-4 mb-7">
                        <div class="item">
                            <a
                                href="#">
                                <div class="explore-image-area">
                                    <img class="explore-main-image w-100"
                                        src="{{ asset('images/web/explore-1.png') }}"
                                        alt="" title="">

                                    <div class="image-overlay-text">
                                        <p>New Course</p>
                                    </div>
                                </div>
                                <h3>C++ Programming</h3>
                                <div class="explore-slider-bottom-icons">
                                    <div class="d-flex">
                                        <img class="mx-2 w-auto"
                                            src="{{ asset('images/web/elegant-svg/explore-time.svg') }}"
                                            alt="">
                                        <span>30</span>
                                        <span>Days</span>
                                    </div>

                                    <div class="d-flex">
                                        <img class="mx-2 w-auto"
                                            src="{{ asset('images/web/elegant-svg/explore-book.svg') }}"
                                            alt="">
                                        <span>3 Lessons</span>
                                    </div>
                                    <div class="d-flex">
                                        <img class="mx-2 w-auto"
                                            src="{{ asset('images/web/elegant-svg/explore-star.svg') }}"
                                            alt="">
                                        &nbsp;
                                        <span>4.3 Rating</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-4 mb-7">
                        <div class="item">
                            <a
                                href="#">
                                <div class="explore-image-area">
                                    <img class="explore-main-image w-100"
                                        src="{{ asset('images/web/explore-1.png') }}"
                                        alt="" title="">

                                    <div class="image-overlay-text">
                                        <p>New Course</p>
                                    </div>
                                </div>
                                <h3>C++ Programming</h3>
                                <div class="explore-slider-bottom-icons">
                                    <div class="d-flex">
                                        <img class="mx-2 w-auto"
                                            src="{{ asset('images/web/elegant-svg/explore-time.svg') }}"
                                            alt="">
                                        <span>30</span>
                                        <span>Days</span>
                                    </div>

                                    <div class="d-flex">
                                        <img class="mx-2 w-auto"
                                            src="{{ asset('images/web/elegant-svg/explore-book.svg') }}"
                                            alt="">
                                        <span>3 Lessons</span>
                                    </div>
                                    <div class="d-flex">
                                        <img class="mx-2 w-auto"
                                            src="{{ asset('images/web/elegant-svg/explore-star.svg') }}"
                                            alt="">
                                        &nbsp;
                                        <span>4.3 Rating</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-web-layout>