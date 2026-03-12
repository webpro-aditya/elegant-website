    <div class="bg-white drawer" id="kt_drawer_add_main_module" data-kt-drawer-close="#kt_drawer_add_main_module_close"
        data-kt-drawer="true" data-kt-drawer-name="main_module" data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
        data-kt-drawer-width="35%">

        <div class="card shadow-none border-0 rounded-0">
            <div class="card-header" id="kt_drawer_add_main_module_header">
                <h3 class="card-title fw-bold text-gray-900">Add Syllabus</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                        id="kt_drawer_add_main_module_close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
            </div>
            <div class="card-body position-relative" id="kt_drawer_add_main_module_body">
                <form novalidate="novalidate" id="addMainModuleForm" action="{{ route('course_main_module_create') }}"
                    method="POST" class="form ">
                    @csrf
                    <input type="hidden" name="course_id" id="course_id" value="{{ $course_id }}">

                    <ul class="nav nav-tabs nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent mb-8 fs-5 fw-bold px-5"
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

                    <div class="tab-content" id="languageTabsContent">
                        @foreach ($languages as $id => $language)
                            @php
                                $languageCode = strtolower($language);
                            @endphp
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="language-{{ $id }}" role="tabpanel"
                                aria-labelledby="language-{{ $id }}-tab">
                                <!-- Select Dropdown -->
                                <div class="col-md-12">
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label class="required fw-semibold fs-6 mb-2">Title
                                            {{ $languageCode }}</label>
                                            <input type="text" name="title[{{ $languageCode }}]"
                                        id="title_{{ $languageCode }}"
                                        class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Title"
                                        value="" />
                                          
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
                                    <label class="required fw-semibold fs-6 mb-2">Heading {{ $languageCode }}</label>
                                    <input type="text" name="heading[{{ $languageCode }}]"
                                        id="heading_{{ $languageCode }}"
                                        class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Heading"
                                        value="" />
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

                                    <textarea id="description_{{ $languageCode }}" name="description[{{ $languageCode }}]" data-kt-tinymce-editor="true"
                                        data-kt-initialized="false" class="form-control min-h-200px mb-2"></textarea>

                                    @error('description.' . $languageCode)
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="fs-6 fw-semibold mb-2">Status</label>
                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                            data-placeholder="Select Status " name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="text-center pt-10">
                        <button type="button" class="btn btn-primary" id="kt_drawer_add_main_module_close">Discard
                        </button>
                        <button type="submit" class="btn btn-primary" data-kt-drawer-submit="true"
                            data-kt-refresh-table="listMainModules">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
