@section('title', 'Edit Gallery')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/editGallery.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/editGallery.js') }}"></script>
@endpush

<x-layout>
    <x-toolbar :breadcrumbs="$breadcrumbs"></x-toolbar>

    <form novalidate="novalidate" id="editGalleryForm"
        class="form d-flex flex-column flex-lg-row "
        action="{{ route('gallery_update') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $gallery->id }}">

        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            {{-- <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Profile Picture</h2>
                    </div>
                </div>
                <div class="card-body text-center pt-0">
                    <div class="fv-row fv-plugins-icon-container">
                        <div class="image-input @if (!$gallery->thumbnail_picture || !Storage::disk('elegant')->exists($gallery->thumbnail_picture)) image-input-empty @endif image-input-outline image-input-placeholder mb-3"
                            data-kt-image-input="true">
                            <div class="image-input-wrapper w-150px h-150px"
                                @if ($gallery->thumbnail_picture && Storage::disk('elegant')->exists($gallery->thumbnail_picture)) style="background-image: url({{ Storage::disk('elegant')->url($gallery->thumbnail_picture) }})" @endif>
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
                    <input type="text" name="thumbnail_alt" class="form-control mb-2" placeholder="Thumbnail Alt Text"
                    id="thumbnail_alt" value="{{$gallery->thumbnail_alt}}">
                </div>
            </div>  --}}
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <div class="card-toolbar">
                        <div class="rounded-circle {{ $gallery->status == 'active' ? 'bg-success' : 'bg-danger' }} w-15px h-15px"
                            id="gallery_status"></div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="gallery_status_select">
                        <option value="active" @if ($gallery->status == 'active') selected @endif>Active</option>
                        <option value="inactive" @if ($gallery->status == 'inactive') selected @endif>Inactive</option>
                    </select>
                    <div class="text-muted fs-7">Set the Gallery status.</div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush mb-6 mb-xl-9">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Gallery Details</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <ul class="nav nav-tabs nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold mb-4"
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
                    <div class="tab-content">
                        @foreach ($languages as $id => $language)
                            <div id="language-{{ $id }}"
                                class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" role="tabpanel"
                                aria-labelledby="language-{{ $id }}-tab">
                                <div id="content-tab">
                                    @php
                                        $languageCode = strtolower($language);
                                    @endphp
                                    <div class="mb-3 language-input" data-language="{{ $id }}">
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Name
                                                ({{ strtoupper($language) }})</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-12 fv-row">
                                                        <input type="text" name="name_{{ $languageCode }}"
                                                            class="form-control form-control-lg mb-3 mb-lg-0"
                                                            placeholder="Name - {{ strtoupper($language) }}"
                                                            value="{{ old('name_' . $languageCode, $gallery->{'name_' . $languageCode}) }}"
                                                            id="name_{{ $languageCode }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="card-body pt-0">
                        <label class="form-label">Gallery Images</label>
                        <div id="image-dropzone" class="image-dropzone dropzone" data-kt-dropzone-input="true"
                            data-banner_id="{{ $gallery->id }}" data-action-url="{{ route('gallery_image_save') }}"
                            data-fetchable="true"
                            data-fetch-url="{{ route('gallery_fetch_image', ['gallery_id' => $gallery->id]) }}"
                            data-delete-url="{{ route('gallery_image_delete') }}" data-content="true"
                            data-data-update-url="{{ route('gallery_data_update') }}">
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

            <div class="d-flex justify-content-end">
                <a href="{{ route('gallery_list') }}" class="btn btn-light me-5">Cancel</a>
                <button type="submit" id="btnSubmit" class="btn btn-primary ">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </form>
</x-layout>
