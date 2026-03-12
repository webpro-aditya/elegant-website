@section('title', 'Edit Course')

@push('style')
<link rel="stylesheet" type="text/css" href="{{ mix('css/admin/course/editCourse.css') }}">
@endpush

@push('script')
<script src="{{ mix('js/admin/course/editCourse.js') }}"></script>
@endpush

<x-layout>
    @section('toolbar')
    <x-toolbar :breadcrumbs="$breadcrumbs"></x-toolbar>
    @endsection

    <form novalidate="novalidate" id="editCourseForm" class="form d-flex flex-column flex-lg-row"
        action="{{ route('course_update') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $course->id }}">
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Image</h2>
                    </div>
                </div>
                <div class="card-body text-center pt-0">
                    <div class="fv-row fv-plugins-icon-container">

                        <div class="image-input @if (!$course->thumbnail_url || !Storage::disk('elegant')->exists($course->thumbnail_url)) image-input-empty @endif image-input-outline image-input-placeholder mb-3"
                            data-kt-image-input="true">
                            <div class="image-input-wrapper w-150px h-150px"
                                @if ($course->thumbnail_url && Storage::disk('elegant')->exists($course->thumbnail_url)) style="background-image:
                                url({{ Storage::disk('elegant')->url($course->thumbnail_url) }})" @endif>
                            </div>

                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change"
                                data-kt-initialized="1">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <input type="file" name="thumbnail_picture" accept=".png,.jpg,.jpeg">
                                <input type="hidden" name="thumbnail_picture_remove">
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel"
                                data-kt-initialized="1">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove"
                                data-kt-initialized="1">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                        </div>
                        <div class="text-muted fs-7">Set the profile picture. Only *.png, *.jpg and *.jpeg image files
                            are accepted</div>
                        @error('thumbnail_picture')
                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Thumbnail Alt Text</h2>
                    </div>

                </div>
                <div class="card-body pt-0">
                    <input type="text" name="thumbnail_alt" value="{{ $course->thumbnail_alt }}"
                        class="form-control mb-2" placeholder="Thumbnail Alt Text" id="thumbnail_alt">
                </div>
            </div>


            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Is it Popular Course</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="popular_course" data-control="select2"
                        data-hide-search="true" data-placeholder="Select an option" id="popular_course_select">
                        <option value="no" @if ($course->popular_course == 'no') selected @endif>No</option>
                        <option value="yes" @if ($course->popular_course == 'yes') selected @endif>Yes</option>
                    </select>
                    <div class="text-muted fs-7">Set the course popularity.</div>
                </div>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Career Package</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="career_package" data-control="select2"
                        data-hide-search="true" data-placeholder="Select an option" id="career_package_select">
                        <option value="no" @if ($course->career_package == 'no') selected @endif>No</option>
                        <option value="yes" @if ($course->career_package == 'yes') selected @endif>Yes</option>
                    </select>
                    <div class="text-muted fs-7">Set the Course Packages.</div>
                </div>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="blog_status_select">
                        <option value="publish" @if ($course->status == 'publish') selected @endif>publish</option>
                        <option value="draft" @if ($course->status == 'draft') selected @endif>draft</option>
                    </select>
                    <div class="text-muted fs-7">Set the course status.</div>
                </div>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Brochure</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <input type="hidden" name="file" value="0">
                        <div class="file-input">
                            @if ($course->brochure_url)
                            <div class="d-flex align-items-center file-container">
                                <a href="{{ Storage::disk('elegant')->url($course->brochure_url) }}"
                                    class="text-gray-800 text-hover-primary mb-4">
                                    <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z"
                                                fill="currentColor"></path>
                                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor">
                                            </path>
                                        </svg>
                                    </span>
                                    {{ mb_strimwidth(basename($course->brochure_url), 0, 20, '...') }}

                                </a>
                                <span class="btn btn-icon btn-active-color-primary w-25px h-25px"
                                    data-kt-file-input-action="remove" data-bs-toggle="tooltip"
                                    aria-label="Remove" data-kt-initialized="1">
                                    <i class="bi bi-x fs-2" id="removeFile"></i>
                                </span>
                            </div>
                            @else
                            <input type="hidden" name="brochure_url" value="1">
                            @endif
                            <input type="hidden" name="brochure_url_remove" id="brochure_url_remove">
                            <input type="file" name="brochure_url" class="form-control mb-2" placeholder="File"
                                value="">
                            @error('file')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Curriculum</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <input type="hidden" name="curriculum_url" value="0">
                        <div class="file-input">
                            @if ($course->curriculum_url)
                            <div class="d-flex align-items-center file-container">
                                <a href="{{ Storage::disk('elegant')->url($course->curriculum_url) }}"
                                    class="text-gray-800 text-hover-primary mb-4">
                                    <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z"
                                                fill="currentColor"></path>
                                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor">
                                            </path>
                                        </svg>
                                    </span>
                                    {{ mb_strimwidth(basename($course->curriculum_url), 0, 20, '...') }}

                                </a>
                                <span class="btn btn-icon btn-active-color-primary w-25px h-25px"
                                    data-kt-file-input-action="remove" data-bs-toggle="tooltip"
                                    aria-label="Remove" data-kt-initialized="1">
                                    <i class="bi bi-x fs-2" id="removeFile"></i>
                                </span>
                            </div>
                            @else
                            <input type="hidden" name="curriculum_url" value="1">
                            @endif
                            <input type="hidden" name="curriculum_remove" id="curriculum_remove">
                            <input type="file" name="curriculum_url" class="form-control mb-2" placeholder="File"
                                value="">
                            @error('curriculum_url')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>


            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Featured</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="featured" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="featured">
                        <option value="0" @if ($course->featured == 0) selected @endif>No</option>
                        <option value="1" @if ($course->featured == 1) selected @endif>Yes</option>
                    </select>
                    <div class="text-muted fs-7">Set the course status.</div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush mb-6 mb-xl-9">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Course Details</h2>
                    </div>
                </div>
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold px-5"
                    role="tablist">
                    @foreach ($languages as $id => $language)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary py-5 me-6 {{ $loop->first ? 'active' : '' }}"
                            id="language-{{ $id }}-tab" data-bs-toggle="tab"
                            href="#language-{{ $id }}" role="tab"
                            aria-controls="language-{{ $id }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            {{ strtoupper($language) }}
                        </a>
                    </li>
                    @endforeach
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary py-5 me-6" id="seo-tab" data-bs-toggle="tab"
                            href="#seo" role="tab" aria-controls="seo" aria-selected="false">
                            SEO
                        </a>
                    </li>
                </ul>
                <div class="card-body pt-0">

                    <input type="hidden" name="model" id="model" value="Modules\Course\Entities\Course">

                    @include('course::admin.course.tabEdits.courseEditTab')
                    <div id="title-div">

                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="required form-label">Category</label>
                            <select class="form-select form-control-solid mb-2" name="category_id"
                                data-kt-select2="true" id="category_id" data-server="true"
                                data-placeholder="Select Category"
                                data-option-url="{{ route('course_all_categories') }}"
                                value="{{ old('category_id') }}">
                                @if (isset($old['category_id']) && $old['category_id'] != '')
                                <option value="{{ $old['category_id']->id }}">
                                    {{ $old['category_id']->title }}
                                </option>
                                @endif
                            </select>
                            @error('category_id')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>

                        <input type="hidden" name="mode_of_learning[]" id="mode_of_learning" value="offline">
                        {{-- <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="form-label required mb-7">Mode Of Learning</label>
                            <div class="form-check-container"
                                style="display: flex; justify-content: space-between; gap: 10px;">
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" id="online"
                                        name="mode_of_learning[]" value="online"
                                        @if (in_array('online', $course->mode_of_learning)) checked @endif>
                                    <label for="online" class="form-check-label">Online</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" id="offline"
                                        name="mode_of_learning[]" value="offline"
                                        @if (in_array('offline', $course->mode_of_learning)) checked @endif>
                                    <label for="offline" class="form-check-label">Offline</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" id="self-paced"
                                        name="mode_of_learning[]" value="self-paced"
                                        @if (in_array('self-paced', $course->mode_of_learning)) checked @endif>
                                    <label for="self-paced" class="form-check-label">Self-paced</label>
                                </div>
                            </div>
                        </div> --}}
                        <!-- 
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="form-label">Pricing</label>
                            <select class="form-select mb-2" name="pricing_format" id="pricing_format"
                                data-control="select2" data-hide-search="true">
                                <option value="free" @if ($course->pricing_format == 'free') selected @endif>
                                    Free
                                </option>
                                <option value="paid" @if ($course->pricing_format == 'paid') selected @endif>
                                    Paid
                                </option>
                            </select>
                        </div> -->
                        <input type="hidden" name="pricing_format" id="pricing_format" value="paid">

                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="form-label">Fee</label>
                            <input type="text" name="fee" class="form-control mb-2" placeholder="Fee"
                                value="{{ old('fee', $course->fee) }}">
                            @error('fee')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>

                        <!-- <input type="hidden" name="discount" id="discount" value="no"> -->
                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="form-label">Discount</label>
                            <select class="form-select mb-2" name="discount" id="discount" data-control="select2"
                                data-hide-search="true">
                                <option value="yes" @if ($course->discount == 'yes') selected @endif>
                                    Yes
                                </option>
                                <option value="no" @if ($course->discount == 'no') selected @endif>
                                    No
                                </option>
                            </select>
                        </div>

                        <div class="mb-10 fv-row fv-plugins-icon-container" id="discountInputBox"
                            @if ($course->discount == 'no') style="display: none;" @endif>
                            <label class="form-label">Discount Fee</label>
                            <input type="integer" name="discount_fee" class="form-control mb-2"
                                placeholder="Discount Fee" value="{{ old('discount_fee', $course->discount_fee) }}">
                            @error('discount_fee')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>

                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="form-label">Rating</label>
                            <input type="number" name="rating" class="form-control mb-2" placeholder="Rating"
                                value="{{ old('rating', $course->rating) }}">
                            @error('rating')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>

                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="form-label">Start Date</label>
                            <input type="text" class="form-control form-control-solid flatpickr-input"
                                name="start_date" id="start_date"
                                value="{{ old('start_date', $course->start_date) }}" />
                            @error('start_date')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>

                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="form-label">Duration</label>
                            <select class="form-select mb-2" name="duration_type" id="duration_type"
                                data-control="select2" data-hide-search="true">
                                <option value="days" @if ($course->duration_type == 'days') selected @endif>
                                    Days
                                </option>
                                <option value="months" @if ($course->duration_type == 'months') selected @endif>
                                    Months
                                </option>
                                <option value="hours" @if ($course->duration_type == 'hours') selected @endif>
                                    Hours
                                </option>
                            </select>
                        </div>

                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="required form-label">Course Duration</label>
                            <input type="number" name="duration" id="duration" class="form-control mb-2"
                                placeholder="Course Duration" value="{{ old('duration', $course->duration) }}">
                            @error('duration')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>

                        <div class="mb-10 fv-row fv-plugins-icon-container">
                            <label class="form-label">Video Url</label>
                            <input type="text" name="demo_video_url" class="form-control mb-2" id="url"
                                placeholder="Demo video url"
                                value="{{ old('demo_video_url', $course->demo_video_url) }}">
                            @error('demo_video_url')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>

                        <div class="fv-row mb-2">
                            <label class="form-label">Certificate Images (390 * 530) </label>
                            <div id="image-dropzone" data-kt-dropzone-input="true" class="image-dropzone dropzone"
                                data-course_id="{{ $course->id }}"
                                data-action-url="{{ route('course_image_save') }}" data-fetchable="true"
                                data-fetch-url="{{ route('course_fetch_image', ['course_id' => $course->id]) }}"
                                data-delete-url="{{ route('course_image_delete') }}" data-content="true"
                                data-data-update-url="{{ route('course_data_update') }}">
                                <div class="dz-message needsclick">
                                    <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                    <div class="ms-4">
                                        <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('course_list') }}" class="btn btn-light me-5">Cancel</a>
                <button type="submit" id="btnSubmit" class="btn btn-primary">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </form>

</x-layout>