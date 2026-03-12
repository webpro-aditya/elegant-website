<div class="card mb-9">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
            <div
                class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                @if ($course->thumbnail_url)
                    <img class="mw-50px mw-lg-75px"
                        src="{{ $course->thumbnail_url ? (Storage::disk('elegant')->exists($course->thumbnail_url) ? Storage::disk('elegant')->url($course->thumbnail_url) : asset('images/website/svg-icons/banner-btn-arw.svg')) : asset('images/website/svg-icons/banner-btn-arw.svg') }}"
                        alt="image" />
                @else
                    <img class="mw-50px mw-lg-75px" src="{{ asset('images/stock/course/course-stock.jpg') }}"
                        alt="image" />
                @endif
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex align-items-center w-100 mb-1">
                        <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">
                            {{ $course->english_title }}
                        </a>
                
                        <span class="badge badge-light-success me-3">
                            {{ $course->status }}
                        </span>
                
                        <div class="d-flex gap-3 ms-auto">
                            <a href="{{ route('web_course_detail', ['course' => $course->slug, 'locale' => 'en']) }}"
                                class="text-gray-800 text-hover-primary fw-bold"
                                target="_blank">
                                Frontend View
                            </a>
                            <a href="{{ route('course_edit', ['id' => $course->id])}}"
                                class="text-gray-800 text-hover-primary fw-bold">
                                Edit Course
                            </a>
                        </div>
                    </div>
                </div>
                
                


                <div class="d-flex flex-wrap justify-content-start">
                    <div class="d-flex flex-wrap">
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold">{{ $course->english_category_title }}</div>
                            </div>
                            <div class="fw-semibold fs-6 text-gray-500">Course Category</div>
                        </div>
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="d-flex align-items-center">

                                <div class="fs-4 fw-bold">{{ $course->start_date ?? '' }}</div>

                            </div>
                            <div class="fw-semibold fs-6 text-gray-500">Start Date</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator"></div>
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6  {{ $activeMenu === 'overview' ? 'active' : '' }} "
                    href="{{ route('course_overview_list', ['id' => $course->id]) }}"><span
                        id="overview-span">Overview</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6  {{ $activeMenu === 'training-calender' ? 'active' : '' }}"
                    href="{{ route('course_training_calendar_list', ['id' => $course->id]) }}">Training Calendar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 {{ $activeMenu === 'main-modules' ? 'active' : '' }}"
                    href="{{ route('course_main_module_list', ['id' => $course->id]) }}">Syllabus</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 {{ $activeMenu === 'batch' ? 'active' : '' }}"
                    href="{{ route('course_batch_list', ['id' => $course->id]) }}">Batch</a>
            </li>
        </ul>
    </div>
</div>
