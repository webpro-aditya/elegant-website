@section('title', 'Add Content')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/contents/addContent.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/contents/addContent.js') }}"></script>
@endpush

<x-layout>
    <form novalidate="novalidate" id="contentForm" class="form d-flex flex-column flex-lg-row"
        action="{{ route('contents_save') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" name="slug" id="slug" value="{{ $slug }}">
        <input type="hidden" name="content_category_id" id="content_category_id" value="{{ $categoryId }}">
        <input type="hidden" name="content_category_slug" id="content_category_slug" value="{{ $categorySlug }}">
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            @if (in_array('thumbnail', $fields))
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Thumbnail Picture</h2>
                        </div>
                    </div>
                    <div class="card-body text-center pt-0">
                        <div class="fv-row fv-plugins-icon-container">
                            <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                                data-kt-image-input="true">
                                <div class="image-input-wrapper w-150px h-150px"></div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change"
                                    data-kt-initialized="1">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="thumbnail" accept=".png, .jpg, .jpeg">
                                    <input type="hidden" name="thumbnail_remove">
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
                            <div class="text-muted fs-7">Set the profile picture. Only *.png, *.jpg and *.jpeg image
                                files
                                are accepted</div>
                            @error('thumbnail')
                                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
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
                        <input type="text" name="thumbnail_alt" class="form-control mb-2" placeholder="Thumbnail Alt Text"
                            id="thumbnail_alt">
                    </div>
                </div>

                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Image Title</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <input type="text" name="image_title" class="form-control mb-2" placeholder="Image Title"
                            id="image_title">
                    </div>
                </div>
            @endif

            @if (in_array('status', $fields))
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Status</h2>
                        </div>
                        <div class="card-toolbar">
                            <div class="rounded-circle bg-success w-15px h-15px" id="content_status"></div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                            data-placeholder="Select an option" id="content_status_select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            @endif

            @if (in_array('file', $fields))
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>File</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <input type="file" name="file" class="form-control mb-2" placeholder="File">
                    </div>
                </div>
            @endif

        </div>
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        <h2>{{ $title }} Details</h2>
                    </div>
                </div>

                <ul class="nav nav-tabs nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold px-5"
                    role="tablist" id="languageTabs">
                    @foreach ($languages as $id => $language)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary py-5 me-6 {{ $loop->first ? 'active' : '' }}"
                                id="language-{{ $id }}-tab" data-bs-toggle="tab" href="#language-{{ $id }}" role="tab"
                                aria-controls="language-{{ $id }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ strtoupper($language) }}
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary py-5 me-6" id="seo-tab" data-bs-toggle="tab" href="#seo"
                            role="tab" aria-controls="seo" aria-selected="false">
                            SEO
                        </a>
                    </li>
                </ul>
                <div id="title-div">
                    @if (in_array('title', $fields))
                        <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                            <label class=" form-label">Title</label>
                            <input type="text" name="title" class="form-control mb-2" placeholder="Title" value=""
                                id="title">
                            @error('title')
                                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                    @endif

                    @if (in_array('email', $fields))
                        <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                            <label class=" form-label">Email</label>
                            <input type="email" name="email" class="form-control mb-2" placeholder="Email" value=""
                                id="email">
                            @error('email')
                                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                    @endif


                    @if (in_array('phone_number', $fields))
                        <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                            <label class=" form-label">Phone Number</label>
                            <input type="tel" name="phone_number" class="form-control mb-2" placeholder="Phone Number"
                                value="" id="phone_number">
                            @error('phone_number')
                                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                    @endif


                    @if (in_array('course_id', $fields))
                        <div class=" px-8 pt-6">
                            <label class=" form-label">Course Category</label>
                            <select class="form-select form-control-solid mb-2" name="category_id" id="category_id"
                                data-kt-select2="true" data-server="true" data-placeholder="Select Category"
                                data-option-url="{{ route('course_all_categories') }}">
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="fv-row fv-plugins-icon-container px-8 pt-6">
                            <label class=" form-label">Course</label>
                            <select class="form-select form-select-solid fw-bold"
                                data-option-url="{{ route('course_active_courses') }}"
                                data-select2-filter=@json(['category_id' => ['value' => '']]) data-kt-select2="true"
                                data-server="true" name="course_id" id="course_id" data-placeholder="Select Course">
                            </select>
                            @error('course_id')
                                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    <input type="hidden" name="model" id="model" value="Modules\Cms\Entities\Content">
                    @include('cms::admin.contents.tabView.addContentTab')
                </div>
            </div>

            @if (in_array('link', $fields) || in_array('file', $fields) || in_array('image-dropzone', $fields))
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ $title }} Media</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">

                        @if (in_array('link', $fields))
                            <div class="mb-10 fv-row fv-plugins-icon-container">
                                <label class=" form-label">Link</label>
                                <input type="text" name="link" class="form-control mb-2" placeholder="Link" value="" id="link">
                                @error('link')
                                    <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                                @enderror
                            </div>
                        @endif

                        <!-- @if (in_array('image-dropzone', $fields)) -->
                        <div class="fv-row mb-2">
                            <label class="form-label">Multi Images</label>
                            <div id="image-dropzone" data-kt-dropzone-input="true" class="image-dropzone dropzone"
                                data-action-url="{{ route('contents_image_save') }}" data-fetchable="true"
                                data-delete-url="{{ route('contents_image_delete') }}" data-content="true">
                                <div class="dz-message needsclick">
                                    <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                    <div class="ms-4">
                                        <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to
                                            upload.
                                        </h3>
                                    </div>
                                </div>
                            </div>



                        </div>
                        <!-- @endif -->

                    </div>

                </div>
            @endif


            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-light btn-active-light-primary me-2 fv-button-back">Back</button>
                <button type="submit" id="btnSubmit" class="btn btn-primary">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </form>
</x-layout>