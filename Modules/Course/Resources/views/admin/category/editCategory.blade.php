@section('title', 'Edit Course Category')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/category/editCategory.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/category/editCategory.js') }}"></script>
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs"></x-toolbar>
    @endsection

    <form novalidate="novalidate" id="editCategoryForm"
        class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework"
        action="{{ route('course_category_update') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $category->id }}">
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Image</h2>
                    </div>
                </div>

                <div class="card-body text-center pt-0">
                    <div class="fv-row fv-plugins-icon-container">
                        <div class="image-input @if (!$category->image || !Storage::disk('elegant')->exists($category->image)) image-input-empty @endif image-input-outline image-input-placeholder mb-3"
                            data-kt-image-input="true">
                            <div class="image-input-wrapper w-150px h-150px"
                                @if ($category->image && Storage::disk('elegant')->exists($category->image)) style="background-image:
                                url({{ Storage::disk('elegant')->url($category->image) }})" @endif>
                            </div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change"
                                data-kt-initialized="1">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <input type="file" name="image" accept=".png,.jpg,.jpeg">
                                <input type="hidden" name="image">
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
                        @error('image')
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
                        <div class="rounded-circle bg-success w-15px h-15px" id="blog_status"></div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="blog_status_select">
                        <option value="active" @if ($category->status == 'active') selected @endif>Active</option>
                        <option value="inactive" @if ($category->status == 'inactive') selected @endif>Inactive</option>
                    </select>
                    <div class="text-muted fs-7">Set the category status.</div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush mb-6 mb-xl-9">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Category Details</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row mb-6">

                        <ul class="nav nav-tabs" id="language-tabs" role="tablist">
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
                    </div>
                        <div class="row mb-6">
                            <div class="tab-content" id="language-tabs-content">
                                @foreach ($languages as $id => $language)
                                    @php
                                        $languageCode = strtolower($language);
                                        $categoryLocale = isset($categoriesLocale[$languageCode])
                                            ? $categoriesLocale[$languageCode]->first()
                                            : null; // Check if data is available for the current language

                                    @endphp
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                        id="language-{{ $id }}" role="tabpanel"
                                        aria-labelledby="language-{{ $id }}-tab">
                                        <div class="mb-3 language-input" data-language="{{ $id }}">
                                            <label for="title_{{ $language }}" class="form-label ">Title
                                                ({{ $language }})
                                            </label>
                                            <input type="text" class="form-control" id="title_{{ $language }}"
                                                name="title[{{ strtolower($language) }}]"
                                                value="{{ old('title.' . $languageCode) ?? ($categoryLocale->title ?? '') }}"
                                                placeholder="title ({{ $language }})">
                                            @error('title.' . strtolower($language))
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-10 fv-row fv-plugins-icon-container language-input"
                                            data-language="{{ $id }}">
                                            <label class=" form-label">Description ({{ $language }})</label>
                                            <textarea id="description_{{ $languageCode }}" name="description[{{ $languageCode }}]"
                                                data-kt-tinymce-editor="true" data-kt-initialized="false" class="form-control min-h-200px mb-2">{!! old('description.' . $languageCode) ?? ($categoryLocale->description ?? '') !!}</textarea>
                                            @error('description.' . $languageCode)
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Parent Course Category
                                (optional)</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-12 fv-row">
                                        <select class="form-select form-control-solid mb-2" name="parent_category_id"
                                            data-kt-select2="true" data-server="true"
                                            data-placeholder="Select Category"
                                            data-option-url="{{ route('course_section_wise_categories') }}"
                                            value="{{ old('category_id') }}">
                                            @if (isset($old['parent_category_id']) && $old['parent_category_id'] != '')
                                                <option value="{{ $old['parent_category_id']->id }}">
                                                    {{ $old['parent_category_id']->title }}
                                                </option>
                                            @endif
                                        </select>
                                        @error('parent_category_id')
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('course_category_list') }}" class="btn btn-light me-5">Cancel</a>
                <button type="submit" id="btnSubmit" class="btn btn-primary fv-button-submit">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </form>
</x-layout>
