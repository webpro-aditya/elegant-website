@section('title', 'Add Course')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/course/addCourse.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/course/addCourse.js') }}"></script>
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs"></x-toolbar>
    @endsection
    <form novalidate="novalidate" id="addCourseForm" class="form " action="{{ route('course_create') }}"
        enctype="multipart/form-data" method="POST">
        @csrf

        <div class="row m-0">
            <div class="card h-lg-100">
                <div class="card-body">
                    <div class="row col-md-12">
                        <h2 class="mb-10">Course Details</h2>
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
                                        $isArabic = strtolower($language) === 'ar';
                                    @endphp
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                        id="language-{{ $id }}" role="tabpanel"
                                        aria-labelledby="language-{{ $id }}-tab">
                                        <div class="mb-3 language-input" data-language="{{ $id }}">
                                            <label for="title_{{ $language }}" class="form-label ">Title
                                                ({{ $language }})
                                            </label>
                                            <input type="text" class="form-control"
                                                @if ($isArabic) dir="rtl" @endif
                                                id="title_{{ $language }}"
                                                name="title[{{ strtolower($language) }}]"
                                                value="{{ old('title.' . strtolower($language)) }}"
                                                placeholder="Title ({{ $language }})">
                                                @error('title.' . strtolower($language))
                                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Course Category</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-12 row">
                                        <select class="form-select form-control-solid mb-2" name="category_id"
                                            id="category_id" data-kt-select2="true" data-server="true"
                                            data-placeholder="Select Category"
                                            data-option-url="{{ route('course_all_categories') }}">
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Mode of Learning</label>
                            <div class="col-lg-8 fv-row">
                                <label class="d-flex flex-stack mb-5 cursor-pointer">
                                    <span class="d-flex align-items-center me-2">
                                        <span class="symbol symbol-50px me-6">
                                            <span class="symbol-label bg-light-primary">
                                                <i class="ki-duotone ki-compass fs-1 text-primary"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                            </span>
                                        </span>
                                        <span class="d-flex flex-column">
                                            <span class="fw-bold fs-6">Online</span>
                                            <span class="fs-7 text-muted">Online classes bring education to your
                                                fingertips, offering flexibility and accessibility for learning anytime,
                                                anywhere.</span>
                                        </span>
                                    </span>
                                    <span class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="mode_of_learning[]"
                                            value="online" />
                                    </span>
                                </label>
                                <label class="d-flex flex-stack mb-5 cursor-pointer">
                                    <span class="d-flex align-items-center me-2">
                                        <span class="symbol symbol-50px me-6">
                                            <span class="symbol-label bg-light-danger">
                                                <i class="ki-duotone ki-element-11 fs-1 text-danger"><span
                                                        class="path1"></span><span class="path2"></span><span
                                                        class="path3"></span><span class="path4"></span></i>
                                            </span>
                                        </span>
                                        <span class="d-flex flex-column">
                                            <span class="fw-bold fs-6">Offline</span>
                                            <span class="fs-7 text-muted">
                                                An offline course, also known as a traditional or in-person course, is a
                                                form of education where instruction and learning activities take place
                                                in a physical classroom or other designated locations rather than
                                                online. </span>
                                        </span>
                                    </span>
                                    <span class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="mode_of_learning[]"
                                            value="offline" />
                                    </span>
                                </label>
                               
                            </div>
                        </div> --}}

                        <input type="hidden" name="mode_of_learning[]" id="mode_of_learning" value="offline">

                        <div class="d-flex justify-content-end">
                            <button type="button"
                                class="btn btn-light btn-active-light-primary me-2 fv-button-back">Back</button>
                            <button type="submit" id="btnSubmit" class="btn btn-primary ">
                                <span class="indicator-label">Save Changes</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</x-layout>
