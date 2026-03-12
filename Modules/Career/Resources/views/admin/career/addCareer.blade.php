@section('title', 'Add Content')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/career/addCareer.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/contents/addContent.js') }}"></script>
    <script src="{{ mix('js/admin/career/addCareer.js') }}"></script>
@endpush

<x-layout>
    <form novalidate="novalidate" id="contentForm" class="form d-flex flex-column flex-lg-row"
        action="{{ route('career_save') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
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

        </div>
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        <h2>Career Details</h2>
                    </div>
                </div>

                <ul class="nav nav-tabs nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 px-10 fw-bold px-5"
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
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary py-5 me-6" id="seo-tab" data-bs-toggle="tab"
                            href="#seo" role="tab" aria-controls="seo" aria-selected="false">
                            SEO
                        </a>
                    </li>
                </ul>

                <div class="card-body">
                    <input type="hidden" name="model" id="model" value="Modules\Career\Entities\Career">
                    @include('cms::admin.contents.tabView.addContentTab')
                </div>

                <div id="title-div">
                    <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class=" form-label">Title</label>
                        <input type="text" name="title" class="form-control mb-2" placeholder="Title"
                            value="" id="title">
                        @error('title')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>

                    <div class="fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class=" form-label">Career Category</label>
                        <select class="form-select form-control-solid mb-2" name="category_id" data-kt-select2="true"
                            id="category_id" data-server="true" data-placeholder="Select Career Category"
                            data-option-url="{{ route('options_career_category') }}" value="{{ old('category_id') }}">
                        </select>
                        @error('category_id')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>

                    <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class=" form-label">Vaccancy</label>
                        <input type="number" name="vaccancy" class="form-control mb-2" placeholder="Vaccancy"
                            value="" id="vaccancy">
                        @error('vaccancy')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>

                    <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class="form-label">Experience</label>
                        <input type="number" name="experience" class="form-control mb-2" placeholder="Experience"
                            value="" id="experience">
                        @error('experience')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>

                    <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                        <label for="employment" class="form-label">Employment
                        </label>
                        <select class="form-control" data-control="select2" data-hide-search="true" id="employment"
                            name="employment">
                            <option value="full_time">Full time</option>
                            <option value="part_time">Part time</option>
                            <option value="contract">Contract</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button"
                    class="btn btn-light btn-active-light-primary me-2 fv-button-back">Back</button>
                <button type="submit" id="btnSubmit" class="btn btn-primary">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </form>
</x-layout>
