@section('title', 'View Course')

@push('script')
<script src="{{ mix('js/admin/course/listCourse.js') }}"></script>
@endpush

@push('style')
<link rel="stylesheet" type="text/css" href="{{ mix('css/admin/course/listCourse.css') }}">
@endpush

<x-layout>
    @section('toolbar')
    <x-toolbar :breadcrumbs="$breadcrumbs">
    </x-toolbar>
    @endsection

    @include('course::admin.course.courseInfo', ['activeMenu' => 'settings' , 'course' => $course])

    <div class="tab-content">
        <div class="tab-pane fade show active" id="settings" role="tab-panel">
            <div class="d-flex flex-column gap-7 gap-lg-10">
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Course Settings</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form id="courseSettingsForm" class="form" action="{{ route('course_save_settings') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $course->id }}">

                            <div class="card-body p-9">
                                <div class="row mb-5">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Thumbnail</div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="image-input image-input-outline image-input-empty image-input-placeholder" data-kt-image-input="true">
                                            <div class="image-input-wrapper w-125px h-125px" @if ($course->thumbnail_url && Storage::disk('elegant')->exists($course->thumbnail_url)) style="background-image:
                                                url({{ Storage::disk('elegant')->url($course->thumbnail_url) }})" @endif>
                                            </div>
                                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <input type="file" name="thumbnail_url" accept=".png, .jpg, .jpeg" />
                                            </label>
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            @if ($course->thumbnail_url && Storage::disk('elegant')->exists($course->thumbnail_url))
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Course Title</div>
                                    </div>
                                    <div class="col-xl-9 fv-row">
                                        <input type="text" class="form-control form-control-solid" name="title" value="{{ old('title', $course->title) }}" />
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Course Code</div>
                                    </div>
                                    <div class="col-xl-9 fv-row">
                                        <input type="text" class="form-control form-control-solid" name="code" value="{{ old('code', $course->code) }}" />
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Is Started</div>
                                    </div>
                                    <div class="col-xl-9 fv-row">
                                        <input type="hidden" name="started" value="no">
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" id="started" name="started" value="yes" {{ $course->started === 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="started"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Start Date</div>
                                    </div>
                                    <div class="col-xl-9 fv-row">
                                        <div class="position-relative d-flex align-items-center">
                                            <input type="text" class="form-control form-control-solid flatpickr-input" name="start_date" id="start_date" value="{{ old('start_date', $course->start_date) }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Duration Type</div>
                                    </div>
                                    <div class="col-xl-9 fv-row">
                                        <div class="position-relative d-flex align-items-center">
                                            <div class="d-flex flex-column mb-8 fv-row">
                                                <div class="d-flex flex-stack gap-5 mb-3">
                                                    <button type="button" class="btn btn-light-primary w-100 {{ $course->duration_type === 'days' ? 'active' : '' }}" data-duration-type="days">Days</button>
                                                    <button type="button" class="btn btn-light-primary w-100 {{ $course->duration_type === 'months' ? 'active' : '' }}" data-duration-type="months">Months</button>
                                                </div>
                                                <input type="hidden" name="duration_type" id="duration_type" value="{{ old('duration_type', $course->duration_type) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3">Duration</div>
                                        </div>
                                        <div class="col-xl-9 fv-row">
                                            <div class="position-relative d-flex align-items-center">
                                                <div class="d-flex flex-column mb-8 fv-row">
                                                    <input type="number" class="form-control form-control-solid" placeholder="Enter duration" name="duration" value="{{ old('duration', $course->duration) }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Author</div>
                                    </div>
                                    <div class="col-xl-9 fv-row">
                                        <select class="form-select form-select-solid" aria-label="Select example" name="author_id" data-control="select2" placeholder="Select Author">
                                            <option>Select Author</option>
                                            @foreach ($mentors as $mentor)
                                            <option value="{{ $mentor->id }}" @if ($mentor->id == $course->author_id) selected @endif>{{ $mentor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Course Format</div>
                                    </div>
                                    <div class="col-xl-4 fv-row">
                                        <input type="radio" class="btn-check" name="course_format" value="open-ended" {{ isset($course) && $course->course_format === 'open-ended' ? 'checked' : '' }} id="kt_course_format_option_1" />
                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-4 d-flex align-items-center mb-3" for="kt_course_format_option_1">
                                            <i class="ki-duotone ki-setting-2 fs-3 me-3"><span class="path1"></span><span class="path2"></span></i>
                                            <span class="d-block fw-semibold text-start">
                                                <span class="text-gray-900 fw-bold d-block fs-2">open-ended</span>
                                                <span class="text-muted fw-semibold fs-4">open forever</span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-xl-4 fv-row">
                                        <input type="radio" class="btn-check" name="course_format" value="specific-dates" {{ isset($course) && $course->course_format === 'specific-dates' ? 'checked' : '' }} id="kt_course_format_option_2" />
                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-4 d-flex align-items-center mb-3" for="kt_course_format_option_2">
                                            <i class="ki-duotone ki-message-text-2 fs-3 me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            <span class="d-block fw-semibold text-start">
                                                <span class="text-gray-900 fw-bold d-block fs-2">specific-dates</span>
                                                <span class="text-muted fw-semibold fs-4">within specific dates</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Course Completion Criteria</div>
                                    </div>
                                    <div class="col-xl-6 fv-row">
                                        <label class="d-flex flex-stack mb-5 cursor-pointer">
                                            <span class="d-flex align-items-center me-2">
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i class="ki-duotone ki-compass fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                                    </span>
                                                </span>
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">complete-all-lesson</span>
                                                    <span class="fs-7 text-muted">complete-all-lesson</span>
                                                </span>
                                            </span>
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="course_completion_criteria" value="complete-all-lesson" {{ isset($course) && $course->course_completion_criteria === 'complete-all-lesson' ? 'checked' : '' }} />
                                            </span>
                                        </label>
                                        <label class="d-flex flex-stack mb-5 cursor-pointer">
                                            <span class="d-flex align-items-center me-2">
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-danger">
                                                        <i class="ki-duotone ki-element-11 fs-1 text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                    </span>
                                                </span>
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">complete-all-lesson-and-test</span>
                                                    <span class="fs-7 text-muted">Complete-all-lesson-and-test</span>
                                                </span>
                                            </span>
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="course_completion_criteria" value="complete-all-lesson-and-test" {{ isset($course) && $course->course_completion_criteria === 'complete-all-lesson-and-test' ? 'checked' : '' }} />
                                            </span>
                                        </label>
                                        <label class="d-flex flex-stack cursor-pointer">
                                            <span class="d-flex align-items-center me-2">
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-success">
                                                        <i class="ki-duotone ki-timer fs-1 text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                    </span>
                                                </span>
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">complete-all-test</span>
                                                    <span class="fs-7 text-muted">complete-all-test</span>
                                                </span>
                                            </span>
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="course_completion_criteria" value="complete-all-test" {{ isset($course) && $course->course_completion_criteria === 'complete-all-test' ? 'checked' : '' }} />
                                            </span>
                                        </label>
                                        <label class="d-flex flex-stack mb-5 cursor-pointer">
                                            <span class="d-flex align-items-center me-2">
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i class="ki-duotone ki-message-text-2 fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                                    </span>
                                                </span>
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">complete-a-test</span>
                                                    <span class="fs-7 text-muted">complete-a-test</span>
                                                </span>
                                            </span>
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="course_completion_criteria" value="complete-a-test" {{ isset($course) && $course->course_completion_criteria === 'complete-a-test' ? 'checked' : '' }} />
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="row mb-8">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Course Short Description</div>
                                    </div>
                                    <div class="col-xl-9 fv-row">
                                        <textarea id="short_description" name="short_description" data-kt-tinymce-editor="true" data-kt-initialized="false" class="form-control min-h-200px mb-2">{{old('short_description',$course->short_description)}}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Course Description</div>
                                    </div>
                                    <div class="col-xl-9 fv-row">
                                        <textarea id="description" name="description" data-kt-tinymce-editor="true" data-kt-initialized="false" class="form-control min-h-200px mb-2">{{old('description',$course->description)}}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Venue</div>
                                    </div>
                                    <div class="col-xl-9 fv-row">
                                        <select class="form-select form-select-solid" aria-label="Select example" name="venue_id" data-control="select2" placeholder="Select venue">
                                            <option>Select Venue</option>
                                            @foreach ($venues as $venue)
                                            <option value="{{ $venue->id }}" @if ($venue->id == $course->venue_id) selected @endif>{{ $venue->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Pricing Format</div>
                                    </div>
                                    <div class="col-xl-9 fv-row">
                                        <div class="position-relative d-flex align-items-center">
                                            <div class="d-flex flex-column mb-8 fv-row">
                                                <div class="d-flex flex-stack gap-5 mb-3">
                                                    <button type="button" class="btn btn-light-primary w-100 {{ $course->pricing_format === 'free' ? 'active' : '' }}" data-pricing-format="free">Free</button>
                                                    <button type="button" class="btn btn-light-primary w-100 {{ $course->pricing_format === 'paid' ? 'active' : '' }}" data-pricing-format="paid">Paid</button>
                                                </div>
                                                <input type="hidden" name="pricing_format" id="pricing_format" value="{{ old('pricing_format', $course->pricing_format) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-8" id="feeRow">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Fee</div>
                                    </div>
                                    <div class="col-xl-9 fv-row">
                                        <div class="position-relative d-flex align-items-center">
                                            <div class="d-flex flex-column mb-8 fv-row">
                                                <input type="number" class="form-control form-control-solid" placeholder="Enter fee" name="fee" id="fee" value="{{ old('fee', $course->fee) }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-3">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Is Featured</div>
                                    </div>
                                    <div class="col-xl-9 fv-row">
                                        <input type="hidden" name="featured" value="0">
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ isset($course) && $course->featured ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-6">
                                        @if(isset($course->brochure_url))
                                        <a href="{{ Storage::disk('elegant')->url($course->brochure_url) }}" download>
                                            <button type="button" class="btn btn-primary">Download Brochure</button>
                                        </a>
                                        @endif
                                    </div>
                                    <div class="col-xl-6">
                                        @if(isset($course->demo_video_url))
                                        <a href="{{ Storage::disk('elegant')->url($course->demo_video_url) }}" download>
                                            <button type="button" class="btn btn-primary">Download Video</button>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-xl-6 fv-row">
                                        <label for="brochure_url" class="btn btn-light-primary">
                                            <input type="file" class="form-control-file d-none" id="brochure_url" name="brochure_url">
                                            <i class="ki-outline ki-folder-up fs-2"></i> Upload Brochure
                                        </label>
                                    </div>
                                    <div class="col-xl-6 fv-row">
                                        <label for="demo_video_url" class="btn btn-light-primary">
                                            <input type="file" class="form-control-file d-none" id="demo_video_url" name="demo_video_url">
                                            <i class="ki-outline ki-folder-up fs-2"></i> Upload Video
                                        </label>
                                    </div>
                                </div>

                            </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="button" class="btn btn-light btn-active-light-primary me-2 fv-button-back">Back</button>
                        <button type="submit" id="btnSubmit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layout>
