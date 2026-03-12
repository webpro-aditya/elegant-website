@section('title', 'Over view')

@push('script')
    <script src="{{ mix('js/admin/course/mainModule/listMainModule.js') }}"></script>
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
        </x-toolbar>
    @endsection
    @include('course::admin.course.courseInfo', ['activeMenu' => 'overview', 'course' => $course])
    <div class="card p-4">
        <div class="card-header">
            <div class="card-title fs-3 fw-bold">Overview</div>
        </div>
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold px-5" role="tablist">
            @foreach ($languages as $id => $language)
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary py-5 me-6 {{ $loop->first ? 'active' : '' }}"
                        id="language-{{ $id }}-tab" data-bs-toggle="tab" href="#language-{{ $id }}"
                        role="tab" aria-controls="language-{{ $id }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $language->name }}
                    </a>
                </li>
            @endforeach
            @if ($seo != null)
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary py-5 me-6" id="seo-tab" data-bs-toggle="tab" href="#seo"
                        role="tab" aria-controls="seo" aria-selected="false">
                        SEO
                    </a>
                </li>
            @endif

        </ul>
        <div class="card-body">
            <div class="tab-content py-3">

                @foreach ($languages as $id => $language)
                    @php
                        $languageCode = strtolower($language->code); // Assuming $language is an object with a 'code' attribute
                        $isArabic = strtolower($language->name) === 'ar';
                        $localeContent = isset($coursesLocale[$languageCode])
                            ? $coursesLocale[$languageCode]->first()
                            : null;
                    @endphp
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="language-{{ $id }}"
                        role="tabpanel" aria-labelledby="language-{{ $id }}-tab">
                        <!-- Language-specific inputs -->
                        <div class="mb-3 language-input" data-language="{{ $id }}">
                            <label for="title" class="form-label fw-bold">Title:</label>
                            <label for="title" class="form-control"
                                @if ($isArabic) dir="rtl" @endif>{{ old('title.' . $languageCode) ?? ($localeContent->title ?? '') }}</label>
                        </div>

                        <div class="mb-3 fv-row fv-plugins-icon-container language-input"
                            data-language="{{ $id }}">
                            <label class="form-label fw-bold">Short Description:</label>
                            <label class="form-control"
                                @if ($isArabic) dir="rtl" @endif>{!! old('short_desc.' . $languageCode) ?? ($localeContent->short_description ?? '') !!}</label>
                        </div>

                    </div>
                @endforeach

                @if ($seo != null)
                    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">


                        <div class="mb-3 language-input"">
                            <label for="name" class="form-label fw-bold">Meta title:</label>
                            <label for="name" class="form-control">{{ $seo->meta_title }}</label>
                        </div>

                        <div class="mb-3 fv-row fv-plugins-icon-container language-input"">
                            <label class="form-label fw-bold">Meta Description:</label>
                            <label class="form-control">{!! $seo->meta_description !!}</label>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card p-4">
                <div class="row mb-3">
                    <div class="col-6">
                        <!-- Content for the left column -->
                        @if ($course->title)
                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    <b>Title:</b>
                                </label>
                                <span id="title">{{ $course->title }}</span>
                            </div>
                        @endif
                        @if ($course->thumbnail_alt)
                            <div class="mb-3">
                                <label for="thumbnail_alt" class="form-label">
                                    <b>Thumbnail Alt:</b>
                                </label>
                                <span id="thumbnail_alt">{{ $course->thumbnail_alt }}</span>
                            </div>
                        @endif
                        @if ($course->section)
                            <div class="mb-3">
                                <label for="section" class="form-label">
                                    <b>Section:</b>
                                </label>
                                <span id="section">{{ $course->section }}</span>
                            </div>
                        @endif
                        @if ($course->code)
                            <div class="mb-3">
                                <label for="code" class="form-label">
                                    <b>Course Code:</b>
                                </label>
                                <span id="code">{{ $course->code }}</span>
                            </div>
                        @endif
                        @if ($course->short_description)
                            <div class="mb-3">
                                <label for="short_description" class="form-label">
                                    <b>Short Description:</b>
                                </label>
                                <span id="short_description">{!! $course->short_description !!}</span>
                            </div>
                        @endif
                        @if ($course->language)
                            <div class="mb-3">
                                <label for="language" class="form-label">
                                    <b>Language:</b>
                                </label>
                                <span id="language">{{ $course->language }}</span>
                            </div>
                        @endif
                        @if ($course->pricing_format)
                            <div class="mb-3">
                                <label for="pricing_format" class="form-label">
                                    <b>Pricing Format:</b>
                                </label>
                                <span id="pricing_format">{{ $course->pricing_format }}</span>
                            </div>
                        @endif
                        @if ($course->duration_type)
                            <div class="mb-3">
                                <label for="duration_type" class="form-label">
                                    <b>Duration Type:</b>
                                </label>
                                <span id="duration_type">{{ $course->duration_type }}</span>
                            </div>
                        @endif
                        @if ($course->start_date)
                            <div class="mb-3">
                                <label for="date" class="form-label">
                                    <b>Start Date:</b>
                                </label>
                                <span id="date">{{ $course->start_date }}</span>
                            </div>
                        @endif
    
                        @if ($course->certifications)
                            <div class="mb-3">
                                <label for="certifications" class="form-label">
                                    <b>Certifications:</b>
                                </label>
                                <span id="certifications">{!! $course->certifications !!}</span>
                            </div>
                        @endif
                        @if ($course->description)
                            <div class="mb-3">
                                <label for="description" class="form-label">
                                    <b>Description:</b>
                                </label>
                                <span id="description">{!! $course->description !!}</span>
                            </div>
                        @endif
                    </div>
    
    
                    <div class="col-6">
                        <!-- Content for the right column -->
                        @if ($course->mode_of_learning)
                            <div class="mb-3">
                                <label for="mode" class="form-label">
                                    <b>Mode of Learning:</b>
                                </label>
                                @foreach ($course->mode_of_learning as $mode)
                                    <span class="badge badge-pill badge-primary">{{ $mode }}</span>
                                @endforeach
                            </div>
                        @endif
                        @if ($course->course_format)
                            <div class="mb-3">
                                <label for="course_format" class="form-label">
                                    <b>Course Format:</b>
                                </label>
                                <span id="course_format">{{ $course->course_format }}</span>
                            </div>
                        @endif
    
                        @if ($course->pricing_format != 'free')
                            <div class="mb-3">
                                <label for="price" class="form-label">
                                    <b>Pricing:</b>
                                </label>
                                <span id="price">{{ $course->fee }}</span>
                            </div>
                        @endif
                        @if ($course->course_completion_criteria)
                            <div class="mb-3">
                                <label for="course_completion_criteria" class="form-label">
                                    <b>Course Completion Criteria:</b>
                                </label>
                                <span id="course_completion_criteria">{{ $course->course_completion_criteria }}</span>
                            </div>
                        @endif
                        @if ($course->duration)
                            <div class="mb-3">
                                <label for="duration" class="form-label">
                                    <b>Duration:</b>
                                </label>
                                <span id="duration">{{ $course->duration }}</span>
                            </div>
                        @endif
                        @if ($course->certification)
    
                            <div class="mb-3">
                                <label for="certificate" class="form-label">
                                    <b>Provide Certificate:</b>
                                </label>
                                <span id="certificate">
                                    @if ($course->certification == 1)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </span>
                            </div>
                        @endif
                        @if ($course->started)
    
                            <div class="mb-3">
                                <label for="started" class="form-label">
                                    <b>Started:</b>
                                </label>
                                <span id="started">
                                    @if ($course->started == 'yes')
                                        Yes
                                    @else
                                        No
                                    @endif
                                </span>
                            </div>
                        @endif
                        @if ($course->introduction)
                            <div class="mb-3">
                                <label for="introduction" class="form-label">
                                    <b>Introduction:</b>
                                </label>
                                <span id="introduction">{!! $course->introduction !!}</span>
                            </div>
                        @endif
                        @if ($course->who_should_attend)
                            <div class="mb-3">
                                <label for="who_should_attend" class="form-label">
                                    <b>Who Should Attend:</b>
                                </label>
                                <span id="who_should_attend">{!! $course->who_should_attend !!}</span>
                            </div>
                        @endif
                        @if ($course->outcomes)
                            <div class="mb-3">
                                <label for="outcomes" class="form-label">
                                    <b>Outcomes:</b>
                                </label>
                                <span id="outcomes">{!! $course->outcomes !!}</span>
                            </div>
                        @endif
                    </div>
                </div>
                </div>
        </div>
    </div>

</x-layout>
