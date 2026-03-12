@section('title', 'Edit Content')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/contents/editContent.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/contents/editContent.js') }}"></script>
@endpush

<x-layout>
    <form novalidate="novalidate" id="editContentForm"
        class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework"
        action="{{ route('contents_update') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" name="slug" id="slug" value="{{ $slug }}">
        <input type="hidden" name="content_category_slug" id="content_category_slug" value="{{ $categorySlug }}">
        <input type="hidden" name="content_id" id="content_id" value="{{ $contents->id }}">
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            @if (in_array('thumbnail', $fields))
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Thumbnail</h2>
                        </div>
                    </div>
                    <div class="card-body text-center pt-0">
                        <div class="fv-row fv-plugins-icon-container">
                            <div class="image-input @if (!$contents->thumbnail || !Storage::disk('elegant')->exists($contents->thumbnail)) image-input-empty @endif image-input-outline image-input-placeholder mb-3"
                                data-kt-image-input="true">
                                <div class="image-input-wrapper w-150px h-150px"
                                    @if ($contents->thumbnail && Storage::disk('elegant')->exists($contents->thumbnail)) style="background-image:
                                url({{ Storage::disk('elegant')->url($contents->thumbnail) }})" @endif>
                                </div>
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change"
                                    data-kt-initialized="1">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="thumbnail" accept=".png,.jpg,.jpeg">
                                    <input type="hidden" name="thumbnail_remove">
                                </label>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel"
                                    data-kt-initialized="1">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove"
                                    data-kt-initialized="1">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                            </div>
                            <div class="text-muted fs-7">Set the profile picture. Only .png, .jpg and *.jpeg image files
                                are
                                accepted</div>
                            @error('thumbnail')
                                <div class="invalid-feedback"> {{ $message }} </div>
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
                        <input type="text" name="thumbnail_alt" class="form-control mb-2"
                            placeholder="Thumbnail Alt Text" value="{{ $contents->thumbnail_alt }}" id="thumbnail_alt">
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
                            value="{{ $contents->image_title }}" id="image_title">
                    </div>
                </div>
            @endif
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <div class="card-toolbar">
                        @if ($contents->status == 'active')
                            <div class="rounded-circle bg-success w-15px h-15px" id="contents_status"></div>
                        @else
                            <div class="rounded-circle bg-danger w-15px h-15px" id="contents_status"></div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="contents_status_select">
                        <option value="active" @if ($contents->status == 'active') selected @endif>Active</option>
                        <option value="inactive" @if ($contents->status == 'inactive') selected @endif>Inactive</option>
                    </select>
                    <div class="text-muted fs-7">Set the content status.</div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        <h2> Details</h2>
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
                <div id="title-div">
                    @if (in_array('title', $fields))
                        <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                            <label class=" form-label">Title</label>
                            <input type="text" name="title" class="form-control mb-2" placeholder="Title"
                                value="{{ $title }}" id="title">
                            @error('title')
                                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                    @endif

                    @if (in_array('email', $fields))
                        <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                            <label class=" form-label">Email</label>
                            <input type="email" name="email" class="form-control mb-2" placeholder="Email"
                                id="email" value="{{ $contents->email }}">
                            @error('email')
                                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                    @endif

                    @if (in_array('phone_number', $fields))
                        <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                            <label class=" form-label">Phone Number</label>
                            <input type="tel" name="phone_number" class="form-control mb-2"
                                placeholder="Phone Number"  id="phone_number"
                                value="{{ $contents->phone_number }}">
                            @error('phone_number')
                                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                    @endif

                    @if (in_array('course_id', $fields))
                        <div class="fv-row fv-plugins-icon-container px-8 pt-6">
                            <label class=" form-label">Course</label>
                            <select class="form-select form-control-solid mb-2" name="course_id"
                                data-kt-select2="true" id="course_id" data-server="true"
                                data-placeholder="Select Course"
                                data-option-url="{{ route('course_active_courses') }}"
                                value="{{ old('course_id') }}">
                                @if (isset($old['course_id']) && $old['course_id'] != '')
                                    <option value="{{ $old['course_id']->id }}">
                                        {{ $old['course_id']->title }}
                                    </option>
                                @endif
                            </select>

                        </div>
                    @endif
                </div>
                <div class="card-body pt-4">
                    <input type="hidden" name="model" id="model" value="Modules\Cms\Entities\Content">

                    @include('cms::admin.contents.tabEdit.editContentTab')
                </div>
            </div>
            @if (in_array('link', $fields) || in_array('file', $fields) || in_array('image-dropzone', $fields))
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Media</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @if (in_array('link', $fields))
                            <div class="mb-10 fv-row fv-plugins-icon-container">
                                <label class="required form-label">Link</label>
                                <input type="text" name="link" class="form-control mb-2" placeholder="link"
                                    value="{{ old('link', $contents->link) }}">
                                @error('link')
                                    <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                                @enderror
                            </div>
                        @endif

                        @if (in_array('file', $fields))

                            <div class="mb-10 fv-row fv-plugins-icon-container">
                                <input type="hidden" name="file" value="0">
                                <div class="file-input">
                                    <label class="required form-label">File</label>
                                    @if ($contents->file)
                                        <div class="d-flex align-items-center file-container">
                                            <a href="{{ Storage::disk('elegant')->url($contents->file) }}"
                                                class="text-gray-800 text-hover-primary">
                                                <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z"
                                                            fill="currentColor"></path>
                                                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                {{ basename($contents->file) }}</a>
                                            <span class="btn btn-icon btn-active-color-primary w-25px h-25px"
                                                data-kt-file-input-action="remove" data-bs-toggle="tooltip"
                                                aria-label="Remove" data-kt-initialized="1">
                                                <i class="bi bi-x fs-2" id="removeFile"></i>
                                            </span>
                                        </div>
                                    @else
                                        <input type="hidden" name="file" value="1">
                                    @endif
                                    <input type="hidden" name="file_remove" id="file_remove">
                                    <input type="file" name="file" class="form-control mb-2"
                                        placeholder="File" value=""
                                        @if ($contents->file && Storage::disk('elegant')->exists($contents->file)) style="display:none;" @endif>
                                    @error('file')
                                        <div class="fv-plugins-message-container invalid-feedback"> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                        @endif
                        @if (in_array('image-dropzone', $fields))
                            <div class="fv-row mb-2">
                                <label class="form-label">Multi Images(700*380px)</label>
                                <div id="image-dropzone" data-kt-dropzone-input="true"
                                    class="image-dropzone dropzone" data-content_id="{{ $contents->id }}"
                                    data-action-url="{{ route('contents_image_save') }}" data-fetchable="true"
                                    data-fetch-url="{{ route('contents_fetch_image', ['content_id' => $contents->id]) }}"
                                    data-delete-url="{{ route('contents_image_delete') }}" data-content="true"
                                    data-data-update-url="{{ route('contents_data_update') }}">
                                    <div class="dz-message needsclick">
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <div class="ms-4">
                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to
                                                upload.
                                            </h3>
                                        </div>
                                    </div>
                                </div>


                                {{-- <div id="image-dropzone" data-kt-dropzone-input="true" class="image-dropzone dropzone"
                                data-content_id="{{ $contents->id }}"
                                data-action-url="{{ route('contents_image_save') }}" data-fetchable="true"
                                data-fetch-url="{{ route('contents_fetch_image', ['content_id' => $contents->id]) }}"
                                data-delete-url="{{ route('contents_image_delete') }}" data-content="true"
                                data-data-update-url="{{ route('contents_data_update') }}">
                                <div class="dz-message needsclick">
                                    <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                    <div class="ms-4">
                                        <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to
                                            upload.
                                        </h3>
                                    </div>
                                </div>
                            </div> --}}
                            </div>
                        @endif

                    </div>
                </div>
            @endif
            <input type="hidden" name="category_slug" value="{{ $categorySlug }}">
            <div class="d-flex justify-content-end">

                <a href="{{ route('contents_view') }}" class="btn btn-light me-5">Cancel</a>
                <button type="submit" id="btnSubmit" class="btn btn-primary">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>

        </div>
    </form>
    </x-admin-layout>
