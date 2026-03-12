<section id="header_section">
    <div class="top-header-area">
        <marquee onMouseOver="this.stop()" onMouseOut="this.start()" width="100%" loop="-1"
            @if (app()->getLocale() == 'ar') direction="right" @else direction="left" @endif height="40px">
            <div class="d-flex center-content">
                @if (count($features) > 0)
                    @foreach ($features as $feature)
                        <svg class="mx-3" width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="8" cy="8" r="8" fill="#F4C32B" />
                        </svg>
                        <span> {{ $feature->defaultLocale->name }} </span>
                        @if (isset($feature->course->slug))
                            <div class="register-now-btn mx-3">
                                <a
                                    href="{{ route('web_course_detail', ['locale' => app()->getLocale(), 'course' => $feature->course->slug]) }}">
                                    <button>{{ app()->getLocale() == 'en' ? $translations['register_now']['value_en'] : $translations['register_now']['value_ar'] }}
                                    </button></a>
                            </div>
                        @endif
                    @endforeach
                @endif

            </div>
        </marquee>
        @if (config('settings.store.ar') == 'checked' ||
                config('settings.store.sp') == 'checked' ||
                config('settings.store.fr') == 'checked')
            <div class="dropdown language-container">
                <button class="btn btn-secondary dropdown-toggle bg-transparent" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    @if (app()->getLocale() == 'en')
                        English
                    @else
                        Arabic
                    @endif
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('web_locale', ['locale' => 'en']) }}">English</a></li>
                    @if (config('settings.store.ar') == 'checked')
                        <li><a class="dropdown-item" href="{{ route('web_locale', ['locale' => 'ar']) }}">Arabic</a>
                        </li>
                    @endif
                    @if (config('settings.store.sp') == 'checked')
                        <li><a class="dropdown-item" href="{{ route('web_locale', ['locale' => 'sp']) }}">Spanish</a>
                        </li>
                    @endif
                    @if (config('settings.store.fr') == 'checked')
                        <li><a class="dropdown-item" href="{{ route('web_locale', ['locale' => 'fr']) }}">French</a>
                        </li>
                    @endif
                </ul>
            </div>
        @endif

    </div>
    <nav class="navbar navbar-expand-xl header-main-padding">
        <div class="container-fluid p-0 gap-3">
            <a class="navbar-brand" href="{{ route('web_home', ['locale' => app()->getLocale()]) }}"><img
                    src="{{ asset('images/web/elegant-svg/elegant-logo.svg') }}" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{-- <li class="nav-item dropdown has-megamenu">
                        <a href="#" role="button"
                            class="nav-link dropdown-toggle d-flex align-items-center gap-2 header-categories-btn"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/web/elegant-svg/dots.svg') }}" alt=""> Categories
                    </a>
                    <div class="dropdown-menu dropdown-megamenu category-dropdown-menu">
                        <div class="row row-cols-4 g-0 scroll-container">
                            <div class="col category-list-menu">
                                <ul class="list-unstyled">
                                    <li class="position-relative">
                                        <a href="#" class="dropdown-item">
                                            <img src="{{ asset('images/web/elegant-svg/course-category-icon.svg') }}"
                                                alt="">
                                            <div class="name-category">Graphic Design</div>
                                            <span>(10 Courses)</span>
                                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M2.36726 0.724534L8.73122 7.0885C9.12175 7.47902 9.12175 8.11218 8.73122 8.50271L2.36726 14.8667C1.97674 15.2572 1.34357 15.2572 0.953048 14.8667C0.562524 14.4761 0.562524 13.843 0.953048 13.4525L6.6099 7.7956L0.953049 2.13875C0.562525 1.74822 0.562525 1.11506 0.95305 0.724534C1.34357 0.33401 1.97674 0.33401 2.36726 0.724534Z"
                                                    fill="#0F75BC" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li class="position-relative">
                                        <a href="#" class="dropdown-item">
                                            <img src="{{ asset('images/web/elegant-svg/course-category-icon.svg') }}"
                                                alt="">
                                            <div class="name-category">Graphic Design</div>
                                            <span>(10 Courses)</span>
                                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M2.36726 0.724534L8.73122 7.0885C9.12175 7.47902 9.12175 8.11218 8.73122 8.50271L2.36726 14.8667C1.97674 15.2572 1.34357 15.2572 0.953048 14.8667C0.562524 14.4761 0.562524 13.843 0.953048 13.4525L6.6099 7.7956L0.953049 2.13875C0.562525 1.74822 0.562525 1.11506 0.95305 0.724534C1.34357 0.33401 1.97674 0.33401 2.36726 0.724534Z"
                                                    fill="#0F75BC" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col category-list-menu">
                                <ul class="list-unstyled">
                                    <li><a href="#" class="dropdown-item">Dropdown Item</a></li>
                                    <li><a href="#" class="dropdown-item">Dropdown Item</a></li>
                                    <li><a href="#" class="dropdown-item">Dropdown Item</a></li>
                                </ul>
                            </div>

                            <div class="col category-list-menu">
                                <ul class="list-unstyled">
                                    <li><a href="#" class="dropdown-item">Dropdown Item</a></li>
                                    <li><a href="#" class="dropdown-item">Dropdown Item</a></li>
                                    <li><a href="#" class="dropdown-item">Dropdown Item</a></li>
                                </ul>
                            </div>

                            <div class="col category-list-menu">
                                <ul class="list-unstyled">
                                    <li><a href="#" class="dropdown-item">Dropdown Item</a></li>
                                    <li><a href="#" class="dropdown-item">Dropdown Item</a></li>
                                    <li><a href="#" class="dropdown-item">Dropdown Item</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </li> --}}

                    <li class="nav-item dropdown has-megamenu">
                        <a href="#" role="button"
                            class="nav-link dropdown-toggle d-flex align-items-center gap-2 header-categories-btn"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/web/elegant-svg/dots.svg') }}" alt=""> Categories
                        </a>
                        <div class="dropdown-menu dropdown-megamenu category-dropdown-menu rounded-0">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-0 scroll-container">
                                @php
                                    $categories = $offlines->all(); // Convert to array to easily slice and loop
                                    $chunkedCategories = array_chunk($categories, 7); // Split into chunks of 10 categories
                                @endphp

                                @foreach ($chunkedCategories as $chunk)
                                    <div class="col category-list-menu">
                                        <ul class="list-unstyled p-0">
                                            @foreach ($chunk as $category)
                                                <li class="position-relative">
                                                    <a href="{{ route('web_course_list', ['category' => $category->slug]) }}"                                                        class="dropdown-item web-header-toggle-category"
                                                        data-category-id="category-{{ $category->id }}">
                                                        @if ($category->image)
                                                            <img src="{{ Storage::disk('elegant')->url($category->image) }}"
                                                                alt="" style="width: 45px; height: 45px;">
                                                        @else
                                                            <img src="{{ asset('images/web/elegant-svg/course-category-icon.svg') }}"
                                                                alt="">
                                                        @endif
                                                        <div class="name-category">
                                                            {{ $category->defaultLocale->title }}
                                                        </div>
                                                        <span>({{ $category->course->where('status', 'publish')->count() }}
                                                            Courses)</span>
                                                        <svg width="10" height="16" viewBox="0 0 10 16"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M2.36726 0.724534L8.73122 7.0885C9.12175 7.47902 9.12175 8.11218 8.73122 8.50271L2.36726 14.8667C1.97674 15.2572 1.34357 15.2572 0.953048 14.8667C0.562524 14.4761 0.562524 13.843 0.953048 13.4525L6.6099 7.7956L0.953049 2.13875C0.562525 1.74822 0.562525 1.11506 0.95305 0.724534C1.34357 0.33401 1.97674 0.33401 2.36726 0.724534Z"
                                                                fill="#0F75BC" />
                                                        </svg>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                                <div class="view-all-button-container">
                                    <a href="{{ route('web_course_list') }}">View All</a>
                                </div>
                            </div>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('web_home') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('web_home', ['locale' => app()->getLocale()]) }}">
                            {{ app()->getLocale() == 'en' ? $translations['home']['value_en'] : $translations['home']['value_ar'] }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('web_course_list') ? 'active' : '' }}"
                            aria-current="course" href="{{ route('web_course_list') }}">
                            Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="lms" href="https://etidubai.com/" target="_blank">
                            LMS
                        </a>
                    </li>
                    {{--
                    <li class="nav-item dropdown has-megamenu">
                        <a class="nav-link dropdown-toggle" href="#"
                            data-bs-toggle="dropdown">{{ app()->getLocale() == 'en' ? $translations['offline']['value_en'] : $translations['offline']['value_ar'] }}
                    </a>
                    <div class="dropdown-menu megamenu" role="menu">
                        <div class="row g-3">

                            @foreach ($offlines as $category)
                            <div class="col-12 col-xl-3">
                                <div class="col-megamenu">
                                    <h6 class="title">{{ $category->defaultLocale->title }}</h6>
                                    <ul class="list-unstyled course-list">
                                        @php
                                        $i = 0;
                                        $count = 5;
                                        @endphp
                                        @foreach ($category->course as $course)
                                        @if ($i < $count)
                                            <li>
                                            <a
                                                href="{{ route('web_course_detail', ['course' => $course->slug, 'locale' => app()->getLocale()]) }}">
                                                {{ $course->defaultLocale->title }}
                                            </a>
                                            </li>
                                            @else
                                            <li class="d-none hidden-li">
                                                <a
                                                    href="{{ route('web_course_detail', ['course' => $course->slug, 'locale' => app()->getLocale()]) }}">
                                                    {{ $course->defaultLocale->title }}
                                                </a>
                                            </li>
                                            @endif
                                            @php $i++; @endphp
                                            @endforeach
                                    </ul>

                                    @if ($category->course->count() > $count)
                                    <a class="toggle-more">More</a>
                                    @endif

                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                    </li> --}}

                    {{-- <li class="nav-item dropdown has-megamenu">
                        <a class="nav-link dropdown-toggle" href="#"
                            data-bs-toggle="dropdown">{{ app()->getLocale() == 'en' ? $translations['offline']['value_en'] : $translations['offline']['value_ar'] }}
                    </a>
                    <div class="dropdown-menu megamenu" role="menu">
                        <div class="row g-3">

                            @foreach ($offlines as $category)
                            <div class="col-12 col-xl-3">
                                <div class="col-megamenu">
                                    <h6 class="title">{{ $category->defaultLocale->title }}</h6>
                                    <ul class="list-unstyled course-list">
                                        @php
                                        $i = 0;
                                        $count = 5;
                                        @endphp
                                        @foreach ($category->course as $course)
                                        @if ($i < $count)
                                            <li>
                                            <a
                                                href="{{ route('web_course_detail', ['course' => $course->slug, 'locale' => app()->getLocale()]) }}">
                                                {{ $course->defaultLocale->title }}
                                            </a>
                                            </li>
                                            @else
                                            <li class="d-none hidden-li">
                                                <a
                                                    href="{{ route('web_course_detail', ['course' => $course->slug, 'locale' => app()->getLocale()]) }}">
                                                    {{ $course->defaultLocale->title }}
                                                </a>
                                            </li>
                                            @endif
                                            @php $i++; @endphp
                                            @endforeach
                                    </ul>

                                    @if ($category->course->count() > $count)
                                    <a class="toggle-more">More</a>
                                    @endif

                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                    </li>
                    <li class="nav-item dropdown has-megamenu">
                        <a class="nav-link dropdown-toggle" href="#"
                            data-bs-toggle="dropdown">{{ app()->getLocale() == 'en' ? $translations['live_online']['value_en'] : $translations['live_online']['value_ar'] }}
                        </a>
                        <div class="dropdown-menu megamenu" role="menu">
                            <div class="row g-3">
                                @foreach ($onlines as $category)
                                <div class="col-12 col-xl-3">
                                    <div class="col-megamenu">
                                        <h6 class="title">{{ $category->defaultLocale->title }}</h6>
                                        <ul class="list-unstyled course-list">
                                            @php
                                            $i = 0;
                                            $count = 5;
                                            @endphp
                                            @foreach ($category->course as $course)
                                            @if ($i < $count)
                                                <li>
                                                <a
                                                    href="{{ route('web_course_detail', ['course' => $course->slug, 'locale' => app()->getLocale()]) }}">
                                                    {{ $course->defaultLocale->title }}
                                                </a>
                    </li>
                    @else
                    <li class="d-none hidden-li">
                        <a
                            href="{{ route('web_course_detail', ['course' => $course->slug, 'locale' => app()->getLocale()]) }}">
                            {{ $course->defaultLocale->title }}
                        </a>
                    </li>
                    @endif
                    @php $i++; @endphp
                    @endforeach
                </ul>

                @if ($category->course->count() > $count)
                <a class="toggle-more">More</a>
                @endif

            </div>
        </div>
        @endforeach
        <!-- end col-3 -->
        </div>
        <!-- end row -->
        </div>
        <!-- dropdown-mega-menu.// -->
        </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#">
                            {{ app()->getLocale() == 'en' ? $translations['self_paced']['value_en'] : $translations['self_paced']['value_ar'] }} </a>
        </li> --}}
                    {{-- <li class="nav-item dropdown has-megamenu">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            {{ app()->getLocale() == 'en' ? $translations['free_resource']['value_en'] : $translations['free_resource']['value_ar'] }}
        </a>
        <div class="dropdown-menu megamenu" role="menu">
            <div class="row g-3">
                <div class="col-12 col-xl-6">
                    <div class="col-megamenu">
                        <h6 class="title">Interview</h6>
                        @foreach ($interviews as $interview)
                        <ul class="list-unstyled">
                            <li><a
                                    href="{{ route('web_free_resource_view', ['slug' => $interview->slug]) }}">{{ $interview->defaultLocale->name }}</a>
                            </li>
                        </ul>
                        @endforeach
                    </div>
                    <!-- col-megamenu.// -->
                </div>

                <div class="col-12 col-xl-6">
                    <div class="col-megamenu">
                        <h6 class="title">Quiz</h6>
                        @foreach ($quizs as $quiz)
                        <ul class="list-unstyled">
                            <li><a
                                    href="{{ route('web_free_resource_view', ['slug' => $quiz->slug]) }}">{{ $quiz->defaultLocale->name }}</a>
                            </li>
                        </ul>
                        @endforeach
                    </div>
                    <!-- col-megamenu.// -->
                </div>
                <!-- end col-3 -->
            </div>
            <!-- end row -->
        </div>
        <!-- dropdown-mega-menu.// -->
        </li> --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('web_training_calender') ? 'active' : '' }}"
                            href="{{ route('web_training_calender') }}">
                            {{ app()->getLocale() == 'en' ? $translations['training_calender']['value_en'] : $translations['training_calender']['value_ar'] }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('web_corporate_training') ? 'active' : '' }}"
                            href="{{ route('web_corporate_training') }}">{{ app()->getLocale() == 'en' ? $translations['corporate_training']['value_en'] : $translations['corporate_training']['value_ar'] }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('web_gallery') ? 'active' : '' }}"
                            href="{{ route('web_gallery') }}">Gallery</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs(['web_about', 'web_blog_list', 'web_hiring']) ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ app()->getLocale() == 'en' ? $translations['more']['value_en'] : $translations['more']['value_ar'] }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('web_about', ['locale' => 'en']) }}">
                                    {{ app()->getLocale() == 'en' ? $translations['about_us']['value_en'] : $translations['about_us']['value_ar'] }}
                                </a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('web_blog_list', ['locale' => 'en']) }}">{{ app()->getLocale() == 'en' ? $translations['blog']['value_en'] : $translations['blog']['value_ar'] }}
                                </a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('web_hiring', ['locale' => 'en']) }}">{{ app()->getLocale() == 'en' ? $translations['we_are_hiring']['value_en'] : $translations['we_are_hiring']['value_ar'] }}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="d-flex header-btns">
                    {{-- <button class="btn-mentor me-4" type="submit">{{ app()->getLocale() == 'en' ? $translations['become_mentor']['value_en'] : $translations['become_mentor']['value_ar'] }} </button> --}}
                    <a href="{{ route('web_contact_us') }}">
                        <button class="btn-reach"
                            type="button">{{ app()->getLocale() == 'en' ? $translations['reach_us']['value_en'] : $translations['reach_us']['value_ar'] }}
                        </button>
                    </a>
                </div>
            </div>

            <div class="round-btn" id="show-search-box">
                <i class="fa fa-search flip-icon"></i>
            </div>

            <form id="hidden-search-box" class="navbar-form hidden-search-box" role="search">
                {{-- <div class="traingle"></div> --}}
                <div class="input-group add-on">
                    <input class="form-control addon-text-box" id="search_text" placeholder="Search here"
                        name=" search_text" type="text" data-url="{{ route('web_course_search') }}"
                        data-finder-url="{{ route('web_course_finder') }}">
                    <button type="submit" class="input-group-btn addon-btn">
                        <i class="fa fa-search flip-icon"></i>
                    </button>
                </div>
                <div class="search-result" id="search-result" style="display:none">
                    <div class="p-3">
                        <ul id="suggestionsList" class="p-0 m-0">
                        </ul>
                        <div class="text-center">
                        </div>
                    </div>
                </div>
            </form>

            {{-- <div class="hover-input-search mx-3">
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control item-search mobile"
                                    aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"
                                    placeholder="Search here" name=" search_text" id="search_text"
                                    data-url="{{ route('web_course_search') }}"
        data-finder-url="{{ route('web_course_finder') }}">
        <i class="fa-solid fa-magnifying-glass"></i>
        <div class="search-result" id="search-result" style="display:none">
            <div class="p-3">
                <ul id="suggestionsList" class="p-0 m-0">
                </ul>
                <div class="text-center">
                </div>
            </div>
        </div>

        </div>
        </div>
        </div> --}}

    </nav>
</section>

<section class="social-media-section">
    <a href="{{ config('settings.social.instagram_url') }}" target="_blank"><img
            src="{{ asset('images/web/instagram-icon.png') }}" alt=""></a>
    <a href="{{ config('settings.social.youtube_url') }}" target="_blank"><img
            src="{{ asset('images/web/youtube-icon-s.png') }}" alt=""></a>
    <a href="{{ config('settings.social.linkedin_url') }} " target="_blank"><img
            src="{{ asset('images/web/linkedin-icon.png') }}" alt=""></a>
    <a href="{{ config('settings.social.twitter_url') }}" target="_blank"><img
            src="{{ asset('images/web/twitter-icon.png') }}" alt=""></a>
    <a href="{{ config('settings.social.facebook_url') }}" target="_blank"><img
            src="{{ asset('images/web/facebook-icon.png') }}" alt=""></a>
          
    <p>Follow Us</p>
</section>
