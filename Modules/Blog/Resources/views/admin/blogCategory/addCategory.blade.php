@section('title', 'Add Blog')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/blogcategory/addBlogCategory.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/blogcategory/addBlogCategory.js') }}"></script>
@endpush

<x-layout>
    <form novalidate="novalidate" id="categoryForm"
        class="form d-flex flex-column flex-lg-row"
        action="{{ route('blog_category_save') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <div class="card-toolbar">
                        <div class="rounded-circle bg-success w-15px h-15px" id="blog_category_status"></div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="blog_category_status_select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Is Featured</h2>
                    </div>
                   
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="is_featured" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Blog Category Details</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <ul class="nav nav-tabs nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold mb-4" role="tablist" id="languageTabs">
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
                            class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                            role="tabpanel" aria-labelledby="language-{{ $id }}-tab">
                            <div id="content-tab">
                                @php
                                $languageCode = strtolower($language);
                                @endphp
                    
                                <div class="mb-3 language-input" data-language="{{ $id }}">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Category Name
                                            ({{ $language }})
                                        </label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" name="name_{{ $languageCode }}"
                                                        class="form-control form-control-lg mb-3 mb-lg-0"
                                                        placeholder="Name - {{ $language }}"
                                                        id="name_{{ $languageCode }}"
                                                         />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-light btn-active-light-primary me-2 fv-button-back">Back</button>
                <button type="submit" id="btnSubmit" class="btn btn-primary ">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </form>
</x-layout>
