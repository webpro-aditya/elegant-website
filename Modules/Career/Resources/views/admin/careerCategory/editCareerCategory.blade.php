@section('title', 'Edit Career Category')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/careerCategory/editCareerCategory.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/careerCategory/editCareerCategory.js') }}"></script>
@endpush

<x-layout>
    <x-toolbar :breadcrumbs="$breadcrumbs"></x-toolbar>

    <form novalidate="novalidate" id="categoryForm"
        class="form d-flex flex-column flex-lg-row "
        action="{{ route('career_category_update') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $category->id }}">
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <div class="card-toolbar">
                        @if ($category->status == 'active')
                            <div class="rounded-circle bg-success w-15px h-15px" id="category_status"></div>
                        @else
                            <div class="rounded-circle bg-danger w-15px h-15px" id="category_status"></div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="category_status_select">
                        <option value="active" @if ($category->status == 'active') selected @endif>Active</option>
                        <option value="inactive" @if ($category->status == 'inactive') selected @endif>Inactive</option>
                    </select>
                    <div class="text-muted fs-7">Set the Career category status.</div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush mb-6 mb-xl-9">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Career Category Details</h2>
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
                                                            value="{{ old('name_' . $languageCode, $category->{'name_' . $languageCode}) }}" />
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
                <a href="{{ route('career_category_list') }}" class="btn btn-light me-5">Cancel</a>
                <button type="submit" id="btnSubmit" class="btn btn-primary ">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </form>
</x-layout>
