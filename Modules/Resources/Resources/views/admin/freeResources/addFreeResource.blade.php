@section('title', 'Add Free Resources')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/freeResource/addFreeResource.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/freeResource/addFreeResource.js') }}"></script>
@endpush

<x-layout>
    <form novalidate="novalidate" id="resourceForm" class="form d-flex flex-column flex-lg-row"
        action="{{ route('free_resource_save') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
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
                        <h2>Status</h2>
                    </div>
                    <div class="card-toolbar">
                        <div class="rounded-circle bg-success w-15px h-15px" id="resource_status"></div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="resource_status_select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Is it Popular</h2>
                    </div>

                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="is_popular" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="popular_status_select">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        <h2>Free Resource Details</h2>
                    </div>
                </div>

                <ul class="nav nav-tabs nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold px-5"
                    role="tablist" id="languageTabs">
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
                </ul>
                <div class="tab-content px-6 pt-6 mb-6" id="content-tab">
                    @foreach ($languages as $id => $language)
                        @php
                            $languageCode = strtolower($language);
                        @endphp

                        <div class="tab-pane nav-tabs fade {{ $loop->first ? 'show active' : '' }}"
                            id="language-{{ $id }}" role="tabpanel"
                            aria-labelledby="language-{{ $id }}-tab">
                            <!-- Language-specific inputs -->

                            <div class="mb-3 language-input" data-language="{{ $id }}">
                                <label for="name_{{ $language }}" class="form-label ">Name
                                    ({{ $language }})
                                </label>
                                <input type="text" class="form-control" id="name_{{ $language }}"
                                    name="name[{{ strtolower($language) }}]"
                                    value="{{ old('name.' . strtolower($language)) }}"
                                    placeholder="Title ({{ $language }})">
                                @error('name.' . strtolower($language))
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-10 fv-row fv-plugins-icon-container language-input"
                                data-language="{{ $id }}">
                                <label class="form-label">Short Description ({{ $language }})</label>
                                <input type="text" name="short_desc[{{ strtolower($language) }}]"
                                    class="form-control mb-2" placeholder="Short Description ({{ $language }})"
                                    value="{{ old('short_desc.' . strtolower($language)) }}"
                                    id="short_desc_{{ $language }}">
                                @error('short_desc.' . strtolower($language))
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-10 fv-row fv-plugins-icon-container language-input"
                                data-language="{{ $id }}">
                                <label class="form-label">Description ({{ $language }})</label>
                                <textarea id="description_{{ $language }}" name="description[{{ strtolower($language) }}]"
                                    data-kt-tinymce-editor="true" data-kt-initialized="false" class="form-control min-h-200px mb-2">{{ old('description.' . strtolower($language)) }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row px-6 ">
                    <div class="mb-10 col-12" id="type-container">
                        <label class="form-label">Type</label>
                        <select class="form-select mb-2" name="type" data-control="select2"
                            data-hide-search="true" data-placeholder="Select an option" id="type-select">
                            <option value="" disabled selected>Select an option</option>
                            <option value="interview">Interview</option>
                            <option value="quiz">Quiz</option>
                        </select>
                    </div>

                    <div class="mb-10 col-6" id="time-container" style="display: none;">
                        <label class="form-label">Time <span class="text-muted">(HH:MM)</span> </label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="time" name="time"
                                placeholder="MM:SS" />
                        </div>
                        @error('time')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row px-6">
                    <div class="mb-10 col-6">
                        <label class="form-label">Image Title</label>
                        <input type="text" name="image_title" class="form-control mb-2" placeholder="Image Title"
                            id="image_title">
                    </div>

                    <div class="mb-10 col-6" i>
                        <label class="form-label">Thumbnail Alt Text</label>
                        <input type="text" name="thumbnail_alt" class="form-control mb-2"
                            placeholder="Thumbnail Alt Text" id="thumbnail_alt">
                    </div>
                </div>

                <div class="accordion p-4" id="seoAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="seoHeading">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#seoTabContent" aria-expanded="true" aria-controls="seoTabContent">
                                SEO
                            </button>
                        </h2>
                        <div id="seoTabContent" class="accordion-collapse collapse" aria-labelledby="seoHeading"
                            data-bs-parent="#seoAccordion">
                            <div class="accordion-body">
                                <input type="hidden" name="model" id="model"
                                    value="Modules\Blog\Entities\FreeResource">
                                @include('seo::admin.addTab.seoTab')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-light btn-active-light-primary me-2 ">Back</button>
                <button type="submit" id="btnSubmit" class="btn btn-primary">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </form>
</x-layout>
