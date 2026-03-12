@section('meta_title',  'Professional Training Courses in Dubai – Elegant Training Center')
@section('meta_description', 'Explore KHDA-approved professional, IT, finance, and design courses in Dubai. Flexible schedules, expert trainers, and online options available.')
@section('title', 'Course List')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/course/courseList.css') }}">
@endpush
@section('canonical', url()->current())

@push('script')
    <script src="{{ mix('js/web/course/courseList.js') }}"></script>
@endpush

<x-web-layout>
    <div class="main-padding course-list-container">
        <div class="row">
            <div class="col-lg-3 col-12 pt-lg-0 pt-5">

                <button class="btn d-lg-none categories-btn" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    Course Categories
                </button>

                {{-- MOBILE SIDEBAR OFFCANVAS --}}
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                    aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-body">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="sidebar-section mt-10">
                            <div class="position-relative">
                                <h4>Search</h4>
                                <div class="search-container mb-3 pb-10">
                                        <input type="text" placeholder="Search.." name="search" class="search-input-mobile">
                                        <button type="submit"><i class="fa fa-search"></i></button>
                                </div>
                                <h3>Categories</h3>

                                <div class="sidebar-category">
                                    @foreach ($categories as $category)
                                        <label class="checkbox-container">{{ $category->title }}
                                            <input type="checkbox" value="{{ $category->id }}" 
                                                   @if (isset($categoryId) && ($category->id == $categoryId)) checked @endif>
                                            <span class="checkmark"></span>
                                        </label>
                                    @endforeach
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DESKTOP SIDEBAR --}}
                <div class="sidebar-section mt-10 d-lg-block d-none">
                    <div class="position-relative">
                        <h4>Search</h4>
                        <div class="search-container mb-3 pb-10">
                                <input type="text" placeholder="Search.." name="search" class="search-input-desktop">
                                <button type="submit"><i class="fa fa-search"></i></button>
                        </div>
                        <h3>Categories</h3>
                        <div class="sidebar-category">
                            @foreach ($categories as $category)
                                <label class="checkbox-container">{{ $category->title }}
                                    <input type="checkbox" value="{{ $category->id }}"  @if (isset($categoryId) && ($category->id == $categoryId)) checked @endif>
                                    <span class="checkmark"></span>
                                </label>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-12">
                <div class="row m-0 mt-10 position-relative pl-right">
                    <div class="notification-container">
                        <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.3225 1.66674C14.6983 0.957887 15.7138 0.957887 16.0896 1.66674L17.0893 3.55255C17.3753 4.09208 18.0738 4.25153 18.5656 3.88951L20.2845 2.6242C20.9306 2.14858 21.8456 2.58921 21.8766 3.3909L21.959 5.5237C21.9826 6.1339 22.5428 6.58065 23.143 6.46786L25.2406 6.07365C26.0291 5.92547 26.6623 6.71946 26.3424 7.45521L25.4913 9.41256C25.2478 9.97256 25.5587 10.6181 26.1483 10.7769L28.2093 11.3319C28.984 11.5405 29.21 12.5306 28.6025 13.0547L26.9864 14.4489C26.5241 14.8478 26.5241 15.5643 26.9864 15.9632L28.6025 17.3575C29.21 17.8815 28.984 18.8716 28.2093 19.0802L26.1483 19.6352C25.5587 19.794 25.2478 20.4395 25.4913 20.9996L26.3424 22.9569C26.6623 23.6926 26.0291 24.4866 25.2406 24.3385L23.143 23.9442C22.5428 23.8315 21.9826 24.2782 21.959 24.8884L21.8766 27.0212C21.8456 27.8229 20.9306 28.2635 20.2845 27.7879L18.5656 26.5226C18.0738 26.1606 17.3753 26.32 17.0893 26.8596L16.0896 28.7454C15.7138 29.4542 14.6983 29.4542 14.3225 28.7454L13.3229 26.8596C13.0368 26.32 12.3383 26.1606 11.8465 26.5226L10.1276 27.7879C9.4815 28.2635 8.56652 27.8229 8.53553 27.0212L8.45308 24.8884C8.42949 24.2782 7.86928 23.8315 7.26913 23.9442L5.17147 24.3385C4.38298 24.4866 3.7498 23.6926 4.06971 22.9569L4.92082 20.9996C5.16432 20.4395 4.85343 19.794 4.26377 19.6352L2.2028 19.0802C1.42811 18.8716 1.20213 17.8815 1.80959 17.3575L3.42567 15.9632C3.88804 15.5643 3.88804 14.8478 3.42567 14.4489L1.80959 13.0547C1.20213 12.5306 1.42811 11.5405 2.2028 11.3319L4.26378 10.7769C4.85343 10.6181 5.16432 9.97256 4.92082 9.41256L4.06971 7.4552C3.7498 6.71946 4.38298 5.92547 5.17147 6.07365L7.26913 6.46786C7.86928 6.58065 8.42949 6.1339 8.45308 5.5237L8.53553 3.3909C8.56652 2.58921 9.4815 2.14858 10.1276 2.6242L11.8465 3.88952C12.3383 4.25153 13.0368 4.09208 13.3229 3.55255L14.3225 1.66674Z"
                                fill="#EB2125" />
                            <path d="M12.0938 15.6878L14 17.5941L19.5999 11.9941" stroke="white" stroke-width="2"
                                stroke-linecap="round" />
                        </svg>
                        Our courses are also available online, offering flexible learning options to suit your needs.
                    </div>
                    <div class="list-grid-container p-0">
                        <div class="d-flex gap-4">
                            <button class="grid-cn">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.5 4.5V1.5C0.5 1.23478 0.605357 0.98043 0.792893 0.792893C0.98043 0.605357 1.23478 0.5 1.5 0.5H4.5C4.76522 0.5 5.01957 0.605357 5.20711 0.792893C5.39464 0.98043 5.5 1.23478 5.5 1.5V4.5C5.5 4.76522 5.39464 5.01957 5.20711 5.20711C5.01957 5.39464 4.76522 5.5 4.5 5.5H1.5C1.23478 5.5 0.98043 5.39464 0.792893 5.20711C0.605357 5.01957 0.5 4.76522 0.5 4.5ZM8.5 4.5V1.5C8.5 1.23478 8.60536 0.98043 8.79289 0.792893C8.98043 0.605357 9.23478 0.5 9.5 0.5H12.5C12.7652 0.5 13.0196 0.605357 13.2071 0.792893C13.3946 0.98043 13.5 1.23478 13.5 1.5V4.5C13.5 4.76522 13.3946 5.01957 13.2071 5.20711C13.0196 5.39464 12.7652 5.5 12.5 5.5H9.5C9.23478 5.5 8.98043 5.39464 8.79289 5.20711C8.60536 5.01957 8.5 4.76522 8.5 4.5ZM8.5 12.5V9.5C8.5 9.23478 8.60536 8.98043 8.79289 8.79289C8.98043 8.60536 9.23478 8.5 9.5 8.5H12.5C12.7652 8.5 13.0196 8.60536 13.2071 8.79289C13.3946 8.98043 13.5 9.23478 13.5 9.5V12.5C13.5 12.7652 13.3946 13.0196 13.2071 13.2071C13.0196 13.3946 12.7652 13.5 12.5 13.5H9.5C9.23478 13.5 8.98043 13.3946 8.79289 13.2071C8.60536 13.0196 8.5 12.7652 8.5 12.5ZM0.5 12.5V9.5C0.5 9.23478 0.605357 8.98043 0.792893 8.79289C0.98043 8.60536 1.23478 8.5 1.5 8.5H4.5C4.76522 8.5 5.01957 8.60536 5.20711 8.79289C5.39464 8.98043 5.5 9.23478 5.5 9.5V12.5C5.5 12.7652 5.39464 13.0196 5.20711 13.2071C5.01957 13.3946 4.76522 13.5 4.5 13.5H1.5C1.23478 13.5 0.98043 13.3946 0.792893 13.2071C0.605357 13.0196 0.5 12.7652 0.5 12.5Z"
                                        stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                </svg> Grid
                            </button>
                            <button class="list-cn">
                                <svg width="17" height="10" viewBox="0 0 17 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.00047 1H16.0005M6.00047 5H16.0005M6.00047 9H16.0005M1.99047 1H2.00047M1.98047 5H1.99047M1.99047 9H2.00047"
                                        stroke="#0F75BC" stroke-width="2" stroke-linecap="round" />
                                </svg> List
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" id="course-list-div" data-url="{{ route('web_course_card') }}">
                    <!-- Courses will be dynamically inserted here -->
                </div>
                <div class="no-course text-center pt-10" style="display: none">
                    No courses available!
                </div>

                <input type="hidden" name="page" id="page" value="1">
                <input type="hidden" name="limit" id="limit" value="12">
                <input type="hidden" name="finder" id="finder" value="true">

                <div class="loadmore-section d-flex justify-content-center mt-6">
                    <button type="button" id="loadmore" class="btn loadmore">Load More</button>
                </div>
                
            </div>
        </div>
        <div class="row py-15">
            <h1 class="mb-3">{{$contents['learning-in-your-fingertips-1']->defaultLocale->name}} </h1>
            <div class="content">
                {{ strip_tags($contents['learning-in-your-fingertips-1']->defaultLocale->description) }}
            </div>
        </div>
    </div>
</x-web-layout>
