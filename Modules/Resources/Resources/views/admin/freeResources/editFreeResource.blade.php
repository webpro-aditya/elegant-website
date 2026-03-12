@section('title', 'Edit Free Resource')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/freeResource/editFreeResource.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/freeResource/editFreeResource.js') }}"></script>
@endpush

<x-layout>
    <form novalidate="novalidate" id="editFreeResourceForm" class="form d-flex flex-column flex-lg-row "
        action="{{ route('free_resource_update') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Thumbnail</h2>
                    </div>
                </div>
                <input type="hidden" name="resource_id" id="resource_id" value="{{ $resource->id }}">

                <div class="card-body text-center pt-0">
                    <div class="fv-row fv-plugins-icon-container">
                        <div class="image-input @if (!$resource->thumbnail || !Storage::disk('elegant')->exists($resource->thumbnail)) image-input-empty @endif image-input-outline image-input-placeholder mb-3"
                            data-kt-image-input="true">
                            <div class="image-input-wrapper w-150px h-150px"
                                @if ($resource->thumbnail && Storage::disk('elegant')->exists($resource->thumbnail)) style="background-image:
                                url({{ Storage::disk('elegant')->url($resource->thumbnail) }})" @endif>
                            </div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change"
                                data-kt-initialized="1">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <input type="file" name="thumbnail" accept=".png,.jpg,.jpeg">
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
                        <h2>Status</h2>
                    </div>
                    <div class="card-toolbar">
                        @if ($resource->status == 'active')
                            <div class="rounded-circle bg-success w-15px h-15px" id="free_resource_status"></div>
                        @else
                            <div class="rounded-circle bg-danger w-15px h-15px" id="free_resource_status"></div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="free_resource_status_select">
                        <option value="active" @if ($resource->status == 'active') selected @endif>Active</option>
                        <option value="inactive" @if ($resource->status == 'inactive') selected @endif>Inactive</option>
                    </select>
                    <div class="text-muted fs-7">Set the author status.</div>
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
                        <option value="no" @if ($resource->is_popular == 'no') selected @endif>No</option>
                        <option value="yes" @if ($resource->is_popular == 'yes') selected @endif>Yes</option>
                    </select>
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
                </ul>
                <div class="tab-content px-6 pt-6 mb-6" id="content-tab">
                    @foreach ($languages as $id => $language)
                        @php
                            $languageCode = strtolower($language);
                            $contentLocale = isset($contentsLocale[$languageCode])
                                ? $contentsLocale[$languageCode]->first()
                                : null; // Check if data is available for the current language
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
                                    value="{{ old('name.' . $languageCode) ?? ($contentLocale->name ?? '') }}"
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
                                    value="{{ old('short_desc.' . $languageCode) ?? ($contentLocale->short_description ?? '') }}"
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
                                    data-kt-tinymce-editor="true" data-kt-initialized="false" class="form-control min-h-200px mb-2">{!! old('description.' . $languageCode) ?? ($contentLocale->description ?? '') !!}</textarea>
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
                            <option value="interview" @if ($resource->type == 'interview') selected @endif>Interview</option>
                            <option value="quiz" @if ($resource->type == 'quiz') selected @endif>Quiz</option>
                        </select>
                    </div>

                    <div class="mb-10 col-6" id="time-container" style="display: none;">
                        <label class="form-label">Time <span class="text-muted">(HH:MM)</span> </label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="time" name="time"
                                placeholder="MM:SS" value="{{$resource->time}}"  />
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
                        id="image_title" value="{{$resource->image_title}}">
                    </div>

                    <div class="mb-10 col-6" i>
                        <label class="form-label">Thumbnail Alt Text</label>
                        <input type="text" name="thumbnail_alt" class="form-control mb-2"
                            placeholder="Thumbnail Alt Text" id="thumbnail_alt" value="{{$resource->thumbnail_alt}}">
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-end">

                <a href="{{ route('free_resource_list') }}" class="btn btn-light me-5">Cancel</a>
                <button type="submit" id="btnSubmit" class="btn btn-primary">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>

        </div>
    </form>
    </x-admin-layout>
