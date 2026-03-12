@section('title', 'Edit Main Module')

@push('script')
    <script src="{{ mix('js/admin/course/mainModule/editMainModule.js') }}"></script>
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
        </x-toolbar>
    @endsection


    <div class="card">
        <div class="card-header">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold px-5"
                role="tablist">
                @foreach ($languages as $id => $language)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary py-5 me-6 {{ $loop->first ? 'active' : '' }}"
                            id="language-{{ $id }}-tab" data-bs-toggle="tab" href="#language-{{ $id }}" role="tab"
                            aria-controls="language-{{ $id }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            {{ strtoupper($language) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body pt-0">
            <div class="card shadow-none border-0 rounded-0">
                <div class="card-body position-relative">
                    <form novalidate="novalidate" id="editMainModuleForm"
                        action="{{ route('course_main_module_update') }}" method="POST"
                        class="form fv-plugins-bootstrap5 fv-plugins-framework">
                        @csrf
                        <input type="hidden" name="course_id" id="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="id" value="{{ $module->id }}">

                        <div class="row">
                            <div class="tab-content" id="languageTabsContent">

                                @foreach ($languages as $id => $language)
                                    @php
                                        $languageCode = strtolower($language);
                                        $syllabusLocale = isset($syllabusLocales[$languageCode])
                                            ? $syllabusLocales[$languageCode]->first()
                                            : null; // Check if data is available for the current language

                                    @endphp
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                        id="language-{{ $id }}" role="tabpanel" aria-labelledby="language-{{ $id }}-tab">
                                        <!-- Select Dropdown -->
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column mb-8 fv-row">
                                                <label class="required fw-semibold fs-6 mb-2">Title
                                                    {{ $languageCode }}</label>
                                                <input type="text" name="title[{{ $languageCode }}]"
                                                    id="title_{{ $languageCode }}"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    value="{{ old('title.' . $languageCode) ?? ($syllabusLocale->title ?? '') }}"
                                                    placeholder="Title" />

                                                {{-- data-option-url="{{ route('course_all_titles') }}" --}}
                                                @error('title.' . $languageCode)
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Heading Input -->
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="required fw-semibold fs-6 mb-2">Heading
                                                {{ $languageCode }}</label>
                                            <input type="text" name="heading[{{ $languageCode }}]"
                                                id="heading_{{ $languageCode }}"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                value="{{ old('heading.' . $languageCode) ?? ($syllabusLocale->heading ?? '') }}"
                                                placeholder="Heading" />
                                            @error('heading.' . $languageCode)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Description Textarea -->
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="required fw-semibold fs-6 mb-2">Description
                                                {{ $languageCode }}</label>

                                            <textarea id="description_{{ $languageCode }}"
                                                name="description[{{ $languageCode }}]" data-kt-tinymce-editor="true"
                                                data-kt-initialized="false"
                                                class="form-control min-h-200px mb-2">{!! old('description.' . $languageCode) ?? ($syllabusLocale->description ?? '') !!}</textarea>

                                            @error('description.' . $languageCode)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="required fw-semibold fs-6 mb-2">Sort Order</label>
                                <input type="number" name="sort_order" id="sort_order"
                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                    value="{{ old(key: 'sort_order') ?? ($module->sort_order ?? '') }}"
                                    placeholder="Sort Order" />

                                @error('sort_order')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Status</label>
                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                data-placeholder="Select Status " name="status">
                                <option value="active" @if(isset($module) && isset($module->status) && $module->status == 'active') selected @endif>Active</option>
                                <option value="inactive" @if(isset($module) && isset($module->status) && $module->status == 'inactive') selected @endif>Inactive</option>
                            </select>
                        </div>
                        <div class="text-center pt-10">
                            <a href="{{ route('course_main_module_list', ['id' => $course->id]) }}"
                                class="btn btn-light me-5">Cancel</a>
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">Save
                                Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>