@section('title', 'Edit Career')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/career/editCareer.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/career/editCareer.js') }}"></script>
    <script src="{{ mix('js/admin/contents/editContent.js') }}"></script>
@endpush

<x-layout>
    <form novalidate="novalidate" id="editContentForm"
        class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework"
        action="{{ route('career_update') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <input type="hidden" name="career_id" id="career_id" value="{{ $career->id }}">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <div class="card-toolbar">
                        @if ($career->status == 'active')
                            <div class="rounded-circle bg-success w-15px h-15px" id="career_status"></div>
                        @else
                            <div class="rounded-circle bg-danger w-15px h-15px" id="career_status"></div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="career_status_select">
                        <option value="active" @if ($career->status == 'active') selected @endif>Active</option>
                        <option value="inactive" @if ($career->status == 'inactive') selected @endif>Inactive</option>
                    </select>
                    <div class="text-muted fs-7">Set the career status.</div>
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
                    <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class=" form-label">Title</label>
                        <input type="text" name="title" class="form-control mb-2" placeholder="Title"
                            value="{{ $career->title }}" id="title">
                        @error('title')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class=" form-label">Career Category</label>
                        <select class="form-select form-control-solid mb-2" name="category_id" data-kt-select2="true"
                            id="category_id" data-server="true" data-placeholder="Select Career Category"
                            data-option-url="{{ route('options_career_category') }}" value="{{ old('category_id') }}">
                            @if (isset($old['category_id']) && $old['category_id'] != '')
                                <option value="{{ $old['category_id']->id }}">
                                    {{ $old['category_id']->name_en }}
                                </option>
                            @endif
                        </select>
                    </div>
                    <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class=" form-label">Vaccancy</label>
                        <input type="number" name="vaccancy" class="form-control mb-2" placeholder="Vaccancy"
                            value="{{ $career->vaccancy }}" id="vaccancy">
                        @error('vaccancy')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class="form-label">Experience</label>
                        <input type="number" name="experience" class="form-control mb-2" placeholder="Experience"
                            value="{{ $career->experience }}" id="experience">
                        @error('experience')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>

                    <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                        <label for="employment" class="form-label">Employment
                        </label>
                        <select class="form-control" data-control="select2" data-hide-search="true" id="employment"
                            name="employment">
                            <option value="full_time" @if ($career->employment == 'full_time') selected @endif>Full time
                            </option>
                            <option value="part_time" @if ($career->employment == 'part_time') selected @endif>Part time
                            </option>
                            <option value="contract" @if ($career->employment == 'contract') selected @endif>Contract
                            </option>
                        </select>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <input type="hidden" name="model" id="model" value="Modules\Career\Entities\Career">

                    @include('cms::admin.contents.tabEdit.editContentTab')
                </div>
            </div>
            <div class="d-flex justify-content-end">

                <a href="{{ route('career_list') }}" class="btn btn-light me-5">Cancel</a>
                <button type="submit" id="btnSubmit" class="btn btn-primary">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>

        </div>
    </form>
    </x-admin-layout>
